<?php

/*
*   Template Name: Land Talk: Guidelines
*/

get_header();
while ( have_posts() ): the_post();

?>

<div class="container">
    <div class="columns is-centered">
        <div class="column is-12 content">
            <?php the_content(); ?>
        </div>
    </div>
</div>

<?php

endwhile;
get_footer();
