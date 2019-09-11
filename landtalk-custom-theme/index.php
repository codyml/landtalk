<?php
/**
 * Redirects all requests that don't have an explicit template
 * defined to the Home page.
 *
 * @package Land Talk Custom Theme
 */

wp_safe_redirect( get_home_url() );
exit;
