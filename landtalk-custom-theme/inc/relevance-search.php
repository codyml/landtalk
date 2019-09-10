<?php

/*
*   Searches Conversations in multiple content areas and returns
*   an array of arrays, each containing the conversation object,
*   the ACF fields for the conversation and the calculated relevance
*   score.
*
*   TODO: currently has terrible performance (> 2s / query)
*/

function landtalk_get_conversations_by_relevance( $search_term ) {

    //  Don't allow searches for the separator.
    if ( $search_term === PREPROCESSED_SEPARATOR ) {
        return array();
    }

    //  Case insensitive search.
    $lowercase_search_term = strtolower( $search_term );

    //  Fetches all conversations.
    $args = array(
        'post_type' => CONVERSATION_POST_TYPE,
        'posts_per_page' => -1,
    );
    $query = new WP_Query( $args );
    $conversations = $query->get_posts();

    //  Fetches preprocessed relevance query data for conversations.
    $preprocessed_conversations = landtalk_retrieve_relevance_postmeta( $conversations );

    //  Scores each conversation based on preprocessed data.
    $scored_conversations = array_map( function( $conversation ) use ( $preprocessed_conversations, $lowercase_search_term ) {

        $score = landtalk_score_conversation_by_relevance(
            $preprocessed_conversations[ $conversation->ID ],
            $lowercase_search_term
        );

        return array(
            'conversation' => $conversation,
            'score' => $score,
        );

    }, $conversations );

    //  Filters to only results with score > 0
    $filtered_scored_conversations = array_filter(
        $scored_conversations,
        function( $scored_conversation ) {
            return $scored_conversation['score'] > 0;
        }
    );

    //  Sorts results by score
    usort( $filtered_scored_conversations, function( $a, $b ) {
        $difference = $b['score'] - $a['score'];
        if ( $difference === 0 ) {
            return $b['conversation']->ID - $a['conversation']->ID;
        } else return $difference;
    });

    return array_map( function( $scored_conversation) {
        return $scored_conversation['conversation'];
    }, $filtered_scored_conversations );

}


/*
*   Each sub-array is a facet of the conversation's relevance score
*   for a given search term.  `relevance` is how much the facet
*   weighs into the overall relevance score (higher numbers mean
*   more relevant) and the `preprocess` function is used to save
*   the relevant content in an easily-searchable format to postmeta
*   for better performance.  Under the current algorithm, a conversation
*   with a positive match for a facet with higher relevance will
*   always score higher than a conversation without such a match,
*   no matter how many matches it has for facets with lower relevance.
*/

$relevance_score_facets = array(

    //  Title
    array(
        'field_key' => 'title',
        'relevance' => 4,
        'preprocess' => function( $post_id ) {
            return strtolower( get_field( 'place_name', $post_id ) );
        },
    ),

    //  Keywords
    array(
        'field_key' => 'keywords',
        'relevance' => 3,
        'preprocess' => function( $post_id ) {
            return strtolower(
                implode(
                    PREPROCESSED_SEPARATOR,
                    array_map(
                        function( $keyword ) { return $keyword->name; },
                        empty( get_field( 'keywords', $post_id ) )
                            ? array()
                            : get_field( 'keywords', $post_id )
                    )
                )
            );
        },
    ),

    //  Narrative
    array(
        'field_key' => 'narrative',
        'relevance' => 2,
        'preprocess' => function( $post_id ) {
            return strtolower(
                implode(
                    PREPROCESSED_SEPARATOR,
                    array(
                        get_field( 'used_to_look', $post_id ),
                        get_field( 'has_changed', $post_id ),
                        get_field( 'activities', $post_id )
                    )
                )
            );
        },
    ),

    //  Transcript
    array(
        'field_key' => 'transcript',
        'relevance' => 1,
        'preprocess' => function( $post_id ) {
            return strtolower( get_field( 'transcript', $post_id ) );
        },
    ),

    //  Additional Information
    array(
        'field_key' => 'addl_info',
        'relevance' => 0,
        'preprocess' => function( $post_id ) {
            return strtolower( get_field( 'additional_information', $post_id ) );
        },
    ),

);


/*
*   Calculate's a conversation's relevance to the search term using
*   the above relevance score facets.
*/

function landtalk_score_conversation_by_relevance(
    $preprocessed_conversation,
    $search_term
) {

    global $relevance_score_facets;
    return array_reduce(
        $relevance_score_facets,
        function(
            $prev_score,
            $facet
        ) use (
            $preprocessed_conversation,
            $search_term
        ) {

            $next_score = $prev_score;
            $match = strpos(
                $preprocessed_conversation[ $facet['field_key'] ],
                $search_term
            ) !== false;

            if ( $match ) {
                $next_score += 1 << $facet['relevance'];
            }

            return $next_score;

        },
        0
    );

}


/*
*   Preprocesses and saves a conversation's relevance query fields
*   to postmeta for quick retrieval whenever a post is saved.
*/

function landtalk_save_relevance_postmeta( $post_id ) {

    global $relevance_score_facets;
    foreach ( $relevance_score_facets as $facet ) {
        update_post_meta(
            $post_id,
            RELEVANCE_POSTMETA_KEY_PREFIX . $facet['field_key'],
            $facet['preprocess']( $post_id )
        );
    }

}

add_action( 'save_post_' . CONVERSATION_POST_TYPE, 'landtalk_save_relevance_postmeta' );



/*
*   Retrieves preprocessed relevance query fields for the passed
*   Conversations.
*/

function landtalk_retrieve_relevance_postmeta( $conversations ) {

    global $relevance_score_facets;
    $preprocessed_conversations = array();
    foreach ( $conversations as $conversation ) {

        $preprocessed_conversation = array();
        foreach ( $relevance_score_facets as $facet ) {

            $meta = get_post_meta(
                $conversation->ID,
                RELEVANCE_POSTMETA_KEY_PREFIX . $facet['field_key'],
                true
            );

            $preprocessed_conversation[ $facet['field_key'] ] = $meta;

        }

        $preprocessed_conversations[ $conversation->ID ] = $preprocessed_conversation;

    }

    return $preprocessed_conversations;

}
