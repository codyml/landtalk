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
    $historical_image_object = get_field( 'historical_image', $post )['image_file'];
    if ( isset( $historical_image_object['sizes']['medium_large'] ) ) {
        
        $response['historical_image_url'] = $historical_image_object['sizes']['medium_large'];

    } else $response['historical_image_url'] = $historical_image_object['url'];
    
    $response['summary'] = get_field( 'summary', $post );
    return $response;

}


/*
*   Adds REST endpoint for retrieving all Conversations, either
*   by page or all at once.
*/

define( 'POSTS_PER_PAGE', 6 );
function landtalk_get_all_conversations( WP_REST_Request $request ) {

    $args = array( 'post_type' => CONVERSATION_POST_TYPE );
    if ( isset( $request['page'] ) ) {

        $args['posts_per_page'] = POSTS_PER_PAGE;
        $args['offset'] = $request['page'] * POSTS_PER_PAGE;

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


/*
*   Adds REST endpoint for importing Conversations.  To import,
*   move image files to the wp-content/uploads/YEAR/MONTH/import and POST a
*   JSON file containing an array of objects following the Conversation
*   field schema.
*/

require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
function landtalk_import_conversations( WP_REST_Request $request ) {

    $conversations_data = json_decode( $request->get_body(), true );
    foreach ( $conversations_data as $conversation_data ) {

        $conversation_id = wp_insert_post( array(

            'post_title' => $conversation_data['place_name'],
            'post_status' => 'draft',
            'post_type' => CONVERSATION_POST_TYPE,

        ) );

        wp_set_post_terms( $conversation_id, $conversation_data['keywords_to_import'], KEYWORDS_TAXONOMY );
        foreach ( $conversation_data as $key => $value ) {
            
            if ( $key === 'historical_image' || $key === 'current_image' ) {

                $filename = $value['image_file'];
                $path = wp_upload_dir()['path'] . '/import/' . $filename;
                $url = wp_upload_dir()['url'] . '/import/' . $filename;
                $filetype = wp_check_filetype( $path )['type'];
                $attachment = array(

                    'post_title' => $filename,
                    'post_content' => '',
                    'post_status' => 'inherit',
                    'post_mime_type' => $filetype,

                );

                $attachment_id = wp_insert_attachment( $attachment, $path, $conversation_id );
                $metadata = wp_generate_attachment_metadata( $attachment_id, $path );
                wp_update_attachment_metadata( $attachment_id, $metadata );
                $value['image_file'] = $attachment_id;

            }

            update_field( $key, $value, $conversation_id );
        
        }

    }
    
    return array( 'created' => sizeof( $conversations_data ) );

}

function landtalk_register_import_conversations_endpoint() {
  
    register_rest_route( 'landtalk', '/conversations/import', array(
        
        'methods' => 'POST',
        'callback' => 'landtalk_import_conversations',

    ) );

}

if ( WP_DEBUG === true ) {
    add_action( 'rest_api_init', 'landtalk_register_import_conversations_endpoint' );
}
