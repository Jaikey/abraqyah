<?php
/**
 * Template Name: Services Overview
 */
get_header();
the_post();

$divisions = abq_divisions();
$kicker    = get_post_meta( get_the_ID(), '_abq_kicker', true );

get_template_part( 'template-parts/page-hero', null, array(
	'kicker' => $kicker ? $kicker : 'Three divisions. One service partner.',
	'title'  => get_the_title(),
	'sub'    => has_excerpt() ? get_the_excerpt() : '',
	'quick'  => true,
	'image'  => has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '',
) );
?>
<section class="section">
	<div class="container">
		<div class="g12 section-head rv">
			<div class="c7">
				<div class="label"><b>01</b><i></i>Service divisions</div>
				<h2>Specialized capability.<br>Connected delivery.</h2>
			</div>
			<p class="c5 muted section-head__aside">From preparing a pipeline for operation to maintaining rotating machinery and preserving idle systems, explore the division that fits your project.</p>
		</div>
		<div class="cards cards--3" data-stagger>
			<?php
			$slots = array( 'pipeline', 'rotating', 'ngu' );
			foreach ( $divisions as $i => $division ) {
				abq_render_card( $division, $i + 1, count( $divisions ), false, isset( $slots[ $i ] ) ? $slots[ $i ] : 'hero' );
			}
			?>
		</div>
		<?php if ( trim( get_the_content() ) ) : ?>
			<div class="prose rv" style="margin-top:64px"><?php the_content(); ?></div>
		<?php endif; ?>
	</div>
</section>
<?php
get_template_part( 'template-parts/cta' );
get_footer();
