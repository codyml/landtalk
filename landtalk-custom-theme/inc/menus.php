<?php
/**
 * Defines the navigation menu locations.
 *
 * @package Land Talk Custom Theme
 */

add_action(
	'init',
	function() {
		register_nav_menu( HEADER_MENU_LOCATION, 'Header Menu' );
		register_nav_menu( FOOTER_MENU_LOCATION, 'Footer Menu' );
	}
);
