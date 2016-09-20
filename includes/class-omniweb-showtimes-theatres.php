<?php

use Omniweb_Showtimes_Helpers as Helpers;

class Omniweb_Showtimes_Theatres {

    private $slug = 'theatre';

    private $fields = [
        'schedule',
        'street',
        'street2',
        'city',
        'province',
        'postal_code',
        'latitude',
        'longitude',
        'phone_number',
        'fax_number',
        'showtimes_number',
        'email_address',
        'facebook_page',
        'twitter_page',
        'google_page',
        'code',
    ];

    /**
     * Our class constructor
     */
	public function __construct()
    {
        add_action('init', [$this, 'register_post_type']);

        add_action('add_meta_boxes', [$this, 'information_meta_box_register']);
        add_action('save_post_theatre', [$this, 'information_meta_box_save'], 10, 2);

        add_filter('the_content', [$this, 'theatre_content_hook']);
        // add_filter('template_include', [$this, 'template_chooser']);
	}

    /**
     * Get the custom template if is set
     */
    function get_template_hierarchy($template)
    {
        // Get the template slug
        $template_slug = rtrim($template, '.php');
        $template = $template_slug.'.php';

        // Check if a custom template exists in the theme folder, if not, load the plugin template file
        if ($theme_file = locate_template(['omniweb-showtimes/'.$template])) {
            $file = $theme_file;
        } elseif (file_exists(__DIR__.'/../templates/'.$template)) {
            $file = __DIR__.'/../templates/'.$template;
        } else {
            $theme_file = locate_template([$template]);
            $file       = $theme_file;
        }

        return apply_filters('rc_repl_template_'.$template, $file);
    }



    /**
     * Returns template file
     */
    function template_chooser($template)
    {
        $post_id = get_the_ID();

        // For all other CPT
        if (get_post_type($post_id) != 'theatre') {
            return $template;
        }

        // Else use custom template
        if (is_post_type_archive('theatre')) {
            return $this->get_template_hierarchy('archive');
        } elseif (is_single()) {
            return $this->get_template_hierarchy('single');
        }
    }

    /**
     * Register theatre post type.
     */
    public function register_post_type()
    {
        $labels = [
    		'name'                  => _x('Theatres', 'Post Type General Name', 'omniweb-showtimes'),
    		'singular_name'         => _x('Theatre', 'Post Type Singular Name', 'omniweb-showtimes'),
    		'menu_name'             => __('Theatres', 'omniweb-showtimes'),
    		'name_admin_bar'        => __('Theatres', 'omniweb-showtimes'),
    		'all_items'             => __('All Theatres', 'omniweb-showtimes'),
    		'add_new_item'          => __('Add New Theatre', 'omniweb-showtimes'),
    		'add_new'               => __('Add New', 'omniweb-showtimes'),
    		'new_item'              => __('New Theatre', 'omniweb-showtimes'),
    		'edit_item'             => __('Edit Theatre', 'omniweb-showtimes'),
    		'update_item'           => __('Update Theatre', 'omniweb-showtimes'),
    		'view_item'             => __('View Theatre', 'omniweb-showtimes'),
    		'search_items'          => __('Search Theatre', 'omniweb-showtimes'),
    		'not_found'             => __('Not found', 'omniweb-showtimes'),
    		'not_found_in_trash'    => __('Not found in Trash', 'omniweb-showtimes'),
    		'featured_image'        => __('Logo', 'omniweb-showtimes'),
    		'set_featured_image'    => __('Set logo', 'omniweb-showtimes'),
    		'remove_featured_image' => __('Remove logo', 'omniweb-showtimes'),
    		'use_featured_image'    => __('Use as logo', 'omniweb-showtimes'),
    		'insert_into_item'      => __('Insert into theatre', 'omniweb-showtimes'),
    		'uploaded_to_this_item' => __('Uploaded to this theatre', 'omniweb-showtimes'),
    		'items_list'            => __('Theatres list', 'omniweb-showtimes'),
    		'items_list_navigation' => __('Theatres list navigation', 'omniweb-showtimes'),
    		'filter_items_list'     => __('Filter theatres list', 'omniweb-showtimes'),
    	];

    	$rewrite = [
    		'slug'       => 'cinema',
    		'with_front' => true,
    		'pages'      => true,
    		'feeds'      => true
    	];

    	$args = [
    		'label'               => __('Theatre', 'omniweb-showtimes'),
    		'labels'              => $labels,
    		'supports'            => ['title', 'thumbnail'],
    		'hierarchical'        => false,
    		'public'              => true,
    		'show_ui'             => true,
    		'show_in_menu'        => true,
    		'menu_position'       => 20,
    		'menu_icon'           => 'dashicons-store',
    		'show_in_admin_bar'   => true,
    		'show_in_nav_menus'   => true,
    		'can_export'          => true,
    		'has_archive'         => 'cinemas',
    		'exclude_from_search' => false,
    		'publicly_queryable'  => true,
    		'rewrite'             => $rewrite,
    		'capability_type'     => 'page',
    	];

    	register_post_type('theatre', $args);
    }

