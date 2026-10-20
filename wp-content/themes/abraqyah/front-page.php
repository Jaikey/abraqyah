<?php
/**
 * Home page.
 */
get_header();

$co        = abq_company();
$contact   = abq_contact_url();
$root      = abq_services_root();
$svc_url   = $root ? get_permalink( $root ) : '#services';
$about_pg  = abq_page_by_template( 'page-templates/template-about.php' );
$about_url = $about_pg ? get_permalink( $about_pg ) : '#about';

$hero_kicker = get_theme_mod( 'abq_hero_kicker', 'Engineering • Pipeline • Industrial Services' );
$hero_title  = get_theme_mod( 'abq_hero_title', 'Engineering Expertise for Critical Oil & Gas Operations' );
$hero_sub    = get_theme_mod( 'abq_hero_sub', 'Specialized pipeline, rotating equipment and nitrogen generation services for demanding industrial projects across Saudi Arabia and Bahrain.' );
$about_title = get_theme_mod( 'abq_about_title', 'Specialized Industrial Services Built Around Precision and Reliability' );
$about_p1    = get_theme_mod( 'abq_about_p1', 'Abraqyah International Co. Ltd (AIC) is a joint-venture company specializing in OEM-authorized services for oil & gas rotating equipment, pipeline pre-commissioning and nitrogen services.' );
$about_p2    = get_theme_mod( 'abq_about_p2', 'With operations across Saudi Arabia and Bahrain, we bring global OEM partnerships and local expertise to upstream, midstream and downstream projects — committed to quality, safety and on-time delivery.' );
$stat_n      = (int) get_theme_mod( 'abq_stat_number', 15 );
$stat_l      = get_theme_mod( 'abq_stat_label', 'OEM manufacturer representations' );

// Divisions come from the Services page tree; fall back to defaults if it has not been built yet.
$slots = array( 'pipeline', 'rotating', 'ngu' );
$divs  = array();
foreach ( abq_divisions() as $i => $division ) {
	$divs[] = array(
		'title' => $division->post_title,
		'url'   => get_permalink( $division ),
		'desc'  => abq_card_desc( $division, 28 ),
		'img'   => abq_thumb( $division, 'large', isset( $slots[ $i ] ) ? $slots[ $i ] : 'hero' ),
	);
}
if ( ! $divs ) {
	$divs = array(
		array( 'title' => 'Pipeline Services', 'url' => $svc_url, 'desc' => 'Pipeline pre-commissioning, de-cruding, de-commissioning, nitrogen services and related pipeline activities.', 'img' => abq_img( 'pipeline' ) ),
		array( 'title' => 'Rotating Equipment Services', 'url' => $svc_url, 'desc' => 'OEM-certified overhauling of compressors, turbines, pumps, motors and gearboxes, plus balancing, valves, machining and OEM spares.', 'img' => abq_img( 'rotating' ) ),
		array( 'title' => 'NGU Services', 'url' => $svc_url, 'desc' => 'Nitrogen purging, leak testing and mothballing support for pipeline and plant operations.', 'img' => abq_img( 'ngu' ) ),
	);
}
?>

<!-- HERO -->
<section class="hero">
	<div class="hero__media" data-parallax="0.22"><img src="<?php echo esc_url( abq_hero_image() ); ?>" alt="" width="1920" height="1088" fetchpriority="high"></div>
	<div class="hero__shade"></div>
	<div class="container hero__in">
		<p class="eyebrow on-muted fx" style="--d:0"><span class="pri">■</span>&nbsp; <?php echo esc_html( $hero_kicker ); ?></p>
		<h1 class="split"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="hero__lead fx" style="--d:3"><?php echo esc_html( $hero_sub ); ?></p>
		<div class="btn-row fx" style="--d:4">
			<a href="<?php echo esc_url( $svc_url ); ?>" class="btn btn--pri">Explore Our Services <span aria-hidden="true">→</span></a>
			<a href="<?php echo esc_url( $contact ); ?>" class="btn btn--ghost">Send an Enquiry</a>
		</div>
	</div>
	<div class="hero__scroll fx" style="--d:5" aria-hidden="true"><span>Scroll</span><i></i></div>
</section>

<!-- ABOUT -->
<section class="section about" id="about">
	<div class="container g12">
		<div class="c6 about__media">
			<div class="rv-clip">
				<img class="about__img" src="<?php echo esc_url( get_template_directory_uri().'/assets/images/pipeline.jpg' ); ?>" alt="" loading="lazy" width="1280" height="960">
				<div class="about__stat rv" data-rv="left">
					<p class="n"><span data-count="<?php echo esc_attr( $stat_n ); ?>"><?php echo esc_html( $stat_n ); ?></span><span class="pri">+</span></p>
					<p class="eyebrow on-muted"><?php echo esc_html( $stat_l ); ?></p>
				</div>
			</div>
		</div>
		<div class="c6 about__text" data-stagger>
			<div class="label rv"><b>01</b><i></i>Who We Are</div>
			<h2 class="rv"><?php echo esc_html( $about_title ); ?></h2>
			<p class="lead muted rv"><?php echo esc_html( $about_p1 ); ?></p>
			<p class="muted rv"><?php echo esc_html( $about_p2 ); ?></p>
			<div class="tags rv">
				<div><i></i><span class="eyebrow">Engineering</span></div>
				<div><i></i><span class="eyebrow">Pipeline</span></div>
				<div><i></i><span class="eyebrow">Mechanical</span></div>
				<div><i></i><span class="eyebrow">Industrial</span></div>
			</div>
			<div class="rv"><a href="<?php echo esc_url( $about_url ); ?>" class="btn btn--pri">Discover Our Company <span aria-hidden="true">→</span></a></div>
		</div>
	</div>
</section>


<?php
get_template_part( 'template-parts/homepage-after-about', null, array(
	'divisions'   => $divs,
	'service_url' => $svc_url,
	'contact_url' => $contact,
	'region'      => $co['region'],
) );
?>

<?php get_footer(); ?>
