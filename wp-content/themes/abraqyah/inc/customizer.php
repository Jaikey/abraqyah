<?php
/**
 * Customizer: company details, home copy, images.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function abq_customize_register( WP_Customize_Manager $wp_customize ) {

	$wp_customize->add_panel( 'abq_panel', array(
		'title'    => 'Abraqyah Settings',
		'priority' => 30,
	) );

	// Helper to add a text-ish setting + control.
	$add = function ( $section, $id, $label, $default, $type = 'text', $sanitize = 'sanitize_text_field' ) use ( $wp_customize ) {
		$wp_customize->add_setting( 'abq_' . $id, array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( 'abq_' . $id, array(
			'section' => $section,
			'label'   => $label,
			'type'    => $type,
		) );
	};

	/* --- Company details ------------------------------------------ */
	$wp_customize->add_section( 'abq_company', array( 'title' => 'Company & contact details', 'panel' => 'abq_panel', 'priority' => 10 ) );
	$add( 'abq_company', 'brand_name', 'Brand name (header & footer)', 'ABRAQYAH' );
	$add( 'abq_company', 'brand_sub', 'Brand sub-line', 'International Co. Ltd' );
	$add( 'abq_company', 'legal', 'Legal name (footer copyright)', 'Abraqyah International Company Ltd.' );
	$add( 'abq_company', 'person', 'Contact person', 'Muthu Selvam C' );
	$add( 'abq_company', 'role', 'Contact person role', 'General Manager' );
	$add( 'abq_company', 'phone1', 'Phone 1', '013 830 3345' );
	$add( 'abq_company', 'phone2', 'Phone 2', '+966 55 427 5318' );
	$add( 'abq_company', 'email', 'Enquiry email (form messages are sent here)', 'selvam@abraqyahint.com', 'email', 'sanitize_email' );
	$add( 'abq_company', 'region', 'Regions of operation', 'Saudi Arabia & Bahrain' );
	$add( 'abq_company', 'city', 'Office city / area', 'Dammam, Eastern Province' );
	$add( 'abq_company', 'country', 'Country', 'Saudi Arabia' );
	$add( 'abq_company', 'address_note', 'Address note', 'Street address to be confirmed' );
	$add( 'abq_company', 'hours', 'Office hours', 'Days and hours to be confirmed' );
	$add( 'abq_company', 'map_lat', 'Map latitude', '26.4207' );
	$add( 'abq_company', 'map_lon', 'Map longitude', '50.0888' );
	$add( 'abq_company', 'established', 'Year established (About page)', '' );
	$add( 'abq_company', 'head_office', 'Head office city (About page)', '' );
	$add( 'abq_company', 'footer_blurb', 'Footer description', 'OEM-authorized rotating equipment, pipeline pre-commissioning and nitrogen services for Oil & Gas operations in Saudi Arabia and Bahrain.', 'textarea', 'sanitize_textarea_field' );

	/* --- Home page copy -------------------------------------------- */
	$wp_customize->add_section( 'abq_home', array( 'title' => 'Home page copy', 'panel' => 'abq_panel', 'priority' => 20 ) );
	$add( 'abq_home', 'hero_kicker', 'Hero kicker', 'Engineering • Pipeline • Industrial Services' );
	$add( 'abq_home', 'hero_title', 'Hero headline', 'Engineering Expertise for Critical Oil & Gas Operations', 'textarea', 'sanitize_textarea_field' );
	$add( 'abq_home', 'hero_sub', 'Hero sub-text', 'Specialized pipeline, rotating equipment and nitrogen generation services for demanding industrial projects across Saudi Arabia and Bahrain.', 'textarea', 'sanitize_textarea_field' );
	$add( 'abq_home', 'about_title', 'About heading', 'Specialized Industrial Services Built Around Precision and Reliability', 'textarea', 'sanitize_textarea_field' );
	$add( 'abq_home', 'about_p1', 'About paragraph 1', 'Abraqyah International Co. Ltd (AIC) is a joint-venture company specializing in OEM-authorized services for oil & gas rotating equipment, pipeline pre-commissioning and nitrogen services.', 'textarea', 'sanitize_textarea_field' );
	$add( 'abq_home', 'about_p2', 'About paragraph 2', 'With operations across Saudi Arabia and Bahrain, we bring global OEM partnerships and local expertise to upstream, midstream and downstream projects — committed to quality, safety and on-time delivery.', 'textarea', 'sanitize_textarea_field' );
	$add( 'abq_home', 'stat_number', 'Highlight number (counts up)', '15', 'number', 'absint' );
	$add( 'abq_home', 'stat_label', 'Highlight label', 'OEM manufacturer representations' );
	$add( 'abq_home', 'pipeline_list', 'Pipeline services list (one per line)', implode( "\n", abq_default_pipeline_list() ), 'textarea', 'sanitize_textarea_field' );
	$add( 'abq_home', 'rotating_list', 'Rotating equipment list (one per line: Title | description)', abq_default_rotating_lines(), 'textarea', 'sanitize_textarea_field' );

	/* --- Placeholder sections -------------------------------------- */
	$wp_customize->add_section( 'abq_placeholders', array( 'title' => 'Awaiting-content sections', 'panel' => 'abq_panel', 'priority' => 30, 'description' => 'Projects, EPC logos, HSE certifications and the About-page project table are still "to be provided". Untick to hide them until real content is ready.' ) );
	$wp_customize->add_setting( 'abq_show_placeholders', array( 'default' => true, 'sanitize_callback' => 'rest_sanitize_boolean' ) );
	$wp_customize->add_control( 'abq_show_placeholders', array( 'section' => 'abq_placeholders', 'label' => 'Show placeholder sections', 'type' => 'checkbox' ) );
	foreach ( array( 1 => 'Aramco projects supported', 2 => 'EPC contractors served', 3 => 'Pipeline km serviced', 4 => 'Equipment overhauled' ) as $n => $label ) {
		$add( 'abq_placeholders', 'kpi' . $n, 'About KPI: ' . $label . ' (e.g. 25+)', '' );
	}

	/* --- Images ---------------------------------------------------- */
	$wp_customize->add_section( 'abq_images', array( 'title' => 'Site images', 'panel' => 'abq_panel', 'priority' => 40, 'description' => 'Upload real photography. Until you do, a neutral blueprint placeholder is shown (or drop hero.jpg, pipeline.jpg, rotating.jpg, ngu.jpg, about.jpg, cta.jpg into the theme\'s assets/images folder).' ) );
	$slots = array(
		'hero'     => 'Hero / page header background',
		'about'    => 'About image (home)',
		'pipeline' => 'Pipeline Services image',
		'rotating' => 'Rotating Equipment image',
		'ngu'      => 'Nitrogen Generation image',
		'cta'      => 'Call-to-action background',
	);
	foreach ( $slots as $slot => $label ) {
		$wp_customize->add_setting( 'abq_img_' . $slot, array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'abq_img_' . $slot, array(
			'section'   => 'abq_images',
			'label'     => $label,
			'mime_type' => 'image',
		) ) );
	}
}
add_action( 'customize_register', 'abq_customize_register' );

