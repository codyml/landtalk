<?php

/*
*   Page template for a single Reflection post.
*/

get_header();
while ( have_posts() ): the_post();

?>

<!-- Post Title -->
<div class="container">
    <div class="columns">
        <div class="column is-full is-size-2 has-text-weight-light">
            <?php the_title(); ?>
        </div>
    </div>
</div>

<?php

endwhile;
get_footer();
