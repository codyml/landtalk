<?php
/**
 * Page template for a single Lesson.
 *
 * @package Land Talk Custom Theme
 */

get_header();
while ( have_posts() ) :
	the_post();

	$image_object = get_field( 'image' );
	if ( isset( $image_object['sizes']['large'] ) ) {
		$image = $image_object['sizes']['large'];
	} else {
		$image = $image_object['url'];
	}

	?>

<!-- Post Title -->
<div class="container">
	<div class="columns level">
		<div class="column is-9 level-item is-size-2 has-text-weight-light">
			<?php the_field( 'lesson_title' ); ?>
			<h2 class="lesson-subtitle">
				<span><?php the_field( 'subject' ); ?> </span>
				<?php if ( get_field( 'subject_2' ) ) : ?>
					<span><?php the_field( 'subject_2' ); ?> </span>
				<?php endif; ?>
				<span><?php the_field( 'grade' ); ?></span>
			</h2>
		</div>
		<div class="column is-3 level-item">
			<div class="lesson-image is-square" style="background-image: url( '<?php echo esc_url( $image ); ?>' );"></div>
		</div>
	</div>
</div>

<div class="container access-lesson">
	<h3>Access the full lesson plan in one of these formats:</h3>
	<?php if ( get_field( 'link' ) ) : ?>
		<a href="<?php the_field( 'link' ); ?>">Google Doc</a>
	<?php endif; ?>
	<?php if ( get_field( 'document_file' ) ) : ?>
		<a href="<?php the_field( 'document_file' ); ?>" download>Document</a>
	<?php endif; ?>
</div>

<div class="container lesson-details">
	<h1>Synopsis</h1>
	<p><?php the_field( 'synopsis' ); ?></p>
</div>

<div class="container lesson-details">
	<?php if ( get_field( 'teachers_notes' ) ) : ?>
		<h1>Teachers' Notes</h1>
		<p><?php the_field( 'teachers_notes' ); ?></p>
	<?php endif; ?>
</div>

<div class="container lesson-details">
	<?php if ( get_field( 'standards' ) ) : ?>
		<h1>Learning Objectives and Curriculum Standards</h1>
		<p><?php the_field( 'standards' ); ?></p>
	<?php endif; ?>
</div>

<div class="container lesson-details">
	<?php if ( get_field( 'preparation' ) ) : ?>
		<h1>Preparation</h1>
		<p><?php the_field( 'preparation' ); ?></p>
	<?php endif; ?>
</div>

	<?php

endwhile;
get_footer();
