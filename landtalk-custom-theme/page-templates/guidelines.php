<?php

/*
*   Template Name: Land Talk: Guidelines
*/

get_header();
while ( have_posts() ): the_post();

?>

<div class="container content">
    <?php the_content(); ?>
</div>

<?php

endwhile;
get_footer();
