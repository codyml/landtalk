<?php

/*
*   Creates an ACF Options page.
*/

if ( function_exists('acf_add_options_page') ) {

    acf_add_options_page( array(
        'page_title' => 'Land Talk Options',
        'menu_title' => 'Options',
        'position' => '30.' . HOPEFULLY_UNIQUE_POSITION_DECIMAL,
        'icon_url' => 'dashicons-star-filled',
    ) );

}
