<?php

/*
*   Template Name: Land Talk: About
*/


/*
*   Sets up ACF form for submit.
*/

acf_form_head();
$options = array(

    'id' => 'contact-form',
    'post_id' => 'new_post',
    'new_post' => array(

        'post_type' => CONTACT_MESSAGE_POST_TYPE,
        'post_status' => 'publish',
        'post_title' => 'New Contact Message',

    ),

    'fields' => array( 'name', 'email_address', 'message', 'captcha' ),
    'post_title' => false,
    'submit_value' => 'Send',
    'return' => '/about?message=%post_id%',
    'recaptcha' => true,

);


/*
*   Finalizes new message after submit.
*/

$message = null;
if ( isset( $_GET['message'] ) ) {

    $message = get_post( $_GET['message'] );
    wp_update_post( array( 'ID' => $message->ID, 'post_title' => 'Message from ' . get_field( 'name', $message ) ) );
    landtalk_send_contact_notification( $message );

}

get_header();
while ( have_posts() ): the_post();

?>


<div class="container content">
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
</div>
<div class="full-bleed-container about-images">
    <div class="columns is-centered">
        <?php foreach ( get_field('images') as $index => $image ) : ?>
            <?php if ( $index === 6 ) break; ?>
            <div class="column is-2">
                <div class="image is-4by3" style="background-image: url('<?php echo $image['sizes']['medium_large']; ?>');"></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="container content">
    <?php the_field( 'contact_form' ); ?>
    <?php if ( isset( $message ) ): ?>
        <div class="is-italic has-text-weight-bold">Thanks for your message.  We'll get back to you soon.</div>
    <? else: acf_form( $options ); ?>
    <? endif; ?>
</div>

<?php

endwhile;
get_footer();
