<?php

/*
*   Template Name: Land Talk: Lessons
*/

get_header();
while ( have_posts() ): the_post();

?>

<div class="container">
    <div class="columns is-left">
        <div class="column is-10 content">
            <h1>Educational Resources</h1>
            <?php the_content(); ?>
        </div>
    </div>
</div>
<div class="lessons container">
    <div class='columns section-title'>
        <div class='column is-three-quarters is-size-4 has-text-weight-light'>
            <span class='section-title-text'>Lesson Plans</span>
        </div>
        <div class='column is-one-quarter'></div>
    </div>
    <hr />
    <?php the_field('lessons_description'); ?>
    <div class="react-component" data-component-name="LessonArchive"></div>
</div>

<?php

endwhile;
get_footer();

?>
