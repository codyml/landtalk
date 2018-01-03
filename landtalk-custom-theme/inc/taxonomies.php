<?php

/*
*   Registers the Keywords taxonomy.
*/

function landtalk_register_keywords_taxonomy() {

    register_taxonomy( KEYWORDS_TAXONOMY, null, array(
        'labels' => array(
            'name' => 'Keywords',
            'singular_name' => 'Keyword',
            'all_items' => 'All Keywords',
            'edit_item' => 'Edit Keyword',
            'view_item' => 'View Keyword',
            'update_item' => 'Update Keyword',
            'add_new_item' => 'Add New Keyword',
            'new_item_name' => 'New Keyword Name',
            'search_items' => 'Seach Keywords',
            'popular_items' => 'Popular Keywords',
            'separate_items_with_commas' => 'Separate keywords with commas',
            'add_or_remove_items' => 'Add or remove keywords',
            'choose_from_most_used' => 'Choose from the most used keywords',
            'not_found' => 'No keywords found.',
        ),
        'public' => true,
        'show_in_rest' => true,
        'rest_base' => 'keywords',
    ) );

}

add_action( 'init', 'landtalk_register_keywords_taxonomy' );
