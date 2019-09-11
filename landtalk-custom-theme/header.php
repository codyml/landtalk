<?php
/**
 * Renders the doctype, opening <html> tag, <head> content, opening
 * <body> tag and the page header.
 *
 * @package Land Talk Custom Theme
 */

?><!doctype html>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php require 'parts/tracking.php'; ?>
		<?php wp_head(); ?>
	</head>
	<body>

		<!-- Facebook SDK -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11';
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<!-- End Facebook SDK -->

		<!-- Twitter SDK -->
		<script>window.twttr = (function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0],
				t = window.twttr || {};
			if (d.getElementById(id)) return t;
			js = d.createElement(s);
			js.id = id;
			js.src = "https://platform.twitter.com/widgets.js";
			fjs.parentNode.insertBefore(js, fjs);

			t._e = [];
			t.ready = function(f) {
				t._e.push(f);
			};

			return t;
		}(document, "script", "twitter-wjs"));</script>
		<!-- End Twitter SDK -->

		<header class="section">
			<?php if ( basename( get_page_template() ) === 'home.php' ) : ?>
				<?php get_template_part( 'parts/page-header-large' ); ?>
			<?php else : ?>
				<?php get_template_part( 'parts/page-header' ); ?>
			<?php endif; ?>
		</header>
		<main class="section">
