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
*   Enables automatic page titles.
*/

require_once 'inc/title.php';


/*
*   Defines utility functions.
*/

require_once 'inc/util.php';


/*
*   Sets up custom email notification messages for conversations,
*   reports and contact messages.
*/

require_once 'inc/email.php';


/*
*   Includes environmental variables.
*/

include_once 'inc/.env.php';


/*
*   Includes shortcodes.
*/

include_once 'inc/shortcodes.php';
