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
    $response['fields'] = get_fields( $post );
    return $response;

}

function landtalk_prepare_lesson_for_rest_response( $post ) {

    $response = array();
    $response['id'] = $post->ID;
    $response['link'] = get_permalink( $post );
    $response['lesson_title'] = get_field( 'lesson_title', $post );
    $image_object = get_field( 'image', $post );
    if ( isset( $image_object['sizes']['medium_large'] ) ) {

        $response['image_url'] = $image_object['sizes']['medium_large'];

    } else $response['image_url'] = $image_object['url'];
    $response['subject'] = get_field( 'subject', $post );
    $response['subject_2'] = get_field( 'subject_2', $post );
    $response['grade'] = get_field( 'grade', $post );
    $response['synopsis'] = get_field( 'synopsis', $post );
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

    //  Retrieve search term results
    if ( isset( $request['searchTerm'] ) ) {

        $relevant_conversations = landtalk_get_conversations_by_relevance( $request['searchTerm'] );
        if ( isset( $request['perPage'] ) ) {

            $length = $request['perPage'];
            $n_pages = ceil( count( $relevant_conversations ) / $length );

            if ( isset( $request['page'] ) ) {
                $offset = $request['page'];
                $conversations = array_slice( $relevant_conversations, $offset, $length );
            } else {
                $conversations = array_slice( $relevant_conversations, 0, $length );
            }

        } else {
            $conversations = $relevant_conversations;
        }

    } else {

        $args = array( 'post_type' => CONVERSATION_POST_TYPE );

        //  Order the pages correctly
        if ( isset( $request['orderBy'] ) ) {

            $args['orderby'] = $request['orderBy'];

        }

        //  Retrieve the correct number of conversations per page
        if ( isset( $request['perPage'] ) ) {

            $args['posts_per_page'] = $request['perPage'];

        } else $args['posts_per_page'] = -1;

        //  Retrieve the corect page of conversations
        if ( isset( $request['page'] ) && isset( $request['perPage'] ) ) {

            $args['offset'] = $request['page'] * $request['perPage'];

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
        $conversations = $query->get_posts();
        $n_pages = $query->max_num_pages;

    }

    //  Pad with random conversations
    if ( isset( $request['relatedId'] ) && isset( $request['perPage'] ) ) {

        $count = count( $conversations );
        if ( $count < $request['perPage'] ) {

            $addl_conversations_query = new WP_Query( array(
                'post_type' => CONVERSATION_POST_TYPE,
                'posts_per_page' => $request['perPage'] - $count,
                'post__not_in' => array( $request['relatedId'] ),
                'orderby' => 'rand',
            ) );

            $conversations = array_merge($conversations, $addl_conversations_query->get_posts());

        }

    }

    return array(
        'conversations' => array_map(
            'landtalk_prepare_conversation_for_rest_response',
            $conversations
        ),
        'nPages' => $n_pages,
    );

}

function landtalk_get_lessons( WP_REST_Request $request ) {

    $args = array( 'post_type' => LESSON_POST_TYPE );

    //  Order the pages correctly
    if ( isset( $request['orderBy'] ) ) {

        $args['orderby'] = $request['orderBy'];

    }

    //  Retrieve the correct number of lessons per page
    if ( isset( $request['perPage'] ) ) {

        $args['posts_per_page'] = $request['perPage'];

    } else $args['posts_per_page'] = -1;

    //  Retrieve the corect page of lessons
    if ( isset( $request['page'] ) && isset( $request['perPage'] ) ) {

        $args['offset'] = $request['page'] * $request['perPage'];

    }

    //  Retrieve search term results
    if ( isset( $request['searchTerm'] ) ) {

        $args['s'] = $request['searchTerm'];

    }

    $query = new WP_Query( $args );
    $lessons = $query->get_posts();

    $prepared_lessons = array();
    foreach ( $lessons as $lesson ) {

        $prepared_lessons[] = landtalk_prepare_lesson_for_rest_response( $lesson );

    }

    return array(
        'lessons' => $prepared_lessons,
        'nPages' => $query->max_num_pages,
    );

}


function landtalk_register_conversations_endpoint() {

    register_rest_route( 'landtalk', '/conversations', array(

        'methods' => 'GET',
        'callback' => 'landtalk_get_conversations',

    ) );

}

add_action( 'rest_api_init', 'landtalk_register_conversations_endpoint' );


function landtalk_register_lessons_endpoint() {

    register_rest_route( 'landtalk', '/lessons', array(

        'methods' => 'GET',
        'callback' => 'landtalk_get_lessons',

    ) );

}

add_action( 'rest_api_init', 'landtalk_register_lessons_endpoint' );



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
