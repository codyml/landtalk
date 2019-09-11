<?php
/**
 * Index page template.  This page is rendered for any content
 * that doesn't match another template.
 *
 * @package Land Talk Custom Theme
 */

get_header();
while ( have_posts() ) :
	the_post();

	?>


<div class="container content">
	<h1><?php the_title(); ?></h1>
	<?php the_content(); ?>
</div>

	<?php

endwhile;
get_footer();