/* Defaults shared between the Customizer and the home template. */
function abq_default_pipeline_list() {
	return array(
		'Mechanical Cleaning & Gauging',
		'Hydro Testing',
		'De-watering',
		'Drying & Swabbing',
		'Chemical Cleaning',
		'ILI Inspection – Caliper Survey',
		'Baseline Survey',
		'Nitrogen Drying, Purging & Lay-up',
		'De-cruding & De-commissioning',
		'Nitrogen Mothballing',
		'Nitrogen Leak Testing',
		'De-gassing – LEL Removal',
		'Bolt Torquing',
	);
}

function abq_default_rotating_lines() {
	return implode( "\n", array(
		'Compressors | Overhauling and field repair of process compressors.',
		'Turbines | Inspection, overhaul and maintenance support.',
		'Motors | Electric motor servicing and repair.',
		'Pumps | Pump maintenance, repair and overhaul.',
		'Gear Boxes | Gearbox inspection and overhaul.',
		'Valves | Valve maintenance and repair services.',
		'Rotor & Shaft Balancing | Balancing of rotors and shafts.',
		'Machining | Field and workshop machining.',
		'OEM Spare Parts | Supply of OEM spare parts.',
	) );
}

function abq_lines( $mod, $default ) {
	$raw   = get_theme_mod( $mod, $default );
	$lines = preg_split( '/\r\n|\r|\n/', (string) $raw );
	return array_values( array_filter( array_map( 'trim', $lines ), 'strlen' ) );
}
