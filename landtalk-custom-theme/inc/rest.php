<?php

/*
*   Retrieves the appropriate fields from a Conversation object 
*   for a REST response.  Includes fields necessary for rendering
*   on the Conversation Map and as a Conversation Excerpt.
*/

function landtalk_prepare_conversation_for_rest_response( $post ) {  
    
    $response = array();
    $response['id'] = $post->ID;
    $response['link'] = get_permalink( $post );
    $response['place_name'] = get_field( 'place_name', $post );
    $response['location'] = get_field( 'location', $post );
    $response['historical_image_url'] = get_field( 'historical_image', $post )['image_file']['sizes']['medium_large'];
    $response['summary'] = get_field( 'summary', $post );
    return $response;

}


/*
*   Adds REST endpoint for retrieving all Conversations, either
*   by page or all at once.
*/

function landtalk_get_all_conversations( WP_REST_Request $request ) {

    $args = array( 'post_type' => CONVERSATION_POST_TYPE );
    if ( isset( $request['page'] ) ) {

        $args['posts_per_page'] = 3;
        $args['offset'] = $request['page'] * 3;

    } else $args['posts_per_page'] = -1;

    if ( isset( $request['search'] ) ) $args['s'] = $request['search'];
    $conversations = query_posts( $args );
    $response = array();
    foreach ( $conversations as $conversation ) {

        $response[] = landtalk_prepare_conversation_for_rest_response( $conversation );

    }

    if ( isset( $request['page'] ) ) {

        global $wp_query;
        return array( 'n_pages' => $wp_query->max_num_pages, 'page' => $response );

    } else return $response;

}

function landtalk_register_all_conversations_endpoint() {
  
    register_rest_route( 'landtalk', '/conversations', array(
        
        'methods' => 'GET',
        'callback' => 'landtalk_get_all_conversations',

    ) );

}

add_action( 'rest_api_init', 'landtalk_register_all_conversations_endpoint' );


/*
*   Adds REST endpoint for retrieving the Featured Conversations.
*/

function landtalk_get_featured_conversations() {

    $conversations = get_field( 'featured_conversations', 'options' );
    $response = array();
    foreach ( $conversations as $conversation ) {

        if ( $conversation['conversation']->post_status === 'publish' ) {
            $response[] = landtalk_prepare_conversation_for_rest_response( $conversation['conversation'] );
        }

    }

    return $response;

}

function landtalk_register_featured_conversations_endpoint() {
  
    register_rest_route( 'landtalk', '/conversations/featured', array(
        
        'methods' => 'GET',
        'callback' => 'landtalk_get_featured_conversations',

    ) );

}

add_action( 'rest_api_init', 'landtalk_register_featured_conversations_endpoint' );


/*
*   Adds REST endpoint for retrieving the Featured Conversations.
*/

function landtalk_get_latest_conversations() {

    $conversations = get_posts( array( 'post_type' => CONVERSATION_POST_TYPE, 'posts_per_page' => 3 ) );
    $response = array();
    foreach ( $conversations as $conversation ) {

        $response[] = landtalk_prepare_conversation_for_rest_response( $conversation );

    }

    return $response;

}

function landtalk_register_latest_conversations_endpoint() {
  
    register_rest_route( 'landtalk', '/conversations/latest', array(
        
        'methods' => 'GET',
        'callback' => 'landtalk_get_latest_conversations',

    ) );

}

add_action( 'rest_api_init', 'landtalk_register_latest_conversations_endpoint' );
