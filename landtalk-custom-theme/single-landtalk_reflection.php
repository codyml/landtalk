<?php

/*
*   Page template for a single Reflection post.
*/

get_header();
while ( have_posts() ): the_post();

?>

<!-- Post Title -->
<div class="container content">
    <h3><?php echo get_field( 'category' )->name ?></h3>
    <h1><?php the_title(); ?></h1>
    <h2><?php the_field( 'subtitle' ); ?></h2>
    <?php the_field( 'content' ); ?>
    <?php

        foreach ( get_field( 'image_gallery' ) as $image ) {
            echo wp_get_attachment_image( $image['id'], 'thumbnail' );
        }

    ?>
</div>


<?php

endwhile;
get_footer();
