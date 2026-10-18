<?php
/**
 * Career application form handler.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function abq_career_application_redirect( $status ) {
	$return = isset( $_POST['career_return'] ) ? esc_url_raw( wp_unslash( $_POST['career_return'] ) ) : home_url( '/career/' );
	$return = wp_validate_redirect( $return, home_url( '/career/' ) );
	$return = remove_query_arg( 'career_application', $return );
	wp_safe_redirect( add_query_arg( 'career_application', $status, $return ) . '#general-application' );
	exit;
}

function abq_handle_career_application() {
	$nonce = isset( $_POST['_career_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['_career_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'abq_career_application' ) ) {
		abq_career_application_redirect( 'expired' );
	}

	if ( ! empty( $_POST['career_website'] ) ) {
		abq_career_application_redirect( 'sent' );
	}

	$submitted_at = isset( $_POST['career_ts'] ) ? absint( $_POST['career_ts'] ) : 0;
	if ( ! $submitted_at || ( time() - $submitted_at ) < 3 ) {
		abq_career_application_redirect( 'fast' );
	}

	$ip       = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$rate_key = 'abq_career_' . md5( $ip );
	$hits     = (int) get_transient( $rate_key );
	if ( $hits >= 5 ) {
		abq_career_application_redirect( 'limit' );
	}

	$name       = isset( $_POST['career_name'] ) ? sanitize_text_field( wp_unslash( $_POST['career_name'] ) ) : '';
	$email      = isset( $_POST['career_email'] ) ? sanitize_email( wp_unslash( $_POST['career_email'] ) ) : '';
	$phone      = isset( $_POST['career_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['career_phone'] ) ) : '';
	$division   = isset( $_POST['career_division'] ) ? sanitize_text_field( wp_unslash( $_POST['career_division'] ) ) : '';
	$experience = isset( $_POST['career_experience'] ) ? sanitize_text_field( wp_unslash( $_POST['career_experience'] ) ) : '';
	$residency  = isset( $_POST['career_residency'] ) ? sanitize_text_field( wp_unslash( $_POST['career_residency'] ) ) : '';
	$role       = isset( $_POST['career_role'] ) ? sanitize_text_field( wp_unslash( $_POST['career_role'] ) ) : '';
	$notes      = isset( $_POST['career_notes'] ) ? sanitize_textarea_field( wp_unslash( $_POST['career_notes'] ) ) : '';

	$divisions = array( 'Pipeline Services', 'Rotating Equipment', 'NGU Services', 'HSE & QA/QC', 'Other' );
	$experience_options = array( '1–3 years', '3–5 years', '5–10 years', '10+ years' );
	$residency_options = array( 'Saudi National', 'Transferable Iqama', 'GCC National / Resident', 'Overseas / Requires new visa' );
	if ( '' === $name || '' === $phone || ! is_email( $email ) || ! in_array( $division, $divisions, true ) || ! in_array( $experience, $experience_options, true ) || ! in_array( $residency, $residency_options, true ) ) {
		abq_career_application_redirect( 'invalid' );
	}

	if ( ! isset( $_FILES['career_cv'] ) || UPLOAD_ERR_OK !== (int) $_FILES['career_cv']['error'] ) {
		abq_career_application_redirect( 'upload' );
	}

	$cv = $_FILES['career_cv'];
	if ( ! is_uploaded_file( $cv['tmp_name'] ) || (int) $cv['size'] > 10 * MB_IN_BYTES || 0 === (int) $cv['size'] ) {
		abq_career_application_redirect( 'size' );
	}

	$allowed_mimes = array(
		'pdf'  => 'application/pdf',
		'doc'  => 'application/msword',
		'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
	);
	$file_type = wp_check_filetype_and_ext( $cv['tmp_name'], sanitize_file_name( $cv['name'] ), $allowed_mimes );
	if ( empty( $file_type['ext'] ) || empty( $file_type['type'] ) ) {
		abq_career_application_redirect( 'type' );
	}

	$temp_file = tempnam( sys_get_temp_dir(), 'abq-cv-' );
	if ( ! $temp_file || ! move_uploaded_file( $cv['tmp_name'], $temp_file ) ) {
		if ( $temp_file ) {
			unlink( $temp_file );
		}
		abq_career_application_redirect( 'upload' );
	}

	$to      = get_theme_mod( 'abq_career_email', 'careers@abraqyahint.com' );
	$to      = is_email( $to ) ? $to : get_option( 'admin_email' );
	$subject = sprintf( '[%s] Career application: %s', wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ), $name );
	$body    = "New career application\n\n"
		. "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\n"
		. "Discipline: {$division}\nExperience: {$experience}\nWork authorization: {$residency}\n"
		. "Position: {$role}\n\nCertifications / cover note:\n{$notes}\n";
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	set_transient( $rate_key, $hits + 1, HOUR_IN_SECONDS );
	$sent = wp_mail( $to, $subject, $body, $headers, array( $temp_file ) );
	unlink( $temp_file );
	if ( ! $sent ) {
		abq_career_application_redirect( 'mail' );
	}

	abq_career_application_redirect( 'sent' );
}
add_action( 'admin_post_nopriv_abq_career_application', 'abq_handle_career_application' );
add_action( 'admin_post_abq_career_application', 'abq_handle_career_application' );

function abq_career_application_error( $code ) {
	$messages = array(
		'invalid' => 'Please complete all required fields with valid details and try again.',
		'expired' => 'Your session expired. Reload the page and submit your application again.',
		'fast'    => 'Please check your details and submit the form again.',
		'limit'   => 'Too many applications were submitted from this connection. Please try again later.',
		'upload'  => 'We could not receive your CV. Please try again with a PDF, DOC, or DOCX file.',
		'size'    => 'Your CV must be larger than 0 bytes and no more than 10 MB.',
		'type'    => 'Please upload your CV as a PDF, DOC, or DOCX file.',
		'mail'    => 'We could not send your application. Please email careers@abraqyahint.com directly.',
	);
	return isset( $messages[ $code ] ) ? $messages[ $code ] : 'Something went wrong. Please try again.';
}