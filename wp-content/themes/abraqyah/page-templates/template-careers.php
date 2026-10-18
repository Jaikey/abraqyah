<?php
/**
 * Template Name: Careers
 *
 * Career opportunities and application form.
 */
get_header();
the_post();

$jobs = array(
	array(
		'id'       => 'REQ-2026-PL04',
		'title'    => 'Lead Pre-Commissioning Engineer (Pipeline)',
		'category' => 'pipeline',
		'division' => 'Pipeline Services',
		'location' => 'Dammam / On-site',
		'experience' => '5–8 Yrs Exp',
		'type'     => 'Full Time',
		'scope'    => array( 'Direct pipeline flooding, cleaning, gauging, and hydrotesting operations.', 'Prepare commissioning procedures, hydrotest packages, and dew-point drying documentation.', 'Coordinate client representatives, QA/QC inspectors, and field crews.' ),
		'qualifications' => array( 'B.Sc. in Mechanical or Chemical Engineering.', '5+ years of pipeline pre-commissioning experience in GCC oil and gas projects.', 'Transferable Iqama in Saudi Arabia preferred.' ),
	),
	array(
		'id'       => 'REQ-2026-RE11',
		'title'    => 'Senior Rotating Equipment Specialist',
		'category' => 'rotating',
		'division' => 'Rotating Equipment',
		'location' => 'Eastern Province / Bahrain',
		'experience' => '6–10 Yrs Exp',
		'type'     => 'Full Time',
		'scope'    => array( 'Lead condition assessment, precision alignment, overhaul, and balancing of pumps, turbines, and compressors.', 'Coordinate OEM-authorized servicing and vibration analysis during plant turnarounds.', 'Supervise mechanical technician crews in workshops and field deployments.' ),
		'qualifications' => array( 'Diploma or Degree in Mechanical Engineering.', 'ISO Category II or III Vibration Analysis certification preferred.', 'Hands-on experience with API 610 pumps and multi-stage compressors.' ),
	),
	array(
		'id'       => 'REQ-2026-NG02',
		'title'    => 'Nitrogen Generation Unit (NGU) Field Operator',
		'category' => 'nitrogen',
		'division' => 'NGU Services',
		'location' => 'Mobile Fleet (KSA & Bahrain)',
		'experience' => '3–5 Yrs Exp',
		'type'     => 'Shift / Field',
		'scope'    => array( 'Operate mobile nitrogen membrane units and liquid nitrogen pumping packages.', 'Perform pipeline purging, inerting, pressure testing, and catalyst cooling.', 'Execute routine maintenance and compressor monitoring.' ),
		'qualifications' => array( 'Technical Diploma or equivalent high-pressure pumping experience.', 'Valid KSA driving license and gas tester credentials.', 'Direct field experience in high-temperature conditions.' ),
	),
	array(
		'id'       => 'REQ-2026-PL08',
		'title'    => 'Dewatering & Super-Drying Technician',
		'category' => 'pipeline',
		'division' => 'Pipeline Services',
		'location' => 'Eastern Province Sites',
		'experience' => '2–4 Yrs Exp',
		'type'     => 'Rotational Site',
		'scope'    => array( 'Manage pig launching and receiving, foam pig trains, and vacuum or air drying equipment.', 'Monitor dew point readings with precision hygrometers.', 'Document test metrics, manifold lineups, and temporary piping pressure tests.' ),
		'qualifications' => array( 'Technical institute certificate in a mechanical trade.', 'Experience with air compressors, desiccant dryers, and pig traps.' ),
	),
	array(
		'id'       => 'REQ-2026-HS01',
		'title'    => 'Field HSE & Loss Prevention Officer',
		'category' => 'hse',
		'division' => 'HSE & QA/QC',
		'location' => 'Dammam / Major Outages',
		'experience' => '4–7 Yrs Exp',
		'type'     => 'Full Time',
		'scope'    => array( 'Enforce safety policies during hydrotests, inert gas operations, and lifting tasks.', 'Deliver toolbox talks, oversee Job Safety Analyses, and conduct field risk audits.', 'Investigate near misses and maintain environmental compliance reporting.' ),
		'qualifications' => array( 'NEBOSH IGC or IOSH certification.', 'Oil and gas plant maintenance or pipeline project experience in Saudi Arabia.', 'Bilingual English and Arabic preferred.' ),
	),
);

