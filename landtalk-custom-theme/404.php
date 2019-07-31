<?php

/*
*   404 page template.  This page is rendered for non-existent objects.
*/

get_header();

?>

<div class="container content">
    <?php the_field( '404_content', 'options' ); ?>
</div>

<?php

get_footer();
