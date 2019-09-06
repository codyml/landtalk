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

    //  Fetches all conversations.
    $args = array(
        'post_type' => CONVERSATION_POST_TYPE,
        'posts_per_page' => -1,
    );
    $query = new WP_Query( $args );
    $conversations = $query->get_posts();

    //  Retrieves custom fields and calculates a score for each
    //  conversation for relevance to search term.
    $scored_conversations = array_map( function( $conversation ) use ( $search_term ) {

        $fields = get_fields( $conversation );
        $score = landtalk_score_conversation_by_relevance(
            $conversation,
            $fields,
            $search_term
        );

        return array(
            'conversation' => $conversation,
            'fields' => $fields,
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
*   more relevant) and the `match` function returns whether a conversation
*   is a positive match for the facet.  Under the current algorithm,
*   a conversation with a positive match for a facet with higher
*   relevance will always score higher than a conversation without
*   such a match, no matter how many matches it has for facets with
*   lower relevance.
*/

$relevance_score_facets = array(

    //  Title
    array(
        'relevance' => 4,
        'match' => function( $conversation, $fields, $search_term ) {
            $re = '/' . $search_term . '/i';
            $str = $conversation->post_title;
            return preg_match( $re, $str );
        },
    ),

    //  Keywords
    array(
        'relevance' => 3,
        'match' => function( $conversation, $fields, $search_term ) {
            $re = '/' . $search_term . '/i';
            foreach ( $fields['keywords'] as $keyword ) {
                $str = $keyword->name;
                if ( preg_match( $re, $str ) ) {
                    return true;
                }
            }

            return false;
        },

    ),

    //  Narrative
    array(
        'relevance' => 2,
        'match' => function( $conversation, $fields, $search_term ) {
            $re = '/' . $search_term . '/i';
            $searchedFields = array(
                'used_to_look',
                'has_changed',
                'activities'
            );

            foreach ( $searchedFields as $fieldName ) {
                $str = $fields[ $fieldName ];
                if ( preg_match( $re, $str ) ) {
                    return true;
                }
            }

            return false;
        },
    ),

    //  Transcript
    array(
        'relevance' => 1,
        'match' => function( $conversation, $fields, $search_term ) {
            $re = '/' . $search_term . '/i';
            $str = $fields['transcript'];
            return preg_match( $re, $str );
        },
    ),

    //  Additional Information
    array(
        'relevance' => 0,
        'match' => function( $conversation, $fields, $search_term ) {
            $re = '/' . $search_term . '/i';
            $str = $fields['additional_information'];
            return preg_match( $re, $str );
        },

    ),

);


/*
*   Calculate's a conversation's relevance to the search term using
*   the above relevance score facets.
*/

function landtalk_score_conversation_by_relevance(
    $conversation,
    $fields,
    $search_term
) {

    global $relevance_score_facets;
    return array_reduce(
        $relevance_score_facets,
        function( $prev_score, $facet ) use ($conversation, $fields, $search_term ) {

            $next_score = $prev_score;
            $match = $facet['match']( $conversation, $fields, $search_term );
            if ( ! empty( $match ) ) {
                $next_score += 1 << $facet['relevance'];
            }

            return $next_score;

        },
        0
    );

}
