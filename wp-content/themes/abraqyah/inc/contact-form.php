<?php
/**
 * Enquiry form handler (admin-post.php, no plugin required).
 *
 * Protection: nonce, honeypot field, minimum fill time, per-IP rate limit.
 * Delivery uses wp_mail(); install an SMTP plugin (e.g. WP Mail SMTP) for reliable delivery.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function abq_enquiry_redirect( $status, $code = '' ) {
	$back = wp_get_referer();
	if ( ! $back ) {
		$back = abq_contact_url();
	}
	$back = remove_query_arg( array( 'sent', 'error' ), $back );
	$back = add_query_arg( 'sent' === $status ? array( 'sent' => 1 ) : array( 'error' => $code ), $back );
	wp_safe_redirect( $back . '#enquiry-form' );
	exit;
}

function abq_handle_enquiry() {
	$nonce = isset( $_POST['_abq_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['_abq_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'abq_enquiry' ) ) {
		abq_enquiry_redirect( 'error', 'expired' );
	}

	// Honeypot: bots fill hidden fields.
	if ( ! empty( $_POST['abq_website'] ) ) {
		abq_enquiry_redirect( 'sent' ); // pretend success
	}

	// Too fast to be human (< 3 seconds).
	$ts = isset( $_POST['abq_ts'] ) ? absint( $_POST['abq_ts'] ) : 0;
	if ( $ts && ( time() - $ts ) < 3 ) {
		abq_enquiry_redirect( 'error', 'fast' );
	}

	// Rate limit: 5 submissions per hour per IP.
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key = 'abq_enq_' . md5( $ip );
	$hit = (int) get_transient( $key );
	if ( $hit >= 5 ) {
		abq_enquiry_redirect( 'error', 'limit' );
	}

	$name    = isset( $_POST['abq_name'] ) ? sanitize_text_field( wp_unslash( $_POST['abq_name'] ) ) : '';
	$email   = isset( $_POST['abq_email'] ) ? sanitize_email( wp_unslash( $_POST['abq_email'] ) ) : '';
	$phone   = isset( $_POST['abq_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['abq_phone'] ) ) : '';
	$service = isset( $_POST['abq_service'] ) ? sanitize_text_field( wp_unslash( $_POST['abq_service'] ) ) : '';
	$message = isset( $_POST['abq_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['abq_message'] ) ) : '';

	if ( '' === $name || '' === $phone || '' === $service || '' === $message || ! is_email( $email ) ) {
		abq_enquiry_redirect( 'error', 'invalid' );
	}

	$co      = abq_company();
	$to      = is_email( $co['email'] ) ? $co['email'] : get_option( 'admin_email' );
	$subject = sprintf( '[%s] Enquiry: %s – %s', wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ), $service, $name );
	$body    = "New website enquiry\n\n"
		. "Name: {$name}\n"
		. "Email: {$email}\n"
		. "Phone: {$phone}\n"
		. "Service: {$service}\n\n"
		. "Message:\n{$message}\n";
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	$sent = wp_mail( $to, $subject, $body, $headers );
	set_transient( $key, $hit + 1, HOUR_IN_SECONDS );

	if ( ! $sent ) {
		abq_enquiry_redirect( 'error', 'mail' );
	}
	abq_enquiry_redirect( 'sent' );
}
add_action( 'admin_post_nopriv_abq_enquiry', 'abq_handle_enquiry' );
add_action( 'admin_post_abq_enquiry', 'abq_handle_enquiry' );

function abq_enquiry_error_message( $code ) {
	$messages = array(
		'invalid' => 'Please complete every field with a valid email address and try again.',
		'expired' => 'Your session expired. Please reload the page and send the form again.',
		'fast'    => 'That was very quick. Please check your details and send again.',
		'limit'   => 'Too many enquiries from this connection. Please try again later or call us.',
		'mail'    => 'We could not send your enquiry. Please email or call us directly.',
	);
	return isset( $messages[ $code ] ) ? $messages[ $code ] : 'Something went wrong. Please try again.';
}
