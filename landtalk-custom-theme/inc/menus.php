<?php

/*
*   Creates the main navigation menu.
*/

function register_main_nav_menu_location() {
  
    register_nav_menu( MAIN_NAV_MENU_LOCATION, 'Main Nav Menu' );

}

add_action( 'init', 'register_main_nav_menu_location' );
