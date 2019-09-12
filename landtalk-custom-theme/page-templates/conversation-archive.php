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

	?>

<!-- Title -->
<div class="container">
	<div class="content">
		<h1><?php the_title(); ?></h1>
	</div>
</div>

<!-- ConversationArchive React component -->
<div class="react-component" data-component-name="ConversationArchive" data-component-props="<?php echo esc_attr( landtalk_encode_json_for_html_attr( array( 'topKeywords' => $keywords ) ) ); ?>"></div>

<!-- Footer text -->
<div class="container content">
	<?php the_field( 'footer_text' ); ?>
</div>

	<?php

endwhile;
get_footer();
