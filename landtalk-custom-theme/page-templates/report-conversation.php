<?php

/*
*   Template Name: Land Talk: Report Conversation
*/


/*
*   Redirects if invalid Conversation ID.
*/

$conversation = null;
if ( isset( $_GET['conversation'] ) ) {
    
   $post = get_post( $_GET['conversation'] );
   if ( isset( $post ) ) {

        if ( $post->post_type === CONVERSATION_POST_TYPE && $post->post_status === 'publish' ) {
            $conversation = $post;
        }

   }

}

if ( ! $conversation ) {
    wp_redirect( get_home_url() );
    exit;
}


/*
*   Sets up ACF form for submit.
*/

acf_form_head();
$options = array(

    'id' => 'report-conversation-form',
    'post_id' => 'new_post',
    'new_post' => array(

        'post_type' => REPORT_POST_TYPE,
        'post_status' => 'publish',
        'post_title' => 'Report of Conversation ' . $_GET['conversation'],

    ),

    'fields' => array( 'reason_for_report', 'more_details', 'reporter_email_address', 'captcha' ),
    'post_title' => false,
    'submit_value' => 'Submit',
    'return' => '/report-conversation?conversation=' . $_GET['conversation'] . '&report=%post_id%',
    'recaptcha' => true,

);


/*
*   Finalizes new report after submit.
*/

$report = null;
if ( isset( $_GET['report'] ) ) {
    
   $report = get_post( $_GET['report'] );
   update_field( 'conversation', $conversation->ID, $report->ID );
   wp_update_post( array( 'ID' => $conversation->ID, 'post_status' => 'pending' ) );
   landtalk_send_report_notification( $report );

}

get_header();
while ( have_posts() ): the_post();

?>

<div class="container">
    <div class="columns is-centered">
        <div class="column is-10 content">
            <h1><?php the_title(); ?>: <?php echo $conversation->post_title; ?></h1>
            <?php the_content(); ?>
            <?php if ( isset( $report ) ): ?>
                <div class="is-italic has-text-weight-bold">Thanks for your report.  An administrator will review it soon.</div>
            <? else: acf_form( $options ); ?>
            <? endif; ?>
        </div>
    </div>
</div>

<?php

endwhile;
get_footer();
