<?php
/**
 * 404.
 */
get_header();
get_template_part( 'template-parts/page-hero', null, array(
	'kicker' => 'Error 404',
	'title'  => 'This line is not in service',
	'sub'    => 'The page you were looking for has moved or no longer exists.',
) );
?>
<section class="section">
	<div class="container prose-wrap">
		<div class="btn-row">
			<a class="btn btn--pri" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to home <span aria-hidden="true">→</span></a>
			<a class="btn btn--line" href="<?php echo esc_url( abq_contact_url() ); ?>">Contact us</a>
		</div>
	</div>
</section>
<?php
get_footer();
