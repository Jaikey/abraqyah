<?php
/**
 * Template Name: Services Overview
 */
get_header();
the_post();

$primary_categories = get_terms( array(
	'taxonomy'   => 'service-category',
	'parent'     => 0,
	'hide_empty' => false,
	'orderby'    => 'name',
	'order'      => 'ASC',
) );
if ( is_wp_error( $primary_categories ) ) {
	$primary_categories = array();
}
$root_ids   = array_map( 'intval', wp_list_pluck( $primary_categories, 'term_id' ) );
$root_order = array( 'pipeline-services', 'rotating-equipment-services', 'ngu-services' );
usort( $primary_categories, function ( $left, $right ) use ( $root_order ) {
	$left_order  = array_search( $left->slug, $root_order, true );
	$right_order = array_search( $right->slug, $root_order, true );
	$left_order  = false === $left_order ? count( $root_order ) : $left_order;
	$right_order = false === $right_order ? count( $root_order ) : $right_order;
	return $left_order === $right_order ? strcasecmp( $left->name, $right->name ) : $left_order <=> $right_order;
} );

$services_url  = get_permalink();
$route_aliases  = abq_service_directory_route_aliases();
$route_to_slug  = array_flip( $route_aliases );
$route_path     = trim( (string) get_query_var( 'service_category_path' ), '/' );
$selected_term  = null;
if ( $route_path ) {
	$segments = array_values( array_filter( explode( '/', $route_path ), 'strlen' ) );
	$root_slug = isset( $route_to_slug[ $segments[0] ] ) ? $route_to_slug[ $segments[0] ] : sanitize_title( $segments[0] );
	$selected_term = get_term_by( 'slug', $root_slug, 'service-category' );
	if ( ! $selected_term || is_wp_error( $selected_term ) || (int) $selected_term->parent || ! in_array( (int) $selected_term->term_id, $root_ids, true ) ) {
		$selected_term = null;
	} else {
		foreach ( array_slice( $segments, 1 ) as $segment ) {
			$slug      = isset( $route_to_slug[ $segment ] ) ? $route_to_slug[ $segment ] : sanitize_title( $segment );
			$child     = get_term_by( 'slug', $slug, 'service-category' );
			if ( ! $child || is_wp_error( $child ) || (int) $child->parent !== (int) $selected_term->term_id ) {
				$selected_term = null;
				break;
			}
			$selected_term = $child;
		}
	}
} elseif ( isset( $_GET['service_category'] ) ) {
	$selected_slug = sanitize_title( wp_unslash( $_GET['service_category'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
	$selected_term = get_term_by( 'slug', $selected_slug, 'service-category' );
	if ( $selected_term && ! is_wp_error( $selected_term ) ) {
		$root_term = $selected_term;
		while ( $root_term->parent ) {
			$root_term = get_term( (int) $root_term->parent, 'service-category' );
			if ( ! $root_term || is_wp_error( $root_term ) ) {
				$root_term = null;
				break;
			}
		}
		if ( ! $root_term || ! in_array( (int) $root_term->term_id, $root_ids, true ) ) {
			$selected_term = null;
		}
	} else {
		$selected_term = null;
	}
}

$browse_terms = $selected_term ? get_terms( array(
	'taxonomy'   => 'service-category',
	'parent'     => (int) $selected_term->term_id,
	'hide_empty' => false,
	'orderby'    => 'name',
	'order'      => 'ASC',
) ) : $primary_categories;
if ( is_wp_error( $browse_terms ) ) {
	$browse_terms = array();
}

$service_posts = array();
if ( $selected_term && ! $browse_terms ) {
	$service_posts = get_posts( array(
		'post_type'      => 'service',
		'post_status'    => 'publish',
		'numberposts'    => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
		'tax_query'      => array(
			array(
				'taxonomy' => 'service-category',
				'field'    => 'term_id',
				'terms'    => (int) $selected_term->term_id,
			),
		),
	) );
}

$category_url = function ( $term ) use ( $services_url ) {
	return abq_service_category_url( $term );
};

$service_image_slot = function ( $term ) {
	while ( $term->parent ) {
		$parent_term = get_term( (int) $term->parent, 'service-category' );
		if ( ! $parent_term || is_wp_error( $parent_term ) ) {
			break;
		}
		$term = $parent_term;
	}
	$slots = array(
		'pipeline-services'           => 'pipeline',
		'rotating-equipment-services' => 'rotating',
		'ngu-services'                => 'ngu',
	);
	return isset( $slots[ $term->slug ] ) ? $slots[ $term->slug ] : 'hero';
};

$kicker    = get_post_meta( get_the_ID(), '_abq_kicker', true );
$hero_title = $selected_term ? $selected_term->name : get_the_title();
$hero_sub   = $selected_term
	? ( $selected_term->description ? $selected_term->description : 'Browse the categories and services in this division.' )
	: ( has_excerpt() ? get_the_excerpt() : '' );

get_template_part( 'template-parts/page-hero', null, array(
	'kicker' => $selected_term ? 'Service directory' : ( $kicker ? $kicker : 'Three divisions. One service partner.' ),
	'title'  => $hero_title,
	'sub'    => $hero_sub,
	'quick'  => true,
	'image'  => has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '',
) );
?>
<?php if ( ! $selected_term ) : ?>
	<section class="section">
		<div class="container">
			<div class="g12 section-head rv">
				<div class="c7">
					<div class="label"><b>01</b><i></i>Service categories</div>
					<h2>Explore our service categories.</h2>
				</div>
				<p class="c5 muted section-head__aside">Choose a service division to browse its categories or available services.</p>
			</div>
			<?php if ( $browse_terms ) : ?>
				<div class="cards cards--3" data-stagger>
					<?php foreach ( $browse_terms as $index => $category ) : ?>
						<?php
						$children = get_terms( array( 'taxonomy' => 'service-category', 'parent' => (int) $category->term_id, 'hide_empty' => false ) );
						$children = is_wp_error( $children ) ? array() : $children;
						$summary  = $children
							? sprintf( '%d %s', count( $children ), 1 === count( $children ) ? 'category' : 'categories' )
							: ( $category->count ? sprintf( '%d %s', (int) $category->count, 1 === (int) $category->count ? 'service' : 'services' ) : 'No services listed yet' );
						$slot = $service_image_slot( $category );
						?>
						<a class="svc-card rv" href="<?php echo esc_url( $category_url( $category ) ); ?>">
							<div class="svc-card__img"><img src="<?php echo esc_url( abq_img( $slot ) ); ?>" alt="" width="800" height="600" loading="lazy"></div>
							<div class="svc-card__body">
								<div class="svc-card__count mono"><?php echo esc_html( sprintf( '%02d / %02d', $index + 1, count( $browse_terms ) ) ); ?></div>
								<h3><?php echo esc_html( $category->name ); ?></h3>
								<p><?php echo esc_html( $category->description ? wp_strip_all_tags( $category->description ) : $summary ); ?></p>
								<span class="explore"><?php echo esc_html( $children ? 'Browse categories' : 'Browse services' ); ?> <?php echo abq_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<p class="service-directory-empty">No service categories have been added yet.</p>
			<?php endif; ?>
			<?php if ( trim( get_the_content() ) ) : ?><div class="prose rv" style="margin-top:64px"><?php the_content(); ?></div><?php endif; ?>
		</div>
	</section>
<?php elseif ( $service_posts ) : ?>
	<?php
	$parent_term = $selected_term->parent ? get_term( (int) $selected_term->parent, 'service-category' ) : null;
	$back_url    = $parent_term && ! is_wp_error( $parent_term ) ? $category_url( $parent_term ) : $services_url;
	$back_label  = $parent_term && ! is_wp_error( $parent_term ) ? $parent_term->name : 'All service categories';
	?>
	<section class="section">
		<div class="container">
			<div class="label rv"><b>01</b><i></i>Services</div>
			<div class="listhead rv">
				<h2>Services in <?php echo esc_html( $selected_term->name ); ?></h2>
				<a class="btn btn--line" href="<?php echo esc_url( $back_url ); ?>"><span aria-hidden="true">←</span><?php echo esc_html( $back_label ); ?></a>
			</div>
			<div class="cards cards--auto" data-stagger>
				<?php foreach ( $service_posts as $index => $service ) { abq_render_card( $service, $index + 1, count( $service_posts ), false, $service_image_slot( $selected_term ), true ); } ?>
			</div>
		</div>
	</section>
<?php else : ?>
	<?php
	$parent_term = $selected_term->parent ? get_term( (int) $selected_term->parent, 'service-category' ) : null;
	$back_url    = $parent_term && ! is_wp_error( $parent_term ) ? $category_url( $parent_term ) : $services_url;
	$back_label  = $parent_term && ! is_wp_error( $parent_term ) ? $parent_term->name : 'All service categories';
	$result_count = count( $browse_terms );
	$intro_text   = $selected_term->description
		? wp_strip_all_tags( $selected_term->description )
		: ( $browse_terms ? sprintf( 'Browse %d categories within %s.', count( $browse_terms ), $selected_term->name ) : sprintf( '%d services available in %s.', count( $service_posts ), $selected_term->name ) );
	?>
	<section class="section">
		<div class="container listing-split">
			<div class="listing-split__intro">
				<div class="sticky rv">
					<div class="label"><b>01</b><i></i>Our capability</div>
					<h2><?php echo esc_html( $selected_term->name ); ?></h2>
					<div class="prose prose--lead muted"><p><?php echo esc_html( $intro_text ); ?></p></div>
					<div class="service-directory-back"><a class="btn btn--line" href="<?php echo esc_url( $back_url ); ?>"><span aria-hidden="true">←</span><?php echo esc_html( $back_label ); ?></a></div>
					<div class="areas"><span class="mono">Areas of operation</span><strong><?php echo esc_html( abq_company()['region'] ); ?></strong></div>
				</div>
			</div>
			<div class="listing-split__list cards cards--1" data-stagger>
				<?php if ( $browse_terms ) : ?>
					<?php foreach ( $browse_terms as $index => $category ) : ?>
						<?php
						$children = get_terms( array( 'taxonomy' => 'service-category', 'parent' => (int) $category->term_id, 'hide_empty' => false ) );
						$children = is_wp_error( $children ) ? array() : $children;
						$summary  = $children
							? sprintf( '%d %s in this category.', count( $children ), 1 === count( $children ) ? 'category' : 'categories' )
							: ( $category->count ? sprintf( '%d %s in this category.', (int) $category->count, 1 === (int) $category->count ? 'service' : 'services' ) : 'No services listed yet.' );
						$category_url_value = $category_url( $category );
						?>
						<article class="svc-card svc-card--row rv">
							<a class="svc-card__img" href="<?php echo esc_url( $category_url_value ); ?>"><img src="<?php echo esc_url( abq_img( $service_image_slot( $category ) ) ); ?>" alt="" width="800" height="600" loading="lazy"></a>
							<div class="svc-card__body">
								<div class="svc-card__count mono"><?php echo esc_html( sprintf( '%02d / %02d', $index + 1, $result_count ) ); ?></div>
								<h3><a href="<?php echo esc_url( $category_url_value ); ?>"><?php echo esc_html( $category->name ); ?></a></h3>
								<p><?php echo esc_html( $category->description ? wp_strip_all_tags( $category->description ) : $summary ); ?></p>
								<a class="explore" href="<?php echo esc_url( $category_url_value ); ?>"><?php echo esc_html( $children ? 'Browse categories' : 'Browse services' ); ?> <?php echo abq_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
							</div>
						</article>
					<?php endforeach; ?>
				<?php else : ?>
					<p class="service-directory-empty">No services are assigned to this category yet.</p>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
<?php
get_template_part( 'template-parts/cta' );
get_footer();
