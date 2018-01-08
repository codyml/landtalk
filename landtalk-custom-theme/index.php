<?php

/*
*   Redirects all requests that don't have an explicit template
*   defined to the Home page.
*/

wp_redirect( get_home_url() );
exit;
