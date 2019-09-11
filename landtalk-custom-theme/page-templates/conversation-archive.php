<?php
/**
 * Template Name: Land Talk: Conversation Archive
 *
 * @package Land Talk Custom Theme
 */

get_header();
while ( have_posts() ) :
	the_post();

	$keywords = get_terms(
		array(
			'taxonomy' => KEYWORDS_TAXONOMY,
			'orderby'  => 'count',
			'order'    => 'DESC',
			'number'   => N_TOP_KEYWORDS,
			'fields'   => 'names',
		)
	);

	$keywords_with_links = array_map(
		function( $keyword ) {
			return array(
				'name' => $keyword,
				'link' => get_site_url() . '/conversations/#keyword=' . rawurlencode( $keyword ),
			);
		},
		$keywords
	);

	?>

<!-- Title -->
<div class="container">
	<div class="content">
		<h1><?php the_title(); ?></h1>
	</div>
</div>

<!-- Map -->
<div class="full-bleed-container">
	<div class="react-component" data-component-name="ConversationMap" data-component-props="<?php echo esc_attr( landtalk_encode_json_for_html_attr( array( 'height' => '27.5em' ) ) ); ?>"></div>
</div>

<!-- Keyword cloud -->
<div class="container">
	<div class="has-text-weight-bold">Popular topics:</div>
	<ul class="keyword-cloud">
		<?php foreach ( $keywords_with_links as $keyword ) : ?>
			<a class="keyword-cloud-keyword" href="<?php echo esc_attr( $keyword['link'] ); ?>">
				<?php echo esc_html( $keyword['name'] ); ?>
			</a>
		<?php endforeach; ?>
	</ul>
</div>

<!-- Search & results -->
<div class="container">
	<div class="react-component" data-component-name="ConversationSearch"></div>
</div>

<!-- Footer text -->
<div class="container content">
	<?php the_field( 'footer_text' ); ?>
</div>

	<?php

endwhile;
get_footer();
