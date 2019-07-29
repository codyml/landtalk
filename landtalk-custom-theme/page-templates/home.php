<?php

/*
*   Template Name: Land Talk: Home
*/

get_header();

?>

<div class="container">
    <div class="columns is-centered">
        <div class="column is-6 homepage-intro">
            <?php the_field( 'intro_text' ); ?>
        </div>
        <div class="column is-6">
          <figure class="image is-3by2 homepage-image" style="background-image: url('<?php the_field( 'intro_image' ); ?>')"></figure>
        </div>
    </div>
</div>
<div class="container">
    <div class="columns is-centered">
        <div class="column is-6 homepage-map">
            <?php the_field( 'map_text' ); ?>
        </div>
    </div>
</div>
<div class="full-bleed-container">
    <div class="react-component" data-component-name="ConversationMap"></div>
</div>
<div class="container">
    <div class="columns is-centered">
      <div class="column is-6">
        <figure class="image is-3by2 homepage-image" style="background-image: url('<?php the_field( 'body_image' ); ?>')"></figure>
      </div>
      <div class="column is-6 homepage-body">
          <?php the_field( 'body_text' ); ?>
      </div>
    </div>
</div>

<?php

get_footer();
