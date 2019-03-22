<?php

/*
*   Template Name: Land Talk: Conversation Archive
*/

get_header();
while ( have_posts() ): the_post();

?>

<div class="container">
    <div class="columns is-left">
        <div class="column is-10 content">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </div>
    </div>
</div>
<div class="react-component" data-component-name="ConversationArchive"></div>
<div class="container">
    <div class="columns is-centered">
        <div class="column is-10 content">
            <?php the_field('footer_text'); ?>
        </div>
    </div>
</div>

<?php

endwhile;
get_footer();
