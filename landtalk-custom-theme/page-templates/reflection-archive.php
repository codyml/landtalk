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
define( 'REFLECTIONS_POSTS_PER_PAGE', 1 );  //  TODO: Change to 10

//  Retrieves current page
$current_page = 1;
if ( $_GET[ REFLECTIONS_PAGE_QUERY_VAR ] ) {
    if ( absint( $_GET[ REFLECTIONS_PAGE_QUERY_VAR ] ) > 1 ) {
        $current_page = absint( $_GET[ REFLECTIONS_PAGE_QUERY_VAR ] );
    }
}

//  Queries for Reflections
$reflections_query = new WP_QUERY( array(
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
                <a href="<?php the_permalink(); ?>">
                    <h3><?php echo get_field( 'category' )->name ?></h3>
                    <h1><?php the_title(); ?></h1>
                    <div><?php echo wp_trim_words( get_field( 'content', $conversation ), 35 ); ?></div>
                </a>
            </li>
        <?php endwhile; endif; wp_reset_postdata();?>
    </ul>
    <div class="pagination-links">
        <?php echo $pagination_links; ?>
    </div>
</div>

<?php

endwhile;
get_footer();
