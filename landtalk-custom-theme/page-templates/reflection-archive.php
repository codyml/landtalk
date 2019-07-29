<?php

/*
*   Template Name: Land Talk: Reflection Archive
*/

get_header();
while ( have_posts() ): the_post();


/*
*   Sets up query & pagination for Reflections.
*/

//  Pagination constants
define( 'REFLECTIONS_PAGE_QUERY_VAR', 'reflections_page' );
define( 'REFLECTIONS_POSTS_PER_PAGE', 10 );

//  Retrieves current page
$current_page = 1;
if ( $_GET[ REFLECTIONS_PAGE_QUERY_VAR ] ) {
    if ( absint( $_GET[ REFLECTIONS_PAGE_QUERY_VAR ] ) > 1 ) {
        $current_page = absint( $_GET[ REFLECTIONS_PAGE_QUERY_VAR ] );
    }
}

//  Queries for Reflections
$reflections_query = new WP_Query( array(
    'post_type' => REFLECTION_POST_TYPE,
    'posts_per_page' => REFLECTIONS_POSTS_PER_PAGE,
    'paged' => $current_page,
) );

//  Gets pagination links
$pagination_links = paginate_links( array(
    'base' => home_url( $wp->request ) . '%_%',
    'format' => '?' . REFLECTIONS_PAGE_QUERY_VAR . '=%#%',
    'current' => $current_page,
    'total' => $reflections_query->max_num_pages,
) );

?>

<div class="container content">
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
</div>
<div class="container">
    <ul>
        <?php if ( $reflections_query->have_posts() ) : while ( $reflections_query->have_posts() ) : $reflections_query->the_post(); ?>
            <li>
                <a href="<?php the_permalink(); ?>" class="columns is-vcentered conversation-excerpt">
                    <div class="column is-one-quarter">
                        <div class="featured-image" style="background-image: url(<?php echo wp_get_attachment_image_src( get_field( 'featured_image' ), 'medium-large' )[0]; ?>)"></div>
                    </div>
                    <div class="column is-three-quarters">
                        <div class="bold-cap-ui-text"><?php echo get_field( 'category' )->name ?></div>
                        <h1><?php the_title(); ?></h1>
                        <div class="excerpt-text"><?php echo wp_trim_words( get_field( 'content', $conversation ), 40 ); ?></div>
                        <div class="read-more">read more</div>
                    </div>
                </a>
            </li>
        <?php endwhile; endif; wp_reset_postdata();?>
    </ul>
</div>
<div class="container pagination-links bold-cap-ui-text">
    <?php echo $pagination_links; ?>
</div>

<?php

endwhile;
get_footer();
