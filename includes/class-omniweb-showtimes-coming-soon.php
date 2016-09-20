<?php

class Omniweb_Showtimes_Coming_Soon extends OmniwebShowtimes_AdminPageFramework
{
    // The page slug to add the tab and form elements.
    public $pageSlug  = 'coming_soon';

    /**
     * The set-up method which is triggered automatically with the 'wp_loaded' hook.
     */
    public function setUp()
    {
        $this->setRootMenuPage('Coming Soon', 'dashicons-format-video', 20);

        $this->addSubMenuItems([
            'title'     => 'Coming Soon',
            'page_slug' => $this->pageSlug
        ]);
    }

    public function load_coming_soon($oAdminPage)
    {
        $this->addSettingSections(
            $this->pageSlug,
            [
                'section_id'  => 'movies',
                'title'       => __('Movies', 'omniweb-showtimes'),
                'repeatable'  => true,
                'sortable'    => true,
                'collapsible' => [
                    'title'     => 'Movie',
                    'container' => 'section',
                    'type'      => 'box'
                ]
            ]
        );

        $this->addSettingSections($this->pageSlug, ['section_id' => 'submit']);
        $this->addSettingFields(
            'movies',
            [
                'field_id' => 'movie_title',
                'type'     => 'section_title',
                'label'    => __('Movie Title', 'omniweb-showtimes'),
            ],
            [
                'title'    => 'Release Year',
                'field_id' => 'movie_release_year',
                'type'     => 'number',
            ],
            [
                'title'    => 'Trailer URL',
                'field_id' => 'movie_trailer_url',
                'type'     => 'text',
            ],
            [
                'title'              => 'Theatres',
                'field_id'           => 'movie_theatres',
                'type'               => 'checkbox',
                'label'              => $this->getPostTitles('theatre'),
                'select_all_button'  => true,
                'select_none_button' => true,
                'attributes'         => [
                    'style' => 'display:block;',
                    'field' => [
                        'style' => 'display:block;float:none;'
                    ],
                ],
                'show_title_column' => false,
            ],
            [
                'field_id'            => 'movie_poster',
                'title'               => __('Poster', 'omniweb-showtimes'),
                'type'                => 'image',
                'show_title_column'   => false,
                'attributes_to_store' => ['id', 'alt', 'caption', 'width', 'height'],
                'attributes'          => [
                    'input' => [
                        'style' => 'display: none;'
                    ],
                    'preview' => [
                        'style' => 'max-width: 80px'
                    ],
                    'button' => [
                        'data-label' => __('Select Poster', 'omniweb-showtimes')
                    ]
                ]
            ]
        );

        $this->addSettingFields('submit', [
            'field_id'          => 'submit_button',
            'type'              => 'submit',
            'show_title_column' => false,
        ]);

    }

    /**
     * @return      array
     */
    private function getPostTitles( $sPostTypeSlug = 'post' ) {

        $_aArgs         = array(
            'post_type' => $sPostTypeSlug,
            'order'     => 'ASC',
            'nopaging'  => true
        );

        $_oResults      = new WP_Query( $_aArgs );
        $_aPostTitles   = array();

        foreach( $_oResults->posts as $_iIndex => $_oPost ) {
            $_aPostTitles[ $_oPost->ID ] = $_oPost->post_title;
        }

        return $_aPostTitles;
    }
}
