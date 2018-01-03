<div class="container">
    <div class="columns is-centered is-mobile">
        <div class="column is-half-mobile is-one-third-tablet">
            <a href="/">
                <img src="<?php echo get_template_directory_uri() . '/img/logo.png'; ?>" alt="Land Talk">
            </a>
        </div>
    </div>
    <div class="columns is-centered">
        <div class="column is-narrow">
            <hr class="is-marginless">
            <div class="large-nav-menu">
                <?php wp_nav_menu( array( 'theme_location', MAIN_NAV_MENU_LOCATION ) ); ?>
            </div>
        </div>
    </div>
</div>
