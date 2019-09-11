<?php
/**
 * Page template for a single Reflection post.
 *
 * @package Land Talk Custom Theme
 */

get_header();
while ( have_posts() ) :
	the_post();

	// Get props for photo gallery.
	$image_urls = array();
	if ( get_field( 'image_gallery' ) ) {

		foreach ( get_field( 'image_gallery' ) as $image ) {
			array_push(
				$image_urls,
				wp_get_attachment_image_src( $image['id'], 'large' )[0]
			);
		}

		$photo_gallery_props = landtalk_encode_json_for_html_attr(
			array( 'imageUrls' => $image_urls )
		);

	}

	?>

<div class="container reflection-single-title">
	<div class="bold-cap-ui-text">
		<?php echo esc_html( get_field( 'category' )->name ); ?>
	</div>
	<h1><?php the_title(); ?></h1>
	<div class="reflection-subtitle"><?php the_field( 'subtitle' ); ?></div>
	<hr>
</div>
<div class="container content">
	<?php the_field( 'content' ); ?>
</div>
	<?php if ( get_field( 'image_gallery' ) ) : ?>
<div class="container">
	<div class="react-component" data-component-name="PhotoGallery" data-component-props="<?php echo esc_attr( $photo_gallery_props ); ?>"></div>
</div>
	<?php endif; ?>

	<?php

endwhile;
get_footer();
