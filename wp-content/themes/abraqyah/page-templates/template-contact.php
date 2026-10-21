<?php
/**
 * Template Name: Contact
 *
 * Faithful port of the supplied contact design (styles: assets/css/contact.css).
 */
get_header();
the_post();

$co   = abq_company();
$sent = isset( $_GET['sent'] ); // phpcs:ignore WordPress.Security.NonceVerification
$err  = isset( $_GET['error'] ) ? sanitize_key( wp_unslash( $_GET['error'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification

// Service dropdown: divisions + "Other", with optional pre-selected service from ?service=slug.
$options = array();
foreach ( abq_divisions() as $division ) {
	$options[ $division->post_title ] = $division->post_title;
}
$options['Other'] = 'Other';

$pre_slug  = isset( $_GET['enquiry_service'] ) ? sanitize_title( wp_unslash( $_GET['enquiry_service'] ) ) : ( isset( $_GET['service'] ) ? sanitize_title( wp_unslash( $_GET['service'] ) ) : '' ); // phpcs:ignore WordPress.Security.NonceVerification
$pre_label = '';
if ( $pre_slug ) {
	$match = get_posts( array( 'post_type' => array( 'page', 'service' ), 'name' => $pre_slug, 'numberposts' => 1, 'post_status' => 'publish' ) );
	if ( $match && ( 'service' === $match[0]->post_type || abq_in_services( $match[0]->ID ) ) ) {
		$pre_label = $match[0]->post_title;
		if ( ! isset( $options[ $pre_label ] ) ) {
			$options = array( $pre_label => $pre_label ) + $options;
		}
	}
}

$lat      = (float) $co['map_lat'];
$lon      = (float) $co['map_lon'];
$bbox     = rawurlencode( ( $lon - 0.15 ) . ',' . ( $lat - 0.125 ) . ',' . ( $lon + 0.15 ) . ',' . ( $lat + 0.125 ) );
$map_src  = 'https://www.openstreetmap.org/export/embed.html?bbox=' . $bbox . '&layer=mapnik&marker=' . rawurlencode( $lat . ',' . $lon );
$map_link = 'https://www.openstreetmap.org/?mlat=' . rawurlencode( $lat ) . '&mlon=' . rawurlencode( $lon ) . '#map=12/' . rawurlencode( $lat ) . '/' . rawurlencode( $lon );
$hero_img = abq_hero_image( has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '' );
$sub      = has_excerpt() ? get_the_excerpt() : 'Send an enquiry about pipeline, mechanical or nitrogen services, or reach us directly by phone or email.';
?>
<div class="cp">

	<!-- HERO -->
	<section class="cp-hero" style="--cp-hero-img:url('<?php echo esc_url( $hero_img ); ?>')">
		<div class="cp-wrap">
			<div class="fx" style="--d:0"><?php echo abq_breadcrumbs(); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
			<h1 class="split">Tell Us What You Need Done</h1>
			<p class="fx" style="--d:3"><?php echo esc_html( $sub ); ?></p>
		</div>
	</section>

	<!-- CONTACT -->
	<section class="cp-contact">
		<div class="cp-wrap cp-contact-grid">

			<div data-stagger>
				<div class="cp-eyebrow rv"><b>01</b><i></i><span>Get in touch</span></div>
				<h2 class="rv">One contact point for all three divisions.</h2>
				<p class="cp-lead rv">Pipeline pre-commissioning, rotating equipment and nitrogen generation services across <?php echo esc_html( $co['region'] ); ?>. Tell us the scope and we will come back with the right people.</p>

				<ul class="cp-info">
					<li class="rv">
						<?php echo abq_icon( 'phone' ); // phpcs:ignore ?>
						<div>
							<span class="cp-lbl">Call us</span>
							<?php if ( $co['phone1'] ) : ?><strong><a href="tel:<?php echo esc_attr( abq_tel_number( $co['phone1'] ) ); ?>"><?php echo esc_html( $co['phone1'] ); ?></a></strong><?php endif; ?>
							<?php if ( $co['phone2'] ) : ?><strong><a href="tel:<?php echo esc_attr( abq_tel_number( $co['phone2'] ) ); ?>"><?php echo esc_html( $co['phone2'] ); ?></a></strong><?php endif; ?>
							<span class="cp-note"><?php echo esc_html( $co['person'] ); ?> · <?php echo esc_html( $co['role'] ); ?></span>
						</div>
					</li>
					<li class="rv">
						<?php echo abq_icon( 'mail' ); // phpcs:ignore ?>
						<div>
							<span class="cp-lbl">Email us</span>
							<strong><a href="mailto:<?php echo esc_attr( antispambot( $co['email'] ) ); ?>"><?php echo esc_html( antispambot( $co['email'] ) ); ?></a></strong>
						</div>
					</li>
					<li class="rv">
						<?php echo abq_icon( 'pin' ); // phpcs:ignore ?>
						<div>
							<span class="cp-lbl">Location</span>
							<strong><?php echo esc_html( $co['city'] ); ?></strong>
							<strong><?php echo esc_html( $co['country'] ); ?></strong>
						</div>
					</li>
					<li class="rv">
						<?php echo abq_icon( 'clock' ); // phpcs:ignore ?>
						<div>
							<span class="cp-lbl">Office hours</span>
							<strong>Sunday–Thursday · 8:00 AM–5:00 PM AST</strong>
						</div>
					</li>
				</ul>
			</div>

			<div class="cp-card rv" id="enquiry-form">
				<?php if ( $sent ) : ?>
					<div class="cp-notice cp-notice--ok" role="status"><strong>Thank you.</strong> Your enquiry has been sent. We will come back to you shortly.</div>
				<?php elseif ( $err ) : ?>
					<div class="cp-notice cp-notice--err" role="alert"><?php echo esc_html( abq_enquiry_error_message( $err ) ); ?></div>
				<?php endif; ?>

				<form class="cp-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate>
					<input type="hidden" name="action" value="abq_enquiry">
					<input type="hidden" name="abq_ts" value="<?php echo esc_attr( time() ); ?>">
					<?php wp_nonce_field( 'abq_enquiry', '_abq_nonce' ); ?>
					<div class="hp" aria-hidden="true"><label>Website <input type="text" name="abq_website" tabindex="-1" autocomplete="off"></label></div>

					<div class="cp-field"><label for="abq-name">Name <span>*</span></label><input id="abq-name" name="abq_name" type="text" placeholder="Your full name" autocomplete="name" required></div>
					<div class="cp-field"><label for="abq-email">Email <span>*</span></label><input id="abq-email" name="abq_email" type="email" placeholder="you@company.com" autocomplete="email" required></div>
					<div class="cp-field"><label for="abq-phone">Phone <span>*</span></label><input id="abq-phone" name="abq_phone" type="tel" placeholder="+966 5x xxx xxxx" autocomplete="tel" required></div>
					<div class="cp-field">
						<label for="abq-service">Service enquired <span>*</span></label>
						<select id="abq-service" name="abq_service" required>
							<option value="" disabled <?php selected( '', $pre_label ); ?>>Select a service</option>
							<?php foreach ( $options as $value => $label ) : ?>
								<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $pre_label, $value ); ?>><?php echo esc_html( $label ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="cp-field cp-full"><label for="abq-message">Message <span>*</span></label><textarea id="abq-message" name="abq_message" placeholder="Scope, site, quantities, timing — anything that helps us quote accurately." required></textarea></div>
					<div class="cp-submit">
						<button class="cp-btn" type="submit">Send enquiry <?php echo abq_icon( 'arrow' ); // phpcs:ignore ?></button>
						<small>We use these details only to respond to your enquiry.</small>
					</div>
				</form>
			</div>
		</div>
	</section>

	<!-- MAP -->
	<section class="cp-mapsec">
		<div class="cp-wrap">
			<div class="cp-eyebrow rv"><b>02</b><i></i><span>Where to find us</span></div>
			<div class="cp-maphead rv">
				<h2><?php echo esc_html( $co['city'] ); ?></h2>
				<a class="cp-maplink" href="<?php echo esc_url( $map_link ); ?>" target="_blank" rel="noopener">Open in maps ↗</a>
			</div>
			<div class="cp-mapbox rv"><iframe title="Map of <?php echo esc_attr( $co['city'] ); ?>" loading="lazy" src="<?php echo esc_url( $map_src ); ?>"></iframe></div>
			<p class="cp-mapnote">The map marks the wider area. <span>Exact office address to be confirmed</span></p>
		</div>
	</section>

</div>
<?php get_footer(); ?>
