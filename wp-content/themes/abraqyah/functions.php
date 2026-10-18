<?php
/**
 * Abraqyah International – theme setup.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ABQ_VERSION', '1.0.0' );

require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/contact-form.php';
require_once get_template_directory() . '/inc/career-form.php';
require_once get_template_directory() . '/inc/setup-content.php';

/**
 * Theme supports, menus, image sizes.
 */
function abq_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 80,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Pages get excerpts: they feed hero sub-headings and service cards.
	add_post_type_support( 'page', 'excerpt' );

	add_image_size( 'abq-card', 800, 600, true );
	add_image_size( 'abq-thumb', 160, 160, true );

	register_nav_menus( array(
		'primary' => 'Primary menu',
		'footer'  => 'Footer quick links',
	) );
}
add_action( 'after_setup_theme', 'abq_setup' );

/**
 * Front-end assets.
 */
function abq_assets() {
	wp_enqueue_style(
		'abq-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Roboto:wght@400;500&family=Space+Grotesk:wght@500;600;700&display=swap',
		array(),
		null
	);

	$css = get_template_directory() . '/assets/css/main.css';
	$js  = get_template_directory() . '/assets/js/main.js';

	wp_enqueue_style( 'abq-main', get_template_directory_uri() . '/assets/css/main.css', array( 'abq-fonts' ), file_exists( $css ) ? filemtime( $css ) : ABQ_VERSION );
	if ( is_page_template( 'page-templates/template-about.php' ) ) {
		$about_css = get_template_directory() . '/assets/css/about.css';
		wp_enqueue_style( 'abq-about', get_template_directory_uri() . '/assets/css/about.css', array( 'abq-main' ), file_exists( $about_css ) ? filemtime( $about_css ) : ABQ_VERSION );
	}
	if ( is_front_page() ) {
		$home_css = get_template_directory() . '/assets/css/homepage-after-about.css';
		$home_js  = get_template_directory() . '/assets/js/homepage-work.js';
		wp_enqueue_style( 'abq-home-refresh', get_template_directory_uri() . '/assets/css/homepage-after-about.css', array( 'abq-main' ), file_exists( $home_css ) ? filemtime( $home_css ) : ABQ_VERSION );
		wp_enqueue_script( 'abq-home-work', get_template_directory_uri() . '/assets/js/homepage-work.js', array(), file_exists( $home_js ) ? filemtime( $home_js ) : ABQ_VERSION, array( 'in_footer' => true, 'strategy' => 'defer' ) );
	}
	if ( is_page_template( 'page-templates/template-contact.php' ) ) {
		$ccss = get_template_directory() . '/assets/css/contact.css';
		wp_enqueue_style( 'abq-contact-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@800&family=IBM+Plex+Mono:wght@400;500&display=swap', array(), null );
		wp_enqueue_style( 'abq-contact', get_template_directory_uri() . '/assets/css/contact.css', array( 'abq-main', 'abq-contact-fonts' ), file_exists( $ccss ) ? filemtime( $ccss ) : ABQ_VERSION );
	}
	if ( is_page_template( 'page-templates/template-careers.php' ) ) {
		$career_css = get_template_directory() . '/assets/css/careers.css';
		$career_js  = get_template_directory() . '/assets/js/careers.js';
		wp_enqueue_style( 'abq-careers-fonts', 'https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&display=swap', array(), null );
		wp_enqueue_style( 'abq-careers', get_template_directory_uri() . '/assets/css/careers.css', array( 'abq-main', 'abq-careers-fonts' ), file_exists( $career_css ) ? filemtime( $career_css ) : ABQ_VERSION );
		wp_enqueue_script( 'abq-careers', get_template_directory_uri() . '/assets/js/careers.js', array(), file_exists( $career_js ) ? filemtime( $career_js ) : ABQ_VERSION, array( 'in_footer' => true, 'strategy' => 'defer' ) );
	}
	wp_enqueue_script( 'abq-main', get_template_directory_uri() . '/assets/js/main.js', array(), file_exists( $js ) ? filemtime( $js ) : ABQ_VERSION, array( 'in_footer' => true, 'strategy' => 'defer' ) );
}
add_action( 'wp_enqueue_scripts', 'abq_assets' );

/**
 * Add the .js class before first paint so reveal animations never flash,
 * and content is fully visible if JavaScript is unavailable.
 */
function abq_js_class() {
	echo "<script>document.documentElement.classList.add('js');</script>\n";
}
add_action( 'wp_head', 'abq_js_class', 0 );

/**
 * Preconnect to Google Fonts.
 */
function abq_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'abq_resource_hints', 10, 2 );

/**
 * Organization structured data on the home page.
 */
function abq_schema() {
	if ( ! is_front_page() ) {
		return;
	}
	$co   = abq_company();
	$data = array(
		'@context'  => 'https://schema.org',
		'@type'     => 'Organization',
		'name'      => $co['legal'],
		'url'       => home_url( '/' ),
		'email'     => $co['email'],
		'telephone' => array( abq_tel_number( $co['phone1'] ), abq_tel_number( $co['phone2'] ) ),
		'areaServed' => array( 'Saudi Arabia', 'Bahrain' ),
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
}
add_action( 'wp_head', 'abq_schema', 20 );

/**
 * Body classes useful for styling.
 */
function abq_body_classes( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'is-home';
	}
	return $classes;
}
add_filter( 'body_class', 'abq_body_classes' );

/**
 * Trim the excerpt ellipsis.
 */
add_filter( 'excerpt_more', '__return_empty_string' );

/**
 * Self-heal: if a page that existed before the theme was activated (for example
 * an old "Contact Us" page) has no template assigned, give it the matching theme
 * template the first time it is visited. Pages with a template already set are
 * never touched.
 */
function abq_heal_page_templates() {
	if ( ! is_page() ) {
		return;
	}
	$id = get_queried_object_id();
	if ( ! $id || get_page_template_slug( $id ) ) {
		return;
	}
	$listing = 'page-templates/template-service-listing.php';
	$map     = array(
		'about-us'                                           => 'page-templates/template-about.php',
		'services'                                           => 'page-templates/template-services.php',
		'career'                                             => 'page-templates/template-careers.php',
		'careers'                                            => 'page-templates/template-careers.php',
		'contact-us'                                         => 'page-templates/template-contact.php',
		'contact'                                            => 'page-templates/template-contact.php',
		'services/pipeline'                                  => $listing,
		'services/rotating-equipment'                        => $listing,
		'services/ngu'                                       => $listing,
		'services/pipeline/cleaning-preparation'             => $listing,
		'services/pipeline/testing-inspection'               => $listing,
		'services/pipeline/shutdown-preservation'            => $listing,
	);
	$uri = get_page_uri( $id );
	if ( isset( $map[ $uri ] ) && locate_template( $map[ $uri ] ) ) {
		update_post_meta( $id, '_wp_page_template', $map[ $uri ] );
	}
}
add_action( 'template_redirect', 'abq_heal_page_templates', 1 );
