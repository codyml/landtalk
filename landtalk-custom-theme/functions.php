<?php

/*
*   Defines constants.
*/

require_once 'inc/constants.php';


/*
*   Registers taxonomies.
*/

require_once 'inc/taxonomies.php';


/*
*   Registers custom post types.
*/

require_once 'inc/custom-post-types.php';


/*
*   Adds an Options page.
*/

require_once 'inc/options.php';


/*
*   Registers static assets for inclusion on rendered pages.
*/

require_once 'inc/static.php';


/*
*   Sets up navigational menus.
*/

require_once 'inc/menus.php';


/*
*   Registers custom REST endpoints.
*/

require_once 'inc/rest.php';


/*
*   Enables auto-generation of the <title> tag.
*/

function theme_slug_setup() {
    add_theme_support( 'title-tag' );
}

add_action( 'after_setup_theme', 'theme_slug_setup' );


/*
*   Extracts YouTube ID from link and creates embed code.
*/

function landtalk_get_youtube_embed( $url ) {

    $re = "/(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^\"&?\/ ]{11})/";
    $matches = array();
    preg_match( $re, $url, $matches );
    if ( isset( $matches[1] ) ) return $matches[1];

}
