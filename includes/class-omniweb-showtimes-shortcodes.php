<?php

use Omniweb_Showtimes_Helpers as Helpers;

class Omniweb_Showtimes_Shortcodes
{
    public function __construct()
    {
        add_shortcode('coming_soon', [$this, 'short_code_coming_soon']);
        add_shortcode('choose_theatre', [$this, 'short_code_choose_theatre']);
    }

    /**
     * Render the coming soon short code
     *
     * @return html
     */
    public function short_code_coming_soon()
    {
        $data = get_option('Omniweb_Showtimes_Coming_Soon', []);
        $movies = isset($data['movies']) ? $data['movies'] : $data['movies'];

        include_once Helpers::get_template('partials/coming-soon');
    }

    /**
     * Render the short code for choosing a theatre and date for showtimes.
     *
     * @return html
     */
    public function short_code_choose_theatre()
    {
        $date     = date_create();
        $today    = date_format($date, 'Y-m-d');
        $new_date = date_format($date, 'Y-m-d');
        $dates    = [];

        for ($i=0; $i < 7; $i++) {
            $fancy_date       = date ('l, F d', strtotime($new_date, strtotime($new_date)));
            $dates[$new_date] = $fancy_date;
            $new_date         = date ('Y-m-d', strtotime('+1 day', strtotime($new_date)));
        }

        $theatre_query_args = [
            'post_type' => 'theatre',
            'nopaging'  => true,
            'meta_key'  => '_theatre_city',
            'orderby'   => 'meta_value',
            'order'     => 'ASC',
        ];

        $theatre_query = new WP_Query($theatre_query_args);
        $post_titles   = [];

        foreach ($theatre_query->posts as $index => $post) {
            $post_titles[$post->ID] = $post->post_title;
        }

        $theatres = [];

        foreach ($theatre_query->posts as $index => $post) {
            $theatre_code  = get_post_meta($post->ID, '_theatre_code', true);
            $current_city  = get_post_meta($post->ID, '_theatre_city', true);

            $theatres[$current_city][] = [
                'id' => $post->ID,
                'code' => $theatre_code,
                'slug' => $post->post_name,
                'name' => $post->post_title
            ];
        }

        foreach ($dates as $key => $value) {
            $selected = null;
            ($key === $today) ? $selected = 'selected' : null;
        }

        include_once Helpers::get_template('partials/find-showtime');
    }
}
