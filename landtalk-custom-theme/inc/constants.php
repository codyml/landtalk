<?php
/**
 * Defines constants for the theme.
 *
 * @package Land Talk Custom Theme
 */

/*
*   Defines custom post type identifiers.
*/

define( 'CONVERSATION_POST_TYPE', 'landtalk_convers' );
define( 'REPORT_POST_TYPE', 'landtalk_report' );
define( 'CONTACT_MESSAGE_POST_TYPE', 'landtalk_contact' );
define( 'LESSON_POST_TYPE', 'landtalk_lesson' );
define( 'REFLECTION_POST_TYPE', 'landtalk_reflection' );

/*
*   Defines taxonomy identifiers.
*/

define( 'KEYWORDS_TAXONOMY', 'landtalk_keywords' );
define( 'REFLECTION_CATEGORY_TAXONOMY', 'landtalk_refcat' );


/*
*   Defines a hopefully-unique position decimal to avoid position
*   clashes.
*/

define( 'HOPEFULLY_UNIQUE_POSITION_DECIMAL', '3982' );


/*
*   Defines the identifier for the menu locations.
*/

define( 'HEADER_MENU_LOCATION', 'landtalk_header_menu' );
define( 'FOOTER_MENU_LOCATION', 'landtalk_footer_menu' );


/*
*   Defines postmeta field key prefix for preprocessed relevance
*   query data and the separator used to separate multiple-value
*   fields.
*/

define( 'RELEVANCE_POSTMETA_KEY_PREFIX', 'lt_rel_' );
define( 'PREPROCESSED_SEPARATOR', '%%%%%' );


/*
*   Defines spatial query constants.
*/

define( 'EARTH_RADIUS', 3959 );
