<?php
/**
 * Starter content: creates the page tree, sets the front page and builds the
 * primary menu the first time the theme is activated. Safe to re-run:
 * existing pages (matched by path) are never overwritten.
 *
 * Disable with: add_filter( 'abq_seed_content', '__return_false' );
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function abq_para( $text ) {
	return "<!-- wp:paragraph -->\n<p>" . esc_html( $text ) . "</p>\n<!-- /wp:paragraph -->";
}

function abq_seed_tree() {
	$listing = 'page-templates/template-service-listing.php';

	$leaf = function ( $title, $slug, $excerpt ) {
		return array( 'title' => $title, 'slug' => $slug, 'excerpt' => $excerpt );
	};

	return array(
		array( 'title' => 'About Us', 'slug' => 'about-us', 'template' => 'page-templates/template-about.php',
			'excerpt' => 'A joint-venture company delivering OEM-authorized rotating equipment, pipeline and nitrogen services across Saudi Arabia and Bahrain.' ),

		array( 'title' => 'Services', 'slug' => 'services', 'template' => 'page-templates/template-services.php',
			'excerpt' => 'Pipeline, rotating equipment and nitrogen generation services for oil and gas operations across Saudi Arabia and Bahrain.',
			'meta' => array( '_abq_kicker' => 'Three divisions. One service partner.' ),
			'children' => array(

				array( 'title' => 'Pipeline Services', 'slug' => 'pipeline', 'template' => $listing,
					'excerpt' => 'Pipeline support from pre-commissioning to de-commissioning. Cleaning, testing, inspection and nitrogen services for critical oil and gas infrastructure.',
					'content' => abq_para( 'Prepare pipeline systems for operation, support inspection and maintenance, and protect assets during shutdown. Our pipeline division brings these scopes together with local execution capability across Saudi Arabia and Bahrain.' ),
					'meta' => array( '_abq_headline' => 'From pre-commissioning to de-commissioning.' ),
					'children' => array(

						array( 'title' => 'Cleaning & preparation', 'slug' => 'cleaning-preparation', 'template' => $listing,
							'excerpt' => 'Prepare the line for testing and commissioning.',
							'children' => array(
								$leaf( 'Mechanical Cleaning & Gauging', 'mechanical-cleaning-gauging', 'Mechanical cleaning and gauging of pipeline systems.' ),
								$leaf( 'Chemical Cleaning', 'chemical-cleaning', 'Chemical cleaning support for pipeline and process systems.' ),
								$leaf( 'De-watering', 'de-watering', 'Removal of water following pipeline testing.' ),
								$leaf( 'Drying & Swabbing', 'drying-swabbing', 'Drying and swabbing to prepare pipelines for the next stage.' ),
							) ),

						array( 'title' => 'Testing & inspection', 'slug' => 'testing-inspection', 'template' => $listing,
							'excerpt' => 'Support pipeline integrity and commissioning requirements.',
							'children' => array(
								$leaf( 'Hydro Testing', 'hydro-testing', 'Hydrostatic testing to support pipeline integrity and commissioning.' ),
								$leaf( 'ILI Inspection – Caliper Survey', 'ili-inspection-caliper-survey', 'In-line inspection with caliper survey of pipeline condition.' ),
								$leaf( 'Baseline Survey', 'baseline-survey', 'Baseline survey to record pipeline condition before service.' ),
								$leaf( 'Nitrogen Leak Testing', 'nitrogen-leak-testing', 'Leak testing of pipeline and plant systems using nitrogen.' ),
							) ),

						array( 'title' => 'Shutdown & preservation', 'slug' => 'shutdown-preservation', 'template' => $listing,
							'excerpt' => 'Support safe shutdown and protection of idle assets.',
							'children' => array(
								$leaf( 'Nitrogen Drying, Purging & Lay-up', 'nitrogen-drying-purging-lay-up', 'Nitrogen drying, purging and lay-up of pipelines.' ),
								$leaf( 'De-cruding & De-commissioning', 'de-cruding-de-commissioning', 'De-cruding and de-commissioning support for pipelines.' ),
								$leaf( 'Nitrogen Mothballing', 'nitrogen-mothballing', 'Nitrogen mothballing to protect idle pipelines and plant.' ),
								$leaf( 'De-gassing – LEL Removal', 'de-gassing-lel-removal', 'De-gassing and LEL removal ahead of safe work.' ),
								$leaf( 'Bolt Torquing', 'bolt-torquing', 'Controlled bolt torquing for flanged connections.' ),
							) ),
					) ),

				array( 'title' => 'Rotating Equipment Services', 'slug' => 'rotating-equipment', 'template' => $listing,
					'excerpt' => 'OEM-authorized maintenance, overhauling and field repair of critical rotating equipment, supported by balancing, machining and OEM spare parts.',
					'content' => abq_para( 'OEM-certified maintenance and overhauling, field repairs, balancing and machining, backed by OEM manufacturer representations and equipment rentals for pumps, compressors and generators.' ),
					'meta' => array( '_abq_headline' => 'Rotating equipment expertise.' ),
					'children' => array(
						$leaf( 'Compressors', 'compressors', 'Overhauling and field repair of process compressors.' ),
						$leaf( 'Turbines', 'turbines', 'Inspection, overhaul and maintenance support.' ),
						$leaf( 'Motors', 'motors', 'Electric motor servicing and repair.' ),
						$leaf( 'Pumps', 'pumps', 'Pump maintenance, repair and overhaul.' ),
						$leaf( 'Gear Boxes', 'gear-boxes', 'Gearbox inspection and overhaul.' ),
						$leaf( 'Valves', 'valves', 'Valve maintenance and repair services.' ),
						$leaf( 'Rotor & Shaft Balancing', 'rotor-shaft-balancing', 'Balancing of rotors and shafts.' ),
						$leaf( 'Machining', 'machining', 'Field and workshop machining.' ),
						$leaf( 'OEM Spare Parts', 'oem-spare-parts', 'Supply of OEM spare parts.' ),
					) ),

				array( 'title' => 'NGU Services', 'slug' => 'ngu', 'template' => $listing,
					'excerpt' => 'Nitrogen Generation Unit services for pipeline and plant operations: purging, drying, leak testing and preservation support.',
					'content' => abq_para( 'Nitrogen purging, leak testing and mothballing support for pipeline and plant operations.' ),
					'meta' => array( '_abq_headline' => 'Nitrogen generation support.' ),
					'children' => array(
						$leaf( 'Drying & Purging', 'drying-purging', 'Nitrogen drying and purging for pipeline and plant systems.' ),
						$leaf( 'Leak Testing', 'leak-testing', 'Nitrogen leak testing support.' ),
						$leaf( 'Lay-up & Mothballing', 'lay-up-mothballing', 'Lay-up and mothballing support for idle assets.' ),
					) ),
			) ),

		array( 'title' => 'Career', 'slug' => 'career', 'template' => '',
			'excerpt' => 'Join an OEM-authorized engineering and field-services team.',
			'content' => abq_para( 'Career opportunities will be listed here. Please send your CV to our enquiry email in the meantime.' ) ),

		array( 'title' => 'Contact Us', 'slug' => 'contact-us', 'template' => 'page-templates/template-contact.php',
			'excerpt' => 'Send an enquiry about pipeline, mechanical or nitrogen services, or reach us directly by phone or email.' ),

		// Legal pages are created as drafts so no placeholder text goes live.
		array( 'title' => 'Privacy Policy', 'slug' => 'privacy-policy', 'template' => '', 'status' => 'draft' ),
		array( 'title' => 'Terms & Conditions', 'slug' => 'terms-and-conditions', 'template' => '', 'status' => 'draft' ),
	);
}

/**
 * Recursively insert pages. Returns an array slug => page ID.
 */
