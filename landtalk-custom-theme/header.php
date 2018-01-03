<?php

/*
*   Renders the doctype, opening <html> tag, <head> content, opening <body> tag and the page header.
*/

?><!doctype html>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
    </head>
    <body>
        <header class="section">
            <?php if ( basename( get_page_template() ) === 'home.php' ) : ?>
                <?php get_template_part( 'parts/page-header-large' ); ?>
            <?php else : ?>
                <?php get_template_part( 'parts/page-header' ); ?>
            <?php endif; ?>
        </header>
        <main class="section">
