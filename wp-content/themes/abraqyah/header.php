<?php
/**
 * Site header.
 */
$co = abq_company();
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<meta name="theme-color" content="#0c1a2b">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main">Skip to content</a>
<div class="scroll-progress" aria-hidden="true"></div>

<header class="site-header" id="site-header">
	<div class="container header-inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( $co['legal'] ); ?> – home">
			<span class="brand__mark">
				<?php
				if ( has_custom_logo() ) {
					echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full', false, array( 'alt' => '' ) );
				}
				?>
			</span>
			<span class="brand__text"><b><?php echo esc_html( $co['brand_name'] ); ?></b><small><?php echo esc_html( $co['brand_sub'] ); ?></small></span>
		</a>

		<nav class="primary-nav" id="primary-nav" aria-label="Primary">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'menu',
				'depth'          => 2,
				'fallback_cb'    => 'abq_fallback_menu',
			) );
			?>
			<a class="btn btn--pri mobile-cta" href="<?php echo esc_url( abq_contact_url() ); ?>">Send an Enquiry</a>
		</nav>

		<a class="btn btn--pri header-cta" href="<?php echo esc_url( abq_contact_url() ); ?>">Send an Enquiry</a>

		<button class="burger" id="nav-toggle" type="button" aria-controls="primary-nav" aria-expanded="false" aria-label="Open menu">
			<span></span>
		</button>
	</div>
</header>

<main id="main" class="site-main">
