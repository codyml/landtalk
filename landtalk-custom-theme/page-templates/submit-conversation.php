<?php

/*
*   Template Name: Land Talk: Submit Conversation
*/


/*
*   Sets up ACF form for submit.
*/

acf_form_head();
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
    'return' => '/submit-conversation?conversation=%post_id%',
    'recaptcha' => true,

);


/*
*   Creates link to new conversation after submit.
*/

$conversation = null;
if ( isset( $_GET['conversation'] ) ) {
    
    $conversation = get_post( $_GET['conversation'] );
    wp_update_post( array(
         'ID' => $conversation->ID,
         'post_title' => get_field( 'place_name', $conversation ),
         'post_name' => sanitize_title( get_field( 'place_name', $conversation ) ),
     ) );
    
    $permalink = get_permalink( $conversation );
    landtalk_conversation_send_emails( $conversation );

}

get_header();
while ( have_posts() ): the_post();

?>

<div class="container">
    <div class="columns is-centered">
        <div class="column is-10 content">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
            <?php if ( isset( $conversation ) ): ?>
                <div class="has-text-weight-bold">Thanks for your submission!  It's published at <a href="<?php echo $permalink; ?>"><?php echo $permalink; ?></a>.</div>
            <? else: acf_form( $options ); ?>
            <? endif; ?>
        </div>
    </div>
</div>

<?php

endwhile;
get_footer();