    /**
     * Register the metabox.
     */
    public function information_meta_box_register()
    {
        $id        = 'theatre_information';
        $title     = __('Information', 'omniweb-showtimes');
        $callback  = [$this, 'information_meta_box_render'];
        $post_type = 'theatre';
        $context   = 'normal';
        $priority  = 'default';

        add_meta_box($id, $title, $callback, $post_type, $context, $priority);
    }

    /**
     * Render the metabox.
     */
    public function information_meta_box_render($post)
    {
        wp_nonce_field(basename(__FILE__), 'theatre_information_nonce');

        $scheduleFiles = scandir(WP_CONTENT_DIR.'/omniweb/schedule/');
        array_splice($scheduleFiles, 0, 2);

        $data = array();
        foreach ($this->fields as $field) {
            $data[$this->slug.'_'.$field] = get_post_meta($post->ID, '_'.$this->slug.'_'.$field, true);
        }

        $provinces = array(
            'AB' => 'Alberta',
            'BC' => 'British Columbia',
            'MB' => 'Manitoba',
            'NB' => 'New Brunswick',
            'NL' => 'Newfoundland and Labrador',
            'NT' => 'Northwest Territories',
            'NS' => 'Nova Scotia',
            'NU' => 'Nunavut',
            'ON' => 'Ontario',
            'PE' => 'Prince Edward Island',
            'QC' => 'Quebec',
            'SK' => 'Saskatchewan',
            'YT' => 'Yukon',
        );

        include_once __DIR__.'/../templates/meta-boxes/theatre-information.php';
    }

    /**
     * Save the metabox values.
     */
    public function information_meta_box_save($post_id)
    {
        if (
            !isset($_POST['theatre_information_nonce'])
            || !wp_verify_nonce($_POST['theatre_information_nonce'], basename(__FILE__))
        ) {
        	return;
        }

        foreach ($this->fields as $field) {
            if (isset( $_REQUEST[$this->slug.'_'.$field])) {
                update_post_meta($post_id, '_'.$this->slug.'_'.$field, sanitize_text_field($_POST[$this->slug.'_'.$field]));
            }
        }
    }

    /**
     * Get the index of a single multidimensional array key.
     */
    public function getIndex($name, $key, $array)
    {
        foreach ($array as $i => $value) {
            if (is_array($value) && $value[$key] == $name) {
                return $i;
            }
        }

        return;
    }

