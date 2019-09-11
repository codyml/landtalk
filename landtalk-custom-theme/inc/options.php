<?php
/**
 * Creates an ACF Options page.
 *
 * @package Land Talk Custom Theme
 */

if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page(
		array(
			'page_title' => 'Land Talk Options',
			'menu_title' => 'Options',
			'position'   => '30.' . HOPEFULLY_UNIQUE_POSITION_DECIMAL,
			'icon_url'   => 'dashicons-star-filled',
		)
	);

}


/*
*   Removes ACF admin settings if the "Production Instance" setting
*   is set to "True" on the Options page.
*/

if ( get_field( 'production', 'options' ) ) {
	add_filter( 'acf/settings/show_admin', '__return_false' );
}


/*
*   Updates all Conversations with separate Historic Activities
*   and Current Activities fields, filling the combined Historic
*   & Current Activities field with the contents of the two separate
*   fields separated by a paragraph break.
*/

if ( get_field( 'migrate_activities', 'options' ) ) {

	$conversations_query = new WP_Query(
		array(
			'post_type'      => CONVERSATION_POST_TYPE,
			'posts_per_page' => -1,
		)
	);

	if ( $conversations_query->have_posts() ) {
		while ( $conversations_query->have_posts() ) {
			$conversations_query->the_post();
			if ( ! get_field( 'activities' ) ) {
				update_field(
					'activities',
					get_field( 'used_to_do_here' ) . "\n\n" . get_field( 'does_here_now' )
				);
			}
		}
		wp_reset_postdata();
	}

	update_field( 'migrate_activities', false, 'options' );

}


/*
*   Updates all Conversations with separate Historic Activities
*   and Current Activities fields, filling the combined Historic
*   & Current Activities field with the contents of the two separate
*   fields separated by a paragraph break.
*/

if ( get_field( 'preprocess_conversations_for_relevance', 'options' ) ) {

	$conversations_query = new WP_Query(
		array(
			'post_type'      => CONVERSATION_POST_TYPE,
			'posts_per_page' => -1,
		)
	);

	if ( $conversations_query->have_posts() ) {
		while ( $conversations_query->have_posts() ) {
			$conversations_query->the_post();
			landtalk_save_relevance_postmeta( $post->ID );
		}
		wp_reset_postdata();
	}

	update_field( 'preprocess_conversations_for_relevance', false, 'options' );

}
