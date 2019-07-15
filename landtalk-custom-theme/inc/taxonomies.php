<?php

/*
*   Registers the Keywords taxonomy.
*/

function landtalk_register_keywords_taxonomy() {

    register_taxonomy( KEYWORDS_TAXONOMY, CONVERSATION_POST_TYPE, array(
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
        'capabilities' => array(
            'manage_terms' => 'edit_posts',
        ),
    ) );

}

add_action( 'init', 'landtalk_register_keywords_taxonomy' );


/*
*   Retrieves a list of all taxonomy terms for a post.
*/

function landtalk_get_keywords( $post ) {

    $terms = get_the_terms( $post, KEYWORDS_TAXONOMY );
    if ( ! $terms ) return array();
    else return array_map( function($term) { return $term->name; }, $terms );

}


/*
*   Registers the Reflection Categories taxonomy.
*/

function landtalk_register_reflection_category_taxonomy() {

    register_taxonomy( REFLECTION_CATEGORY_TAXONOMY, REFLECTION_POST_TYPE, array(
        'labels' => array(
            'name' => 'Reflection Categories',
            'singular_name' => 'Reflection Category',
            'all_items' => 'All Reflection Categories',
            'edit_item' => 'Edit Reflection Category',
            'view_item' => 'View Reflection Category',
            'update_item' => 'Update Reflection Category',
            'add_new_item' => 'Add New Reflection Category',
            'new_item_name' => 'New Reflection Category Name',
            'search_items' => 'Seach Reflection Categories',
            'popular_items' => 'Popular Reflection Categories',
            'separate_items_with_commas' => 'Separate reflection categories with commas',
            'add_or_remove_items' => 'Add or remove reflection categories',
            'choose_from_most_used' => 'Choose from the most used reflection categories',
            'not_found' => 'No reflection categories found.',
        ),
        'public' => true,
        'show_in_rest' => true,
        'rest_base' => 'reflection_categories',
    ) );

}

add_action( 'init', 'landtalk_register_reflection_category_taxonomy' );


/*
*   Removes the default Reflection Categories meta box in favor
*   of the ACF one.
*/

function remove_default_reflection_category_metabox() {
    remove_meta_box( 'tagsdiv-' . REFLECTION_CATEGORY_TAXONOMY, REFLECTION_POST_TYPE, 'side' );
}

add_action( 'admin_menu' , 'remove_default_reflection_category_metabox' );
