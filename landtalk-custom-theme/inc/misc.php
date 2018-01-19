<?php

/*
*   Enables auto-generation of the <title> tag.
*/

function theme_slug_setup() {
    add_theme_support( 'title-tag' );
}

add_action( 'after_setup_theme', 'theme_slug_setup' );


/*
*   Extracts YouTube ID from link and creates embed code.
*/

function landtalk_get_youtube_embed( $url ) {

    $re = "/(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^\"&?\/ ]{11})/";
    $matches = array();
    preg_match( $re, $url, $matches );
    if ( isset( $matches[1] ) ) return $matches[1];

}


/*
*   Sends the appropriate emails upon submission of a Conversation.
*/

function landtalk_conversation_send_emails( $conversation ) {

    $recipients = array();
    if ( get_field( 'email_to_interviewer', $conversation ) ) {
        $recipients[] = get_field( 'interviewer_email_address', $conversation );
    }

    if ( get_field( 'email_to_observer', $conversation ) ) {
        $recipients[] = get_field( 'observer_email_address', $conversation );
    }

    if ( ! empty( $recipients ) ) {

        foreach ( $recipients as $to ) {

            $subject = get_field( 'submission_message', 'options' )['subject'];
            $body = get_field( 'submission_message', 'options' )['body'];
            $message = str_replace( '%conversation_url%', get_permalink( $conversation ), $body );
            $headers = array( 'Content-type: text/html' );
            wp_mail( $to, $subject, $message, $headers );

        }

    }

}


/*
*   Modifies 'From' header of sent emails.
*/
 
function landtalk_modify_from_email( $original_email_address ) {
    return get_field( 'submission_message', 'options' )['from_email'];
}
 
function landtalk_modify_from_name( $original_email_from ) {
    return get_field( 'submission_message', 'options' )['from_name'];
}
 
add_filter( 'wp_mail_from', 'landtalk_modify_from_email' );
add_filter( 'wp_mail_from_name', 'landtalk_modify_from_name' );
