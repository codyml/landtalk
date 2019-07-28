<?php

/*
*   Template Name: Land Talk: Lesson Archive
*/

get_header();
while ( have_posts() ): the_post();

?>

<div class="container content">
    <h1><?php the_title(); ?></h1>
</div>
<div class="lessons container">
    <div class='columns section-title'>
        <div class='column is-three-quarters is-size-4 has-text-weight-light'>
            <span class='section-title-text'><?php the_title(); ?></span>
        </div>
        <div class='column is-one-quarter'></div>
    </div>
    <hr />
    <?php the_content(); ?>
    <div class="react-component" data-component-name="LessonArchive"></div>
</div>

<?php

endwhile;
get_footer();

?>
