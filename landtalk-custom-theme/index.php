<?php

/*
*   Index page template.  This page is rendered for any content
*   that doesn't match another template.
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

<?php

endwhile;
get_footer();
