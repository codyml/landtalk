<?php

/*
*   Enables auto-generation of the <title> tag.
*/

function theme_slug_setup() {
    add_theme_support( 'title-tag' );
}

add_action( 'after_setup_theme', 'theme_slug_setup' );
