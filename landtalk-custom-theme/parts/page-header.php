<div class="container">
    <div class="level">
        <div class="level-left">
            <a href="<?php echo get_site_url() . '/' ?>" class="level-item">
                <img src="<?php echo get_template_directory_uri() . '/img/logo.png'; ?>" alt="Land Talk" class="normal-header-logo">
            </a>
        </div>
        <div class="level-right">
            <div class="level-item">
                <?php wp_nav_menu( array( 'theme_location', MAIN_NAV_MENU_LOCATION ) ); ?>
            </div>
        </div>
    </div>
</div>
