<?php

/**
 * Plugin Name: Omniweb Showtimes
 * Description: Display your theatres showtimes using Omniweb by Omniterm.
 * Plugin URI:  https://github.com/lancehmd/omniweb-showtimes
 * Version:     1.5.0
 * Author:      Lance Hammond
 * Author URI:  https://github.com/lancehmd
 * License:     MIT
 * License URI: https://opensource.org/licenses/MIT
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

date_default_timezone_set('America/Toronto');

include dirname(__FILE__).'/includes/admin-page-framework/admin-page-framework.php';

include_once __DIR__.'/includes/os-core-functions.php';

include_once __DIR__.'/includes/class-omniweb-showtimes-helpers.php';
include_once __DIR__.'/includes/class-omniweb-showtimes-settings.php';
include_once __DIR__.'/includes/class-omniweb-showtimes-theatres.php';
include_once __DIR__.'/includes/class-omniweb-showtimes-coming-soon.php';
include_once __DIR__.'/includes/class-omniweb-showtimes-shortcodes.php';
require_once __DIR__.'/includes/class-omniweb-showtimes-widgets.php';
include_once __DIR__.'/includes/class-omniweb-showtimes-ftp.php';

class Omniweb_Showtimes
{
    /**
     * Plugin settings array.
     */
    public $plugin_settings;

    /**
     * The scheduled event.
     */
    public $event_slug;

    /**
     * Plugin constructor.
     */
    public function __construct()
    {
        $this->plugin_settings = get_option('omniweb_showtimes_settings');
        //$this->event_slug = wp_next_scheduled('download_omniweb_content_daily');

        //register_activation_hook(__FILE__, [$this, 'activate']);
        //register_deactivation_hook(__FILE__, [$this, 'deactivate']);

        //add_action('download_omniweb_content_daily', [$this, 'download_omniweb_content']);

        add_action('wp_enqueue_scripts', [$this, 'enqueue_public_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('wp_head', [$this, 'head_scripts']);

        add_action('widgets_init', [$this, 'unregister_default_widgets'], 11);
    }

    /**
     * Remove useless widgets.
     */
    public function unregister_default_widgets()
    {
        unregister_widget('WP_Widget_Pages');
        unregister_widget('WP_Widget_Calendar');
        unregister_widget('WP_Widget_Archives');
        unregister_widget('WP_Widget_Links');
        unregister_widget('WP_Widget_Meta');
        unregister_widget('WP_Widget_Categories');
        unregister_widget('WP_Widget_Recent_Posts');
        unregister_widget('WP_Widget_Recent_Comments');
        unregister_widget('WP_Widget_RSS');
        unregister_widget('WP_Widget_Tag_Cloud');
    }

    /**
     * Runs when plugin is activated.
     *
     * Register and hook our scheduled function.
     */
    public function activate()
    {
        $timestamp = wp_next_scheduled('download_omniweb_content_daily');

        if ($timestamp == false) {
            wp_schedule_event(mktime(0, 0, 0), 'hourly', 'download_omniweb_content_daily');
        }
    }

    /**
     * Runs when plugin is deactivated.
     *
     * Remove our scheduled hook.
     */
    public function deactivate()
    {
        wp_clear_scheduled_hook('download_omniweb_content_daily');
    }

    /**
     * Download the Omniweb schedules.
     *
     * Connect to the FTP saved in settings and iterate through root folders,
     * downloading each folder and files.
     */
    public function download_omniweb_content()
    {
        // The directory to download files to.
        $omniwebFolder = WP_CONTENT_DIR.DIRECTORY_SEPARATOR.'omniweb'.DIRECTORY_SEPARATOR;

        // Make sure directory exists.
        if (!file_exists($omniwebFolder)) {
            mkdir($omniwebFolder, 0755, true);
        }

        // Retrieve settings.
        $server = $this->plugin_settings['ftp_host'];
        $ftpUser = $this->plugin_settings['ftp_username'];
        $ftpPassword = $this->plugin_settings['ftp_password'];
        // $isPassive   = $this->plugin_settings['ftp_passive'];

        // Initiate the FTP connection
        $ftp = new Omniweb_Showtimes_FTP;
        $ftp->connect($server, $ftpUser, $ftpPassword);

        foreach ($ftp->ls() as $pathName => $pathInfo) {
            if ($pathInfo['type'] === 'directory') {
                // Move into new directory.
                $ftp->cd($pathName);

                $thisDir = $omniwebFolder.$pathName;

                // Make sure this directory exists locally before downloading.
                if (!file_exists($thisDir)) {
                    mkdir($thisDir, 0755, true);
                }

                // Download dem filez yo.
                foreach ($ftp->ls() as $fileName => $fileInfo) {
                    if ($fileInfo['type'] === 'file') {
                        $ftp->cp($fileName, "$thisDir/$fileName");
                    }
                }

                // Move back into parent directory.
                $ftp->cd('..');
            }
        }
    }

    /**
     * Enqueue our public frontend assets.
     */
    public function enqueue_public_assets()
    {
        wp_enqueue_script('owst-public', plugin_dir_url(__FILE__).'assets/js/owst-public.min.js', [], null, true);
        wp_enqueue_style('lity', '//cdnjs.cloudflare.com/ajax/libs/lity/1.6.6/lity.min.css', [], '1.6.6');
        wp_enqueue_script('lity', '//cdnjs.cloudflare.com/ajax/libs/lity/1.6.6/lity.min.js', ['jquery'], '1.6.6', true);
    }

    /**
     * Denqueue our admin backend assets.
     */
    public function enqueue_admin_assets()
    {
        wp_enqueue_style('owst-admin', plugin_dir_url(__FILE__).'assets/css/owst-admin.css', [], null);
        wp_enqueue_script('owst-admin', plugin_dir_url(__FILE__).'assets/js/owst-admin.js', array('jquery'), null);
    }

    /**
     * Put some dynamic scripts directly in the HTML head for our frontend
     * scripts to use.
     */
    public function head_scripts()
    {
        $theatres = [];
        $args     = [
            'post_type' => 'theatre',
            'nopaging'  => true,
            'meta_key'  => '_theatre_code',
            'orderby'   => 'meta_value_num',
            'order'     => 'ASC'
        ];
        $query = new WP_Query($args);
        $posts = $query->posts;

        foreach ($posts as $i => $post) {
            $code = get_post_meta($post->ID, '_theatre_code', true);
            $lat  = get_post_meta( $post->ID, '_theatre_latitude', true );
            $lng  = get_post_meta( $post->ID, '_theatre_longitude', true );

            $theatre            = new stdClass;
            $theatre->code      = $code;
            $theatre->latitude  = $lat;
            $theatre->longitude = $lng;

            $theatres[] = $theatre;
        }

        $theatresScript = 'var cinemaLocations = '.json_encode($theatres, JSON_NUMERIC_CHECK).';';

        echo '<script>'.$theatresScript.'</script>';
    }
}

// Initialize plugin!
new Omniweb_Showtimes;

// Register plugin settings.
new Omniweb_Showtimes_Settings;

// Register theatre post type and settings.
new Omniweb_Showtimes_Theatres;

// Register coming soon settings.
new Omniweb_Showtimes_Coming_Soon;

// Register our shortcodes.
new Omniweb_Showtimes_Shortcodes;

// Register our widgets.
new Omniweb_Showtimes_Theatre_Widget;
new Omniweb_Showtimes_Theatre_Tickets_Widget;
