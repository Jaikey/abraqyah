<?php
/**
 * Homepage sections displayed after the hero and company introduction.
 * Receives divisions, service URL, contact URL, and region in $args.
 */
$args = wp_parse_args( isset( $args ) ? $args : array(), array(
	'divisions' => array(),
	'service_url' => home_url( '/services/' ),
	'contact_url' => home_url( '/contact-us/' ),
	'region' => 'Saudi Arabia and Bahrain',
) );
$divisions = $args['divisions'];
$pipeline_url = isset( $divisions[0]['url'] ) ? $divisions[0]['url'] : $args['service_url'];
$rotating_url = isset( $divisions[1]['url'] ) ? $divisions[1]['url'] : $args['service_url'];
$ngu_url = isset( $divisions[2]['url'] ) ? $divisions[2]['url'] : $args['service_url'];

$capabilities = array(
	array( 'Mechanical cleaning, scraping and caliper gauging', 'Hydrostatic testing, dewatering and drying', 'Chemical cleaning, descaling and passivation', 'Pipeline preservation and nitrogen services' ),
	array( 'Compressor, turbine and pump overhauls', 'Rotor inspection and dynamic balancing', 'Laser and reverse-dial shaft alignment', 'Field machining and precision repairs' ),
	array( 'On-site membrane nitrogen generation', 'Purging, inerting and pressure testing', 'Helium-nitrogen leak detection', 'Asset preservation and emergency purge support' ),
);

$service_matrix = array(
	array( 'tag' => '01 · Rotating', 'title' => 'OEM-Certified Maintenance & Overhauling', 'text' => 'Factory-grade teardown, inspection, rotor balancing, and precision reassembly for critical turbomachinery.', 'url' => $rotating_url, 'icon' => 'oem.svg' ),
	array( 'tag' => '02 · Machining', 'title' => 'Field Repairs, Balancing & Machining', 'text' => 'On-site line boring, flange facing, journal reconditioning, and dynamic rotor balancing.', 'url' => $rotating_url, 'icon' => 'machining.svg' ),
	array( 'tag' => '03 · Mechanical', 'title' => 'Compressor, Pump & Valve Services', 'text' => 'Mechanical refurbishment, pump overhauls, seal work, and pressure-relief valve testing.', 'url' => $rotating_url, 'icon' => 'mechanical.svg' ),
	array( 'tag' => '04 · Pipeline', 'title' => 'Pipeline Pre-Commissioning', 'text' => 'Mechanical cleaning, pigging, hydrostatic testing, swabbing, and vacuum drying.', 'url' => $pipeline_url, 'icon' => 'pipeloine.svg' ),
	array( 'tag' => '05 · Testing', 'title' => 'Hydro-Testing & Chemical Cleaning', 'text' => 'High-pressure testing, caliper pigging, and chemical cleaning for process systems.', 'url' => $pipeline_url, 'icon' => 'hydro.svg' ),
	array( 'tag' => '06 · Nitrogen', 'title' => 'Purging, Leak Testing & Preservation', 'text' => 'Nitrogen generation, inerting, helium leak detection, and long-term asset preservation.', 'url' => $ngu_url, 'icon' => 'ngu.svg' ),
);

$projects = array(
	array(
		'category' => 'pipeline',
		'tag' => 'Pipeline Pre-Comm',
		'location' => 'Haradh, KSA',
		'title' => '36-inch Cross-Country Gas Pipeline Pre-Commissioning',
		'image' => abq_img( 'pipeline-testing' ),
		'alt' => 'Field team inspecting a pipeline test manifold',
	),
	array(
		'category' => 'rotating',
		'tag' => 'Rotating TAR',
		'location' => 'Jubail, KSA',
		'title' => '28,000 HP Compressor Train Overhaul & Alignment',
		'image' => abq_img( 'rotating-overhaul' ),
		'alt' => 'Technician inspecting a turbomachinery rotor during overhaul',
	),
	array(
		'category' => 'nitrogen',
		'tag' => 'Nitrogen Services',
		'location' => 'Ras Tanura, KSA',
		'title' => 'Cryogenic Nitrogen Purging & Leak Testing Spread',
		'image' => abq_img( 'ngu-preparation' ),
		'alt' => 'Nitrogen process equipment prepared for field operation',
	),
);
?>

<div class="home-next">
	<section class="hn-pillars" id="services">
		<div class="container">
			<div class="hn-section-head">
				<div><div class="hn-eyebrow"><b>02</b><i></i><span>Core Divisions</span></div><h2>Three Integrated Service Pillars</h2></div>
				<p>Our pipeline, rotating equipment, and nitrogen teams coordinate to support commissioning schedules, turnarounds, and urgent repairs across the region.</p>
			</div>
			<div class="hn-pillar-grid">
				<?php foreach ( $divisions as $index => $division ) : ?>
					<article class="hn-pillar">
						<a class="hn-pillar-media" href="<?php echo esc_url( $division['url'] ); ?>">
							<img src="<?php echo esc_url( $division['img'] ); ?>" alt="" loading="lazy" width="800" height="520">
							<span class="hn-pillar-shade"></span>
							<span class="hn-pillar-title"><small>DIVISION <?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></small><strong><?php echo esc_html( $division['title'] ); ?></strong></span>
						</a>
						<div class="hn-pillar-body">
							<p><?php echo esc_html( $division['desc'] ); ?></p>
							<ul><?php foreach ( isset( $capabilities[ $index ] ) ? $capabilities[ $index ] : array() as $capability ) : ?><li><?php echo esc_html( $capability ); ?></li><?php endforeach; ?></ul>
							<a class="hn-text-link" href="<?php echo esc_url( $division['url'] ); ?>">Explore division <span aria-hidden="true">↗</span></a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="hn-matrix" id="all-services">
		<div class="container">
			<div class="hn-section-head hn-section-head--light">
				<div><div class="hn-eyebrow"><b>03</b><i></i><span>Services &amp; Scope Directory</span></div><h2>Seven Core Industrial Services</h2></div>
				<p>Engineered execution packages for refinery turnarounds, EPC contractors, and upstream projects requiring dependable mobilization.</p>
			</div>
			<div class="hn-service-grid">
				<?php foreach ( $service_matrix as $service ) : ?>
					<article class="hn-service-card">
						<div class="hn-service-card-head"><span class="hn-service-icon" aria-hidden="true"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/icons/' . $service['icon'] ); ?>" alt="" width="15" height="15"></span><span><?php echo esc_html( $service['tag'] ); ?></span></div>
						<h3><?php echo esc_html( $service['title'] ); ?></h3>
						<p><?php echo esc_html( $service['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
			<article class="hn-fleet">
				<div class="hn-fleet-image"><img src="<?php echo esc_url( abq_img( 'pipeline-testing' ) ); ?>" alt="" loading="lazy" width="1000" height="700"><span>FLEET SUPPORT · REGIONAL MOBILIZATION</span></div>
				<div class="hn-fleet-copy">
					<div class="hn-eyebrow"><b>04</b><i></i><span>Expedient Fleet Rentals</span></div>
					<h3>Industrial Equipment Fleet Rentals</h3>
					<p>Coordinated access to air compressors, hydro-test pumps, nitrogen packages, and power equipment for site requirements.</p>
					<div class="hn-fleet-specs"><div><strong><span data-count="1600" data-count-group="true">1,600</span>+ CFM</strong><span>Air compressors</span></div><div><strong><span data-count="15000" data-count-group="true">15,000</span> PSI</strong><span>Test pumps</span></div><div><strong><span data-count="99.9" data-count-decimals="1">99.9</span>%</strong><span>Nitrogen purity</span></div></div>
					<a class="btn btn--pri" href="<?php echo esc_url( add_query_arg( 'service', 'rentals', $args['contact_url'] ) ); ?>">Request fleet details <span aria-hidden="true">→</span></a>
				</div>
			</article>
		</div>
	</section>

	<section class="hn-compliance">
		<div class="container hn-compliance-grid">
			<div class="hn-compliance-copy">
				<div class="hn-eyebrow"><b>05</b><i></i><span>OEM &amp; Compliance Standards</span></div>
				<h2>Global Standards. Localized Execution.</h2>
				<p>Certified field teams and quality engineers work to applicable industry codes and client requirements, with clear inspection records and project documentation.</p>
				<div class="hn-standards">
					<div><small>Turbomachinery</small><strong>API 617 / 618</strong><span>Compressors &amp; Overhauls</span></div>
					<div><small>Process Pumps</small><strong>API 610 / 682</strong><span>Centrifugal &amp; Seals</span></div>
					<div><small>Pressure Piping</small><strong>ASME B31.8</strong><span>Pipeline Standards</span></div>
					<div><small>Dynamic Balancing</small><strong>ISO 1940</strong><span>Rotor Quality</span></div>
				</div>
			</div>
			<div class="hn-compliance-photo">
				<img src="<?php echo esc_url( abq_img( 'rotating-specialist' ) ); ?>" alt="" loading="lazy" width="900" height="1100">
				<div class="hn-photo-caption"><strong>Quality at every stage</strong><span>Inspection · Traceability · Documentation</span></div>
			</div>
		</div>
	</section>

	<section class="hn-work" id="our-works">
		<div class="container">
			<div class="hn-work-head">
				<div><div class="hn-eyebrow"><b>06</b><i></i><span>Our Works</span></div><h2>Field Execution Gallery</h2></div>
				<div class="hn-work-filters" role="group" aria-label="Filter projects">
					<button type="button" class="is-active" data-work-filter="all" aria-pressed="true">All Projects</button>
					<button type="button" data-work-filter="pipeline" aria-pressed="false">Pipeline</button>
					<button type="button" data-work-filter="rotating" aria-pressed="false">Rotating Machinery</button>
					<button type="button" data-work-filter="nitrogen" aria-pressed="false">Nitrogen Services</button>
					<button type="button" data-work-filter="offshore" aria-pressed="false">Offshore</button>
				</div>
			</div>
			<div class="hn-work-grid">
				<?php foreach ( $projects as $project ) : ?>
					<article class="hn-work-card" data-work-category="<?php echo esc_attr( $project['category'] ); ?>">
						<div class="hn-work-image"><img src="<?php echo esc_url( $project['image'] ); ?>" alt="<?php echo esc_attr( $project['alt'] ); ?>" loading="lazy" width="800" height="520"></div>
						<div class="hn-work-copy">
							<div class="hn-work-meta"><span><?php echo esc_html( $project['tag'] ); ?></span><span><?php echo esc_html( $project['location'] ); ?></span></div>
							<h3><?php echo esc_html( $project['title'] ); ?></h3>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			<p class="hn-work-empty" role="status" hidden>No offshore project entries have been added yet.</p>
		</div>
	</section>

	<?php get_template_part( 'template-parts/cta', null, array( 'contact_url' => $args['contact_url'] ) ); ?>
</div>