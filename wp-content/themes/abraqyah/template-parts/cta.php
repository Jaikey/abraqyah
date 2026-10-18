<?php
/**
 * Call-to-action band. Args: title, text.
 */
$args = wp_parse_args( isset( $args ) ? $args : array(), array(
	'title' => 'Planning Your Next Industrial Project?',
	'text'  => 'Talk to our team about your pipeline, mechanical or nitrogen service requirements.',
) );
?>
<section class="cta" id="enquiry">
	<div class="cta__media" data-parallax="0.12"><img src="<?php echo esc_url( abq_img( 'cta' ) ); ?>" alt="" loading="lazy" width="1920" height="1088"></div>
	<div class="cta__shade"></div>
	<div class="container cta__in rv">
		<span class="cta__bar"></span>
		<h2><?php echo esc_html( $args['title'] ); ?></h2>
		<p><?php echo esc_html( $args['text'] ); ?></p>
		<div class="btn-row">
			<a class="btn btn--pri" href="<?php echo esc_url( abq_contact_url() ); ?>">Send an Enquiry <span aria-hidden="true">→</span></a>
			<a class="btn btn--ghost" href="<?php echo esc_url( abq_contact_url() ); ?>">Contact Us</a>
		</div>
	</div>
</section>