    function array_orderby()
    {
        $args = func_get_args();
        $data = array_shift($args);

        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row)
                    $tmp[$key] = $row[$field];
                $args[$n] = $tmp;
                }
        }

        $args[] = &$data;

        call_user_func_array('array_multisort', $args);

        return array_pop($args);
    }

    /**
     * Hook into the content to inject the theatre showtimes.
     */
    public function theatre_content_hook($content)
    {
        if (is_singular('theatre')) {
            $theatreId     = get_the_ID();
            $date          = (empty($_GET['date'])) ? date('Y-m-d') : $_GET['date'];
            $scheduleId    = get_post_meta($theatreId, '_theatre_code', true);
            $postersUrl    = wp_make_link_relative(content_url().'/omniweb/poster/');
            $thumbnailsUrl = wp_make_link_relative(content_url().'/omniweb/thumbnail/');

            $keys = [
                'schedule_date'        => 'date',
                'titlecode'            => 'code',
                'titlename'            => 'title',
                'languagesound'        => 'language',
                'languagesubtitle'     => 'subtitle',
                'trailer_url'          => 'trailer',
                'performanceid'        => 'id',
                'showtime'             => 'time',
                'no_passes_until_date' => 'passes',
                'omniweb_url'          => 'url',
            ];

            foreach ($keys as $key => $value) {
                $keySearch[]  = $key;
                $keyReplace[] = $value;
            }

            $options = [
                'alwaysArray' => ['schedule_day', 'film', 'performance'],
                'keySearch'   => $keySearch,
                'keyReplace'  => $keyReplace,
            ];

            $xmlFile  = glob(WP_CONTENT_DIR."/omniweb/schedule/*$scheduleId*.xml")[0];
            $xmlNode  = simplexml_load_file($xmlFile);
            $xmlArray = Helpers::xml_to_array($xmlNode, $options);

            if (isset($xmlArray['schedule']['schedule_days']['schedule_day'])) {
                $schedule        = $xmlArray['schedule'];
                $theatreSchedule = $schedule['schedule_days']['schedule_day'];

                $scheduleDateIndex = $this->getIndex($date, 'date', $theatreSchedule);
                $scheduledFilms    = $theatreSchedule[$scheduleDateIndex]['film'];
                // $scheduledFilms    = array_reverse($scheduledFilms);

                foreach ($scheduledFilms as $film) {
                    if (preg_match('/3d/i', $film['title'])) {
                        $index = $this->getIndex($film['title'], 'title', $scheduledFilms);
                        $films3d[] = [
                            'title'        => $film['title'],
                            'code'         => $film['code'],
                            'performances' => array_splice($scheduledFilms[$index]['performances']['performance'], 0),
                        ];

                        unset($scheduledFilms[$index]);
                    }
                }

                include_once Helpers::get_template('partials/change-date');

                echo '<div class="movie-showtimes">';

                foreach ($scheduledFilms as $film) {
                    if (isset($films3d)) {
                        foreach ($films3d as $film3d) {
                            similar_text($film3d['title'], $film['title'], $percent);

                            if ($percent > 50) {
                                $film['code_3d'] = $film3d['code'];
                                $film['performances']['performance_3d'] = $film3d['performances'];
                            }
                        }
                    }

                    if (stristr($film['title'], 'TOIFF – ')):
                        $film_title = explode(' – ', $film['title']);
                        $title = $film_title[1];
                        $subtitle = $film_title[0];
                    else:
                        $title = $film['title'];
                        $subtitle = null;
                    endif;

                    $poster = os_get_poster($film['title'], $film['thumbnail']);
                    $trailer = (isset($film['trailer']) && !is_array($film['trailer']))?$film['trailer']:null;

                    if (isset($_GET['print'])) {
                        include Helpers::get_template('partials/movie-showtime-print');
                    } elseif (isset($_GET['email'])) {
                        include Helpers::get_template('partials/movie-showtime-email');
                    } else {
                        include Helpers::get_template('partials/movie-showtime');
                    }
                }

                echo '</div>';

                $coming_soon = get_option('Omniweb_Showtimes_Coming_Soon', []);
                $coming_soon_movies = isset($coming_soon['movies'])?$coming_soon['movies']:null;
                $has_coming_soon = false;

                foreach ($coming_soon_movies as $movie):
                    if (!$movie['movie_theatres'][$theatreId]) continue;
                    $has_coming_soon = true;
                endforeach;

                if ($has_coming_soon):
                    include Helpers::get_template('partials/coming-soon-theatre');
                endif;

            } else {
                echo 'Sorry, something seems to be broken. The server kittens have been deployed. Check back soon.';
            }
        } else {
            return $content;
        }
    }
}

class Omniweb_Showtimes_Theatres_TicketMeta extends OmniwebShowtimes_AdminPageFramework_MetaBox {
    /*
     * Use the setUp() method to define settings of this meta box.
     */
    public function setUp() {
        /*
         * Create tabbed sections.
         */
        $this->addSettingSections(
            array(
                'section_id'  => 'theatre_tickets',
                'title'  => 'Ticket',
                'collapsible' => array(
                    'title'     => 'Ticket',
                    'container' => 'section'
                ),
                'attributes' => array(
                    'data-block' => 'owst-theatre__tickets',
                ),
                'repeatable'  => true,
                'sortable'    => true,
            )
        );

        /**
         * Adds setting fields in the meta box.
         */
        // $this->addSettingFields(
        //     array(
        //         'field_id' => 'description',
        //         'type'     => 'section_title',
        //         'title'    => 'Tickets'
        //     )
        // );

        /**
         * Adds setting fields in the meta box.
         */
        $this->addSettingFields(
            'theatre_tickets',
            array(
                'field_id' => '_name',
                'type'     => 'section_title',
                'attributes' => array(
                    'placeholder' => 'Ticket Name',
                    'style' => 'width: 140px;margin-bottom: 4px;',
                ),
            ),
            array(
                'field_id' => '_description',
                'type'     => 'text',
                'attributes' => array(
                    'placeholder' => 'Description',
                    'style' => 'width: 100%;',
                )
            ),
            array(
                'field_id'  => '_price',
                'type'      => 'number',
                'attributes' => array(
                    'style' => 'width: 70px; font-family: monospace;',
                    'min' => 0.00,
                    'step' => 0.25,
                    'placeholder' => 'Price'
                )
            )
        );
    }
}
new Omniweb_Showtimes_Theatres_TicketMeta(
    null,               // meta box ID - can be null.
    'Tickets',          // title
    array( 'theatre' ), // post type slugs: post, page, etc.
    'side',           // context
    'low'               // priority
);
