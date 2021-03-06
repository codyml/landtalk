<?php

/*
*   Template Name: Land Talk: Submit Conversation
*/


/*
*   Sets up ACF form for submit.
*/

acf_form_head();
wp_get_current_user()->add_role( 'contributor' );
$options = array(

    'id' => 'submit-conversation-form',
    'post_id' => 'new_post',
    'new_post' => array(

        'post_type' => CONVERSATION_POST_TYPE,
        'post_status' => 'publish',
        'post_title' => 'New Conversation',

    ),

    'post_title' => false,
    'submit_value' => 'Submit',
    'return' => get_site_url() . '/submit-conversation?conversation=%post_id%',
    'recaptcha' => true,

);


/*
*   Creates link to new conversation after submit.
*/

$conversation = null;
if ( isset( $_GET['conversation'] ) ) {

    $conversation_id = $_GET['conversation'];
    $conversation = get_post( $conversation_id );
    wp_update_post( array(
         'ID' => $conversation->ID,
         'post_title' => get_field( 'place_name', $conversation ),
         'post_name' => sanitize_title( get_field( 'place_name', $conversation ) ),
     ) );

    //  Retrieves again to get up-to-date object.
    $conversation = get_post( $conversation_id );
    $permalink = get_permalink( $conversation );
    landtalk_conversation_send_emails( $conversation );

}

get_header();
while ( have_posts() ): the_post();

?>

<div class="container content">
    <h1><?php the_title(); ?></h1>
    <?php if ( isset( $conversation ) ): ?>
        <div>Thanks for your submission!  It's published at <a href="<?php echo $permalink; ?>"><?php echo $permalink; ?></a>.</div>
    <? else:
      the_content();
      acf_form( $options ); ?>
    <? endif; ?>
</div>

<?php

endwhile;
get_footer();