function abq_seed_pages( array $items, $parent_id = 0, $parent_path = '', &$ids = array() ) {
	foreach ( $items as $order => $item ) {
		$path     = ltrim( $parent_path . '/' . $item['slug'], '/' );
		$existing = get_page_by_path( $path );

		if ( $existing ) {
			$id = $existing->ID;
		} else {
			$id = wp_insert_post( array(
				'post_type'    => 'page',
				'post_title'   => $item['title'],
				'post_name'    => $item['slug'],
				'post_status'  => isset( $item['status'] ) ? $item['status'] : 'publish',
				'post_parent'  => $parent_id,
				'menu_order'   => $order,
				'post_excerpt' => isset( $item['excerpt'] ) ? $item['excerpt'] : '',
				'post_content' => isset( $item['content'] ) ? $item['content'] : '',
			), true );
			if ( is_wp_error( $id ) ) {
				continue;
			}
			if ( ! empty( $item['template'] ) ) {
				update_post_meta( $id, '_wp_page_template', $item['template'] );
			}
			if ( ! empty( $item['meta'] ) ) {
				foreach ( $item['meta'] as $key => $value ) {
					update_post_meta( $id, $key, $value );
				}
			}
		}

		$ids[ $path ] = $id;

		if ( ! empty( $item['children'] ) ) {
			abq_seed_pages( $item['children'], $id, $path, $ids );
		}
	}
	return $ids;
}

