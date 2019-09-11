<?php
/**
 * Handles sending notification emails for theme.
 *
 * @package Land Talk Custom Theme
 */

/**
 * Sends the appropriate emails upon submission of a Conversation.
 *
 * @param WP_Post $conversation The conversation to send emails for.
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
			$body    = get_field( 'submission_message', 'options' )['body'];
			$message = str_replace( '%conversation_url%', get_permalink( $conversation ), $body );
			$headers = array( 'Content-type: text/html' );
			wp_mail( $to, $subject, $message, $headers );

		}
	}

}


/**
 * Sends a notification to the registered notification addresses
 * when a Report is submitted.
 *
 * @param WP_Post $report The report to send a notification email for.
 */
function landtalk_send_report_notification( $report ) {

	$subject      = 'New Land Talk Report';
	$conversation = get_field( 'conversation', $report );
	ob_start();

	?>

		<h1>Someone reported a Land Talk Conversation.</h1>
		<p>
			<strong>Reported Conversation</strong>:
			<a href="<?php the_permalink( $conversation ); ?>">
				<?php echo esc_html( get_the_title( $conversation ) ); ?>
			</a>
		</p>
		<p>
			<strong>Reason for Report</strong>:
			<?php the_field( 'reason_for_report', $report ); ?>
		</p>
		<p>
			<strong>Report Details</strong>:
			<?php the_field( 'more_details', $report ); ?>
		</p>
		<p>
			<strong>Email Address of Reporter</strong>:
			<a href="mailto:<?php the_field( 'reporter_email_address', $report ); ?>">
				<?php the_field( 'reporter_email_address', $report ); ?>
			</a>
		</p>

	<?php

	$message = ob_get_clean();
	landtalk_send_notification( $subject, $message, 'report' );

}


/**
 * Sends a notification to the registered notification addresses
 * when a Contact message is submitted.
 *
 * @param WP_Post $message_object The contact message to notify about.
 */
function landtalk_send_contact_notification( $message_object ) {

	$subject           = 'New Land Talk Contact Message';
	$name              = get_field( 'name', $message_object );
	$email_address     = get_field( 'email_address', $message_object );
	$submitted_message = get_field( 'message', $message_object );
	ob_start();

	?>

		<h1>A Land Talk visitor sent a Contact message.</h1>
		<p>
			<strong>From</strong>:
			<a href="mailto:<?php echo esc_attr( $email_address ); ?>">
				<?php echo esc_html( $name ); ?> &lt;<?php echo esc_html( $email_address ); ?>&gt;
			</a>
		</p>
		<p>
			<strong>Message</strong>:
			<?php echo esc_html( $submitted_message ); ?>
		</p>
		<br>
		<p>
			<em>To reply to this message, compose a new email to the "From" address.  Replies to this email will be discarded.</em>
		</p>

	<?php

	$message = ob_get_clean();
	landtalk_send_notification( $subject, $message, 'contact' );

}


/**
 * Sends a notification to the registered notification addresses
 * when a Report or Contact message is submitted.
 *
 * @param str $subject The subject of the email.
 * @param str $message The HTML body of the message to send.
 * @param str $notification_type The type of notification being sent.
 *        Each email address added in Options is registered to receive
 *        `contact` and/or `report` notifications.
 */
function landtalk_send_notification( $subject, $message, $notification_type ) {

	$notification_addresses = get_field( 'notifications', 'options' );
	if ( isset( $notification_addresses ) ) {
		foreach ( $notification_addresses as $address ) {
			if ( in_array( $notification_type, $address['notification_types'], true ) ) {

				wp_mail(
					$address['email_address'],
					$subject,
					$message,
					array( 'Content-Type: text/html' )
				);

			}
		}
	}

}


/*
*   Modifies 'From' header of sent emails.
*/

add_filter(
	'wp_mail_from',
	function ( $original_email_address ) {
		return get_field( 'submission_message', 'options' )['from_email'];
	}
);

add_filter(
	'wp_mail_from_name',
	function( $original_email_from ) {
		return get_field( 'submission_message', 'options' )['from_name'];
	}
);
