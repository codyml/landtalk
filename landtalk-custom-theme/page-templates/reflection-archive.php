<?php

/*
*   Template Name: Land Talk: Reflection Archive
*/

get_header();
while ( have_posts() ): the_post();

?>

<div class="container">
    <div class="columns is-centered">
        <div class="column is-10 content">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </div>
    </div>
</div>
<div class="react-component" data-component-name="ReflectionArchive"></div>

<?php

endwhile;
get_footer();

?>
