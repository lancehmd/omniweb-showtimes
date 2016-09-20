<?php

class Omniweb_Showtimes_Settings
{
	public function __construct()
    {
		add_action('admin_menu', [$this, 'add_settings_submenu_page']);
	}

    public function add_settings_submenu_page()
    {
        $parent_slug = 'options-general.php';
        $page_title  = 'Omniweb Showtimes Settings';
        $menu_title  = 'Omniweb';
        $capability  = 'manage_options';
        $menu_slug   = 'omniweb-settings';
        $callback    = [$this, 'render_settings_submenu_page'];

        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $callback);
    }

    public function render_settings_submenu_page()
    {
		if (isset($_POST['updated'])) {
			$this->handle_form();
		}

        $settings = get_option('omniweb_showtimes_settings');

        include_once __DIR__ . '/../templates/omniweb-showtimes-settings.php';
    }

	public function handle_form()
    {
	    if (
			!isset($_POST['os_nonce']) ||
			!wp_verify_nonce($_POST['os_nonce'], 'update_settings')
		) {
			echo 'Sorry, there was trouble verifying.';
	    	exit;
	    } else {
			$updated_settings = [
				'ftp_host'     => $_POST['ftp_host'],
                'ftp_username' => $_POST['ftp_username'],
                'ftp_password' => $_POST['ftp_password'],
			];

			update_option('omniweb_showtimes_settings', $updated_settings);
	    }
	}
}
