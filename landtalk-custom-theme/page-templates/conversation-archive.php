<?php

/*
*   Template Name: Land Talk: Conversation Archive
*/

get_header();
while ( have_posts() ): the_post();

?>

<div class="container content">
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
</div>
<div class="react-component" data-component-name="ConversationArchive"></div>
<div class="container content">
    <?php the_field('footer_text'); ?>
</div>

<?php

endwhile;
get_footer();
