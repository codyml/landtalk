<div class="container">
    <div class="columns is-centered">
        <div class="column is-three-quarters">
            <hr>
            <?php wp_nav_menu( array( 'theme_location', MAIN_NAV_MENU_LOCATION ) ); ?>
        </div>
    </div>
    <div class="columns is-centered">
        <div class="column is-two-thirds has-text-centered has-text-weight-light">
            <?php the_field( 'footer_contents', 'options' ); ?>
        </div>
    </div>
</div>
