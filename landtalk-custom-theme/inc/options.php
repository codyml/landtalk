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


/*
*   Removes ACF admin settings if the "Production Instance" setting
*   is set to "True" on the Options page.
*/

if ( get_field( 'production', 'options' ) ) {
    add_filter('acf/settings/show_admin', '__return_false');
}
