<?php

/*
*   Template Name: Land Talk: Reflection Archive
*/

get_header();
while ( have_posts() ): the_post();

?>

<div class="container content">
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
</div>
<div class="react-component" data-component-name="ReflectionArchive"></div>

<?php

endwhile;
get_footer();

?>
