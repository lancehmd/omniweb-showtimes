<?php

use Omniweb_Showtimes_Helpers as Helpers;

class Omniweb_Showtimes_Theatre_Widget extends WP_Widget
{
    public $fields = [
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
    ];

	public function __construct()
    {
        $widget_slug = 'theatre-information';
        $widget_name = __('Theatre Information', 'omniweb-showtimes');
        $widget_attr = [
            'classname'   => 'theatre-information-widget',
            'description' => __('Show the displayed theatres information.', 'omniweb-showtimes')
        ];

        parent::__construct($widget_slug, $widget_name, $widget_attr);

        add_action('widgets_init', [$this, 'register']);
	}

	public function widget($args, $instance)
    {
        if (is_single()) {
            if (!isset($args['widget_id'])) {
                $args['widget_id'] = $this->id;
            }

            extract($args, EXTR_SKIP);

            if (is_singular('theatre')) {
                $theatre_id = get_the_ID();

                if (empty($_GET['code'])) {
                    $code = get_post_meta($theatre_id, 'theatre_code', true);
                } else {
                    $code = $_GET['code'];
                }

                $data = [];
                $data['theatre_name'] = get_the_title($theatre_id);

                foreach ($this->fields as $field) {
                    $data['theatre_'.$field] = get_post_meta($theatre_id, '_theatre_'.$field, true);
                }

                echo $before_widget;

                // include_once __DIR__.'/../templates/widgets/theatre-information.php';

                include Helpers::get_template('widgets/theatre-information');

                echo $after_widget;
            }
        }
	}

	public function form($instance)
    {
        echo '<h4>No configuration needed.</h4>';
        echo '<p>This will automatically show theatre information for theatre pages.</p>';
	}

    public function register()
    {
        register_widget('Omniweb_Showtimes_Theatre_Widget');
    }
}

class Omniweb_Showtimes_Theatre_Tickets_Widget extends WP_Widget
{
	public function __construct()
    {
        $widget_slug    = 'theatre-tickets';
        $widget_name    = __('Theatre Tickets', 'omniweb-showtimes');
        $widget_attr = [
            'classname'   => 'theatre-tickets-widget',
            'description' => __('Display the current theatres ticket prices.', 'omniweb-showtimes')
        ];

        parent::__construct($widget_slug, $widget_name, $widget_attr);

        add_action('widgets_init', [$this, 'register']);
	}

	public function widget($args, $instance)
    {
        if (is_singular('theatre')) {
            if (!isset($args['widget_id'])) {
                $args['widget_id'] = $this->id;
            }

            $theatre_id = get_the_ID();
            $tickets    = [];
            $tickets    = get_post_meta($theatre_id, 'theatre_tickets', true);

            extract($args, EXTR_SKIP);

            echo $before_widget;

            include Helpers::get_template('widgets/theatre-tickets');

            echo $after_widget;
        }
	}

	public function form($instance)
    {
        echo '<h4>No configuration needed.</h4>';
        echo '<p>This will automatically show theatre tickets for theatre pages.</p>';
	}

    public function register()
    {
        register_widget('Omniweb_Showtimes_Theatre_Tickets_Widget');
    }
}
