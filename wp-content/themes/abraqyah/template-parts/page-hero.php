<?php
/**
 * Inner-page hero. Args: kicker, title, sub, quick (bool), image (url).
 */
$args  = wp_parse_args( isset( $args ) ? $args : array(), array(
	'kicker' => '',
	'title'  => '',
	'sub'    => '',
	'quick'  => false,
	'image'  => '',
) );
$image = abq_hero_image( $args['image'] );
?>
<section class="page-hero">
	<div class="page-hero__media" data-parallax="0.18"><img src="<?php echo esc_url( $image ); ?>" alt="" width="1920" height="1088" fetchpriority="high"></div>
	<div class="page-hero__shade"></div>
	<div class="container page-hero__in">
		<div class="fx" style="--d:0"><?php echo abq_breadcrumbs(); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
		<?php if ( $args['kicker'] ) : ?><p class="kicker fx" style="--d:1"><?php echo esc_html( $args['kicker'] ); ?></p><?php endif; ?>
		<h1 class="split"><?php echo esc_html( $args['title'] ); ?></h1>
		<?php if ( $args['sub'] ) : ?><p class="page-hero__sub fx" style="--d:3"><?php echo esc_html( $args['sub'] ); ?></p><?php endif; ?>
	</div>
	<?php if ( $args['quick'] ) { echo abq_quick_nav(); // phpcs:ignore WordPress.Security.EscapeOutput
	} ?>
</section>
