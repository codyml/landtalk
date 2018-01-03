<?php

/*
*   Creates an ACF Options page.
*/

if ( function_exists('acf_add_options_page') ) {

    acf_add_options_page( array(
        'page_title' => 'Land Talk Featured Conversations',
        'menu_title' => 'Featured Conversations',
        'position' => '26.' . HOPEFULLY_UNIQUE_POSITION_DECIMAL,
        'icon_url' => 'dashicons-star-filled',
    ) );

}
