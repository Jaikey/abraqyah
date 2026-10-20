<?php
$args = wp_parse_args( isset( $args ) ? $args : array(), array(
	'contact_url' => abq_contact_url(),
) );
?>

<section class="hn-cta">
	<img src="<?php echo esc_url( abq_img( 'hero' ) ); ?>" alt="" loading="lazy" width="1920" height="1088">
	<div class="hn-cta-shade"></div>
	<div class="container hn-cta-content">
		<div class="hn-eyebrow"><i></i><span>Mobilization &amp; Scoping</span></div>
		<h2>Planning Your Next Turnaround or Pipeline Spread?</h2>
		<p>Connect with our technical team to discuss pipeline parameters, machinery requirements, or turnaround schedules.</p>
		<div class="hn-cta-actions"><a class="btn btn--pri" href="<?php echo esc_url( $args['contact_url'] ); ?>">Submit project scope <span aria-hidden="true">→</span></a><a class="btn btn--ghost" href="tel:+966554275318">Call Technical Desk</a></div>
	</div>
</section>