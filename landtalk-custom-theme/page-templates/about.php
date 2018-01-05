<?php

/*
*   Template Name: Land Talk: About
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
<div class="full-bleed-container about-images">
    <div class="columns is-centered">
        <?php foreach ( get_field('images') as $index => $image ) : ?>
            <?php if ( $index === 6 ) break; ?>
            <div class="column is-2">
                <div class="image is-4by3" style="background-image: url('<?php echo $image['sizes']['medium_large']; ?>');"></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php

endwhile;
get_footer();