$application_status = isset( $_GET['career_application'] ) ? sanitize_key( wp_unslash( $_GET['career_application'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
$subtitle = has_excerpt() ? get_the_excerpt() : 'Join specialized field engineers, rotating equipment technicians, and pipeline commissioning specialists supporting energy operators across Saudi Arabia and Bahrain.';
?>

<div class="career-page">
	<section class="career-hero">
		<img class="career-hero-image" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/career-bg.png' ) ); ?>" alt="" fetchpriority="high" decoding="async">
		<div class="career-wrap">
			<div class="career-kicker">Careers <span>/</span> Abraqyah International</div>
			<h1>Build the Future of Critical Energy Infrastructure</h1>
			<p><?php echo esc_html( $subtitle ); ?></p>
			<div class="career-metrics" aria-label="Career overview">
				<div><strong>03</strong><span>Specialized divisions</span></div>
				<div><strong>100%</strong><span>Safety-first protocol</span></div>
				<div><strong>KSA &amp; BH</strong><span>Regional operations</span></div>
				<div><strong>24/7</strong><span>Field deployment ready</span></div>
			</div>
		</div>
	</section>

	<section class="career-culture">
		<div class="career-wrap">
			<div class="career-eyebrow"><b>01</b><i></i><span>Why work with us</span></div>
			<h2>Precision engineering backed by OEM-authorized standards.</h2>
			<div class="career-culture-grid">
				<article><span class="career-index">01</span><h3>Elite Industrial Projects</h3><p>Work on high-stakes pipeline pre-commissioning, nitrogen purging, and rotating machinery overhauls for major energy assets.</p></article>
				<article><span class="career-index">02</span><h3>Zero-Harm Safety Culture</h3><p>Build your expertise with rigorous HSE standards, continuous certification, and a shared commitment to safe field work.</p></article>
				<article><span class="career-index">03</span><h3>Local Mastery &amp; Vision 2030</h3><p>Grow technical leadership in the Eastern Province through mentorship and long-term career progression.</p></article>
			</div>
		</div>
	</section>

	<section class="career-jobs" id="openings">
		<div class="career-wrap">
			<div class="career-eyebrow"><b>02</b><i></i><span>Career opportunities</span></div>
			<div class="career-jobs-heading"><h2>Current Openings in Eastern Province &amp; Field Sites</h2><a class="career-button career-button--outline" href="#general-application">General application <span aria-hidden="true">↗</span></a></div>
			<div class="career-filters" role="group" aria-label="Filter jobs by discipline">
				<button type="button" class="is-active" data-career-filter="all">All disciplines <span><?php echo count( $jobs ); ?></span></button>
				<button type="button" data-career-filter="pipeline">Pipeline <span>2</span></button>
				<button type="button" data-career-filter="rotating">Rotating equipment <span>1</span></button>
				<button type="button" data-career-filter="nitrogen">NGU operations <span>1</span></button>
				<button type="button" data-career-filter="hse">HSE &amp; QA/QC <span>1</span></button>
			</div>
			<div class="career-job-list">
				<?php foreach ( $jobs as $job ) : ?>
					<article class="career-job" data-career-category="<?php echo esc_attr( $job['category'] ); ?>">
						<div class="career-job-summary">
							<button class="career-job-toggle" type="button" aria-expanded="false" aria-label="Show details for <?php echo esc_attr( $job['title'] ); ?>">
								<span class="career-job-name"><?php echo esc_html( $job['title'] ); ?><small><?php echo esc_html( $job['id'] . ' · ' . $job['type'] ); ?></small></span>
								<span class="career-tag"><?php echo esc_html( $job['division'] ); ?></span>
								<span class="career-job-meta"><?php echo esc_html( $job['location'] ); ?></span>
								<span class="career-job-meta career-job-experience"><?php echo esc_html( $job['experience'] ); ?></span>
								<span class="career-chevron" aria-hidden="true">⌄</span>
							</button>
							<button class="career-button career-apply" type="button" data-career-title="<?php echo esc_attr( $job['title'] ); ?>" data-career-division="<?php echo esc_attr( $job['division'] ); ?>">Apply</button>
						</div>
						<div class="career-job-detail" hidden>
							<div><h3>Scope &amp; responsibilities</h3><ul><?php foreach ( $job['scope'] as $item ) : ?><li><?php echo esc_html( $item ); ?></li><?php endforeach; ?></ul></div>
							<div><h3>Key qualifications</h3><ul><?php foreach ( $job['qualifications'] as $item ) : ?><li><?php echo esc_html( $item ); ?></li><?php endforeach; ?></ul></div>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="career-application" id="general-application">
		<div class="career-wrap career-application-grid">
			<div class="career-application-intro">
				<div class="career-eyebrow"><b>03</b><i></i><span>Direct application</span></div>
				<h2>Put your experience to work.</h2>
				<p>Share your profile with our technical division managers in Dammam. We review qualified pipeline, rotating equipment, and NGU candidates across Saudi Arabia and Bahrain.</p>
				<div class="career-application-note"><strong>Selection roadmap</strong><span>Credential review · Technical interview · Safety verification · Mobilization</span></div>
			</div>
			<div class="career-form-panel">
				<?php if ( 'sent' === $application_status ) : ?>
					<div class="career-notice career-notice--success" role="status">Thank you. Your application has been sent to our recruitment team.</div>
				<?php elseif ( $application_status ) : ?>
					<div class="career-notice career-notice--error" role="alert"><?php echo esc_html( abq_career_application_error( $application_status ) ); ?></div>
				<?php endif; ?>
				<form class="career-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="action" value="abq_career_application">
					<input type="hidden" name="career_ts" value="<?php echo esc_attr( time() ); ?>">
					<input type="hidden" name="career_return" value="<?php echo esc_url( get_permalink() ); ?>">
					<?php wp_nonce_field( 'abq_career_application', '_career_nonce' ); ?>
					<div class="career-honeypot" aria-hidden="true"><label>Leave this field empty<input type="text" name="career_website" tabindex="-1" autocomplete="off"></label></div>
					<div class="career-field"><label for="career-name">Full name <span>*</span></label><input id="career-name" name="career_name" type="text" autocomplete="name" required></div>
					<div class="career-field"><label for="career-email">Email address <span>*</span></label><input id="career-email" name="career_email" type="email" autocomplete="email" required></div>
					<div class="career-field"><label for="career-phone">Phone / WhatsApp <span>*</span></label><input id="career-phone" name="career_phone" type="tel" autocomplete="tel" required></div>
					<div class="career-field"><label for="career-division">Primary discipline <span>*</span></label><select id="career-division" name="career_division" required><option value="">Select a discipline</option><option>Pipeline Services</option><option>Rotating Equipment</option><option>NGU Services</option><option>HSE &amp; QA/QC</option><option>Other</option></select></div>
					<div class="career-field"><label for="career-experience">Relevant experience <span>*</span></label><select id="career-experience" name="career_experience" required><option value="">Select experience</option><option>1–3 years</option><option>3–5 years</option><option>5–10 years</option><option>10+ years</option></select></div>
					<div class="career-field"><label for="career-residency">Work authorization <span>*</span></label><select id="career-residency" name="career_residency" required><option value="">Select status</option><option>Saudi National</option><option>Transferable Iqama</option><option>GCC National / Resident</option><option>Overseas / Requires new visa</option></select></div>
					<div class="career-field career-field--full"><label for="career-role">Position of interest</label><input id="career-role" name="career_role" type="text" placeholder="Role title or general application"></div>
					<div class="career-field career-field--full"><label for="career-cv">Upload CV <span>*</span></label><input id="career-cv" name="career_cv" type="file" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required><small>PDF, DOC, or DOCX. Maximum file size: 10 MB.</small></div>
					<div class="career-field career-field--full"><label for="career-notes">Certifications &amp; cover note</label><textarea id="career-notes" name="career_notes" rows="4" placeholder="Relevant certifications, notice period, and site readiness"></textarea></div>
					<div class="career-submit career-field--full"><button class="career-button" type="submit">Submit application <span aria-hidden="true">→</span></button><small>Applications are sent securely to our recruitment team.</small></div>
				</form>
			</div>
		</div>
	</section>
</div>
<?php get_footer(); ?>