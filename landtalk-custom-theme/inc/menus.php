<?php

/*
*   Defines the navigation menus.
*/

function register_menu_locations() {

    register_nav_menu( HEADER_MENU_LOCATION, 'Header Menu' );
    register_nav_menu( FOOTER_MENU_LOCATION, 'Footer Menu' );

}

add_action( 'init', 'register_menu_locations' );
