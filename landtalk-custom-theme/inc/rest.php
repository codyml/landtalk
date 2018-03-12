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
*   Adds REST endpoint for retrieving Conversations.
*/

function landtalk_get_conversations( WP_REST_Request $request ) {

    //  Retrieve Featured Conversations
    if ( isset( $request['featured'] ) ) {
        
        return array(
            'conversations' => landtalk_get_featured_conversations(),
            'nPages' => 1
        );
    
    }

    $args = array( 'post_type' => CONVERSATION_POST_TYPE );

    //  Order the pages correctly
    if ( isset( $request['orderBy'] ) ) {

        $args['orderby'] = $request['orderBy'];

    }
    
    //  Retrieve the correct number of conversations per page
    if ( isset( $request['perPage'] ) ) {
        
        $args['posts_per_page'] = $request['perPage'];
    
    } else $args['posts_per_page'] = -1

    //  Retrieve the corect page of conversations
    if ( isset( $request['page'] ) && isset( $request['perPage'] ) ) {

        $args['offset'] = $request['page'] * $request['perPage'];

    }

    //  Retrieve search term results
    if ( isset( $request['searchTerm'] ) ) {

        $args['s'] = $request['searchTerm'];

    }

    //  Retrieve related posts
    if ( isset( $request['relatedId'] ) ) {

        $terms = get_the_terms( $request['relatedId'], KEYWORDS_TAXONOMY );
        $args['post__not_in'] = array($request['relatedId']);
        $args['tax_query'] = array(
            'relation' => 'OR',
            array(
                'taxonomy' => KEYWORDS_TAXONOMY,
                'field' => 'term_id',
                'terms' => array_map(function($term) { return $term->term_id; }, $terms),
            ),
        );

    }
    
    $query = new WP_Query( $args );
    $query->query();
    $conversations = $query->get_posts();
    
    //  Pad with random conversations
    if ( isset( $request['relatedId'] ) && isset( $request['perPage'] ) ) {

        $count = count( $conversations );
        if ( $count < N_RELATED_CONVERSATIONS ) {

            $addl_conversations_query = new WP_Query( array(
                'post_type' => CONVERSATION_POST_TYPE,
                'posts_per_page' => $request['perPage'] - $count,
                'post__not_in' => array($request['relatedId']),
                'orderby' => 'rand',
            ) );

            $addl_conversations_query->query();
            $conversations = array_merge($conversations, $addl_conversations_query->get_posts());

        }

    }
    
    $prepared_conversations = array();
    foreach ( $conversations as $conversation ) {

        $prepared_conversations[] = landtalk_prepare_conversation_for_rest_response( $conversation );

    }

    return array(
        'conversations' => $prepared_conversations,
        'nPages' => $query->max_num_page,
    );

}

function landtalk_register_conversations_endpoint() {
  
    register_rest_route( 'landtalk', '/conversations', array(
        
        'methods' => 'GET',
        'callback' => 'landtalk_get_conversations',

    ) );

}

add_action( 'rest_api_init', 'landtalk_register_all_conversations_endpoint' );


/*
*   Retrieves the Featured Conversations.
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