function abq_seed_menu( array $ids ) {
	$name = 'Primary';
	$menu = wp_get_nav_menu_object( $name );
	if ( $menu ) {
		return; // never touch an existing menu
	}
	$menu_id = wp_create_nav_menu( $name );
	if ( is_wp_error( $menu_id ) ) {
		return;
	}

	$add_page = function ( $page_id, $parent_item = 0, $title = '' ) use ( $menu_id ) {
		$args = array(
			'menu-item-type'      => 'post_type',
			'menu-item-object'    => 'page',
			'menu-item-object-id' => $page_id,
			'menu-item-status'    => 'publish',
			'menu-item-parent-id' => $parent_item,
		);
		if ( $title ) {
			$args['menu-item-title'] = $title;
		}
		return wp_update_nav_menu_item( $menu_id, 0, $args );
	};

	$home = (int) get_option( 'page_on_front' );
	if ( $home ) {
		$add_page( $home, 0, 'Home' );
	}
	if ( isset( $ids['about-us'] ) ) {
		$add_page( $ids['about-us'] );
	}
	if ( isset( $ids['services'] ) ) {
		$services_item = $add_page( $ids['services'] );
		foreach ( array( 'services/pipeline', 'services/rotating-equipment', 'services/ngu' ) as $path ) {
			if ( isset( $ids[ $path ] ) ) {
				$add_page( $ids[ $path ], $services_item );
			}
		}
	}
	foreach ( array( 'career', 'contact-us' ) as $path ) {
		if ( isset( $ids[ $path ] ) ) {
			$add_page( $ids[ $path ] );
		}
	}

	$locations            = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

function abq_seed_content() {
	if ( ! apply_filters( 'abq_seed_content', true ) || get_option( 'abq_content_seeded' ) ) {
		return;
	}

	// Home page + static front page.
	$home = get_page_by_path( 'home' );
	if ( ! $home ) {
		$home_id = wp_insert_post( array(
			'post_type'   => 'page',
			'post_title'  => 'Home',
			'post_name'   => 'home',
			'post_status' => 'publish',
		) );
	} else {
		$home_id = $home->ID;
	}
	if ( $home_id && ! is_wp_error( $home_id ) && 'posts' === get_option( 'show_on_front' ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}

	$ids = abq_seed_pages( abq_seed_tree() );
	abq_seed_menu( $ids );

	update_option( 'abq_content_seeded', 1 );
}
add_action( 'after_switch_theme', 'abq_seed_content' );
