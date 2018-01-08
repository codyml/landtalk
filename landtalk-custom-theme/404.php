<?php

/*
*   404 page template.  This page is rendered for non-existent objects.
*/

get_header();

?>

<div class="container">
    <div class="columns is-centered">
        <div class="column is-10 content">
            <?php the_field( '404_content', 'options' ); ?>
        </div>
    </div>
</div>

<?php

get_footer();
