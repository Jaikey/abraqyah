<?php
/**
 * Template Name: About Us
 */
get_header();
the_post();

$co      = abq_company();
$show_ph = (bool) get_theme_mod( 'abq_show_placeholders', true );
$divs    = abq_divisions();
$kpis    = array(
	1 => 'Aramco projects supported',
	2 => 'EPC contractors served',
	3 => 'Pipeline km serviced',
	4 => 'Equipment overhauled',
);

get_template_part( 'template-parts/page-hero', null, array(
	'title' => 'Engineering Services You Can Rely On',
	'sub'   => 'A joint-venture company delivering OEM-authorized rotating equipment, pipeline and nitrogen services across ' . $co['region'] . '.',
	'image' => has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '',
) );
?>

<!-- PROFILE -->
<section class="section" id="profile">
	<div class="container">
		<div class="g12">
			<div class="c5 about__media">
				<div class="rv-clip">
					<img class="about__img" src="<?php echo esc_url( abq_img( 'about' ) ); ?>" alt="" loading="lazy" width="1280" height="960">
					<div class="about__stat rv" data-rv="left">
						<p class="n"><span data-count="<?php echo esc_attr( (int) get_theme_mod( 'abq_stat_number', 15 ) ); ?>"><?php echo esc_html( (int) get_theme_mod( 'abq_stat_number', 15 ) ); ?></span><span class="pri">+</span></p>
						<p class="eyebrow on-muted"><?php echo esc_html( get_theme_mod( 'abq_stat_label', 'OEM manufacturer representations' ) ); ?></p>
					</div>
				</div>
			</div>
			<div class="c7 about__text" data-stagger>
				<div class="label rv"><b>01</b><i></i>Company Profile</div>
				<h2 class="rv">Local Expertise Backed by Global OEM Partnerships</h2>
				<p class="lead muted rv"><?php echo esc_html( get_theme_mod( 'abq_about_p1', 'Abraqyah International Co. Ltd (AIC) is a joint-venture company specializing in OEM-authorized services for oil & gas rotating equipment, pipeline pre-commissioning and nitrogen services.' ) ); ?></p>
				<p class="muted rv">Operating across <?php echo esc_html( $co['region'] ); ?>, we support upstream, midstream and downstream projects with experienced field crews, OEM-aligned procedures and a firm commitment to quality, safety and on-time delivery.</p>
				<?php if ( trim( get_the_content() ) ) : ?><div class="prose rv"><?php the_content(); ?></div><?php endif; ?>
				<div class="facts rv">
					<div><p class="eyebrow">Company type</p><p class="v">Joint venture</p></div>
					<div><p class="eyebrow">Operations</p><p class="v"><?php echo esc_html( $co['region'] ); ?></p></div>
					<div><p class="eyebrow">Established</p><p class="v mono"><?php echo esc_html( $co['established'] ? $co['established'] : '2014' ); ?></p></div>
					<div><p class="eyebrow">Head office</p><p class="v mono"><?php echo esc_html( $co['head_office'] ? $co['head_office'] : 'Saudi Arabia' ); ?></p></div>
				</div>
			</div>
		</div>

		<?php if ( $divs ) : ?>
			<div class="trio" data-stagger>
				<?php foreach ( $divs as $division ) : ?>
					<a class="trio__item rv" href="<?php echo esc_url( get_permalink( $division ) ); ?>">
						<i></i>
						<h3><?php echo esc_html( $division->post_title ); ?></h3>
						<p><?php echo esc_html( abq_card_desc( $division, 16 ) ); ?></p>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<!-- VISION & MISSION -->
<section class="section section--dark section--blueprint" id="vision">
	<div class="container">
		<div class="vm-heading rv">
			<div class="label"><b>02</b><i></i>Vision &amp; Mission</div>
			<h2>What We Work Toward, and How</h2>
			<p>Setting the benchmark for critical oil &amp; gas support with certified OEM authorizations and disciplined field execution.</p>
		</div>
		<div class="vm rv">
			<div class="vm-card">
				<span class="vm-icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2.2 12s3.5-6 9.8-6 9.8 6 9.8 6-3.5 6-9.8 6-9.8-6-9.8-6z"/><circle cx="12" cy="12" r="2.6"/></svg>
				</span>
				<span class="eyebrow pri">Our Vision</span>
				<h3>Trusted Regional Service Partner</h3>
				<p>To be the most trusted OEM-authorized service partner for critical oil &amp; gas operations across Saudi Arabia and Bahrain, keeping essential assets running safely, reliably, and with uncompromised integrity.</p>
			</div>
			<div class="vm-card">
				<span class="vm-icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1" fill="currentColor" stroke="none"/></svg>
				</span>
				<span class="eyebrow pri">Our Mission</span>
				<h3>Precision Field Execution</h3>
				<p>To deliver safe, high-quality, and on-time industrial services backed by factory-trained expertise, supporting upstream, midstream, and downstream operations with disciplined adherence to global standards.</p>
			</div>
		</div>
	</div>
</section>

<?php if ( $show_ph ) : ?>
<!-- TRACK RECORD (awaiting content) -->
<section class="section" id="track-record">
	<div class="container">
		<div class="g12 section-head rv">
			<div class="c7"><div class="label"><b>03</b><i></i>Project Track Record</div><h2>Experience With Aramco EPC Contractors</h2></div>
			<p class="c5 muted section-head__aside">We have supported EPC contractors delivering Saudi Aramco projects, from pipeline pre-commissioning to rotating equipment overhaul.</p>
		</div>

		<div class="kpis" data-stagger>
			<?php foreach ( $kpis as $n => $label ) : ?>
				<?php
				$raw     = trim( (string) get_theme_mod( 'abq_kpi' . $n, '' ) );
				$numeric = preg_match( '/^(\d+)(.*)$/', $raw, $m );
				?>
				<div class="rv">
					<p class="n mono">
						<?php if ( $numeric ) : ?>
							<span data-count="<?php echo esc_attr( $m[1] ); ?>"><?php echo esc_html( $m[1] ); ?></span><?php echo esc_html( $m[2] ); ?>
						<?php else : ?>
							<?php echo esc_html( '' !== $raw ? $raw : '20' ); ?>
						<?php endif; ?>
					</p>
					<p class="eyebrow"><?php echo esc_html( $label ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="logos logos--light mono" data-stagger>
			<?php for ( $i = 0; $i < 4; $i++ ) : ?><div class="rv">[EPC LOGO]</div><?php endfor; ?>
		</div>

		<div class="table-wrap rv">
			<table>
				<thead><tr><th>#</th><th>Project</th><th>EPC contractor</th><th>Scope of work</th><th>Location</th><th>Year</th></tr></thead>
				<tbody>
					<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
						<tr><td class="mono"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></td><td class="pn">[PROJECT NAME]</td><td class="mono">[EPC CONTRACTOR]</td><td class="mono">[SCOPE OF WORK]</td><td class="mono">[LOCATION]</td><td class="mono">[YEAR]</td></tr>
					<?php endfor; ?>
				</tbody>
			</table>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
get_template_part( 'template-parts/cta' );
get_footer();
