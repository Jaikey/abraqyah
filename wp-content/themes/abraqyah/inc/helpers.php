<?php
/**
 * Template helpers.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ------------------------------------------------------------------
 * Company data (Customizer-backed, with sensible defaults)
 * ---------------------------------------------------------------- */
function abq_company() {
	static $c = null;
	if ( null !== $c ) {
		return $c;
	}
	$defaults = array(
		'brand_name'   => 'ABRAQYAH',
		'brand_sub'    => 'International Co. Ltd',
		'legal'        => 'Abraqyah International Company Ltd.',
		'person'       => 'Muthu Selvam C',
		'role'         => 'General Manager',
		'phone1'       => '013 830 3345',
		'phone2'       => '+966 55 427 5318',
		'email'        => 'selvam@abraqyahint.com',
		'region'       => 'Saudi Arabia & Bahrain',
		'city'         => 'Dammam, Eastern Province',
		'country'      => 'Saudi Arabia',
		'address_note' => 'Street address to be confirmed',
		'hours'        => 'Days and hours to be confirmed',
		'map_lat'      => '26.4207',
		'map_lon'      => '50.0888',
		'established'  => '',
		'head_office'  => '',
		'footer_blurb' => 'OEM-authorized rotating equipment, pipeline pre-commissioning and nitrogen services for Oil & Gas operations in Saudi Arabia and Bahrain.',
	);
	foreach ( $defaults as $key => $value ) {
		$defaults[ $key ] = get_theme_mod( 'abq_' . $key, $value );
	}
	$c = $defaults;
	return $c;
}

/**
 * Normalise a phone number for tel: links. Numbers without a leading "+"
 * are treated as Saudi local numbers (+966, leading zero dropped).
 */
function abq_tel_number( $number ) {
	$digits = preg_replace( '/[^\d+]/', '', (string) $number );
	if ( '' === $digits ) {
		return '';
	}
	if ( 0 !== strpos( $digits, '+' ) ) {
		$digits = '+966' . ltrim( $digits, '0' );
	}
	return $digits;
}

/* ------------------------------------------------------------------
 * Images
 * ---------------------------------------------------------------- */
function abq_placeholder() {
	return get_template_directory_uri() . '/assets/images/placeholder.svg';
}

/**
 * Image for a named slot: hero, about, pipeline, rotating, ngu, cta.
 * Order: Customizer upload -> assets/images/{slot}.(jpg|jpeg|webp|png) -> placeholder.
 */
function abq_img( $slot ) {
	$id = absint( get_theme_mod( 'abq_img_' . $slot ) );
	if ( $id ) {
		$url = wp_get_attachment_image_url( $id, 'full' );
		if ( $url ) {
			return $url;
		}
	}
	foreach ( array( 'jpg', 'jpeg', 'webp', 'png' ) as $ext ) {
		$rel = '/assets/images/' . $slot . '.' . $ext;
		if ( file_exists( get_template_directory() . $rel ) ) {
			return get_template_directory_uri() . $rel;
		}
	}
	if ( 'about' === $slot ) {
		return abq_img( 'pipeline' );
	}
	return abq_placeholder();
}

/**
 * URL of a file in the theme's assets/images folder, or '' if it does not exist.
 */
function abq_theme_image( $filename ) {
	$path = get_template_directory() . '/assets/images/' . ltrim( $filename, '/' );
	return file_exists( $path ) ? get_template_directory_uri() . '/assets/images/' . ltrim( $filename, '/' ) . '?v=' . filemtime( $path ) : '';
}

/**
 * Hero banner image used on every page: assets/images/hero.jpg when present,
 * otherwise the supplied fallback, otherwise the Customizer/placeholder image.
 */
function abq_hero_image( $fallback = '' ) {
	$file = abq_theme_image( 'hero.jpg' );
	if ( $file ) {
		return $file;
	}
	return $fallback ? $fallback : abq_img( 'hero' );
}

/**
 * Featured image URL for a page, falling back to a slot image.
 */
function abq_thumb( $post, $size = 'abq-card', $slot = 'hero' ) {
	$post = get_post( $post );
	if ( $post && has_post_thumbnail( $post ) ) {
		$url = get_the_post_thumbnail_url( $post, $size );
		if ( $url ) {
			return $url;
		}
	}
	return abq_img( $slot );
}

/* ------------------------------------------------------------------
 * Small SVG pieces
 * ---------------------------------------------------------------- */
function abq_logo_svg() {
	return '<svg width="26" height="26" viewBox="0 0 26 26" fill="none" aria-hidden="true"><circle cx="13" cy="13" r="8" stroke="#0c1a2b" stroke-width="3" stroke-dasharray="10 4" class="logo-ring"/><circle cx="13" cy="4" r="2" fill="#e54056"/></svg>';
}

function abq_icon( $name ) {
	$paths = array(
		'phone' => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/>',
		'mail'  => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
		'pin'   => '<path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/>',
		'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
		'arrow' => '<path d="M5 12h14M13 6l6 6-6 6"/>',
	);
	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}
	return '<svg class="icon icon--' . esc_attr( $name ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $paths[ $name ] . '</svg>';
}

/**
 * Animated pipeline line used at the foot of heroes. A red "pig" travels along it.
 */
function abq_pipe_line() {
	$d = 'M0 100H260V62H640V100H980V40H1440';
	return '<svg class="pipe-line" viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true" focusable="false">'
		. '<path class="pipe-line__base" d="' . $d . '" vector-effect="non-scaling-stroke"/>'
		. '<path class="pipe-line__pig" d="' . $d . '" pathLength="1000" vector-effect="non-scaling-stroke"/>'
		. '</svg>';
}

/* ------------------------------------------------------------------
 * Page tree helpers (Services > Division > Category > Service)
 * ---------------------------------------------------------------- */
function abq_page_by_template( $template ) {
	static $cache = array();
	if ( array_key_exists( $template, $cache ) ) {
		return $cache[ $template ];
	}
	$found = get_posts( array(
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'meta_key'       => '_wp_page_template',
		'meta_value'     => $template,
		'numberposts'    => 1,
		'orderby'        => 'menu_order ID',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	) );
	$cache[ $template ] = $found ? $found[0] : null;
	return $cache[ $template ];
}

function abq_contact_url() {
	$page = abq_page_by_template( 'page-templates/template-contact.php' );
	return $page ? get_permalink( $page ) : home_url( '/contact-us/' );
}

function abq_services_root() {
	return abq_page_by_template( 'page-templates/template-services.php' );
}

function abq_children( $parent_id ) {
	return get_posts( array(
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'post_parent'    => $parent_id,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
		'numberposts'    => -1,
		'no_found_rows'  => true,
	) );
}

function abq_divisions() {
	$root = abq_services_root();
	return $root ? abq_children( $root->ID ) : array();
}

/** True when the page is the Services root or sits beneath it. */
function abq_in_services( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_queried_object_id();
	$root    = abq_services_root();
	if ( ! $root || ! $post_id ) {
		return false;
	}
	return $post_id === $root->ID || in_array( $root->ID, get_post_ancestors( $post_id ), true );
}

function abq_enquire_url( $post ) {
	$post = get_post( $post );
	return $post ? add_query_arg( 'service', $post->post_name, abq_contact_url() ) : abq_contact_url();
}

function abq_card_desc( $post, $words = 24 ) {
	if ( has_excerpt( $post ) ) {
		return $post->post_excerpt;
	}
	return wp_trim_words( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ), $words, '' );
}

function abq_page_url_by_slug( $slug ) {
	$page = get_page_by_path( $slug );
	return ( $page && 'publish' === $page->post_status ) ? get_permalink( $page ) : '';
}

/* ------------------------------------------------------------------
 * Breadcrumbs + division quick-nav
 * ---------------------------------------------------------------- */
function abq_breadcrumbs() {
	$items = array( array( 'Home', home_url( '/' ) ) );
	if ( is_page() ) {
		$id = get_queried_object_id();
		foreach ( array_reverse( get_post_ancestors( $id ) ) as $ancestor ) {
			$items[] = array( get_the_title( $ancestor ), get_permalink( $ancestor ) );
		}
		$items[] = array( get_the_title( $id ), null );
	} elseif ( is_404() ) {
		$items[] = array( 'Page not found', null );
	} elseif ( is_search() ) {
		$items[] = array( 'Search', null );
	} elseif ( is_home() || is_archive() || is_single() ) {
		$items[] = array( wp_strip_all_tags( get_the_archive_title() ?: get_the_title() ), null );
	}

	$out = '<nav class="crumbs" aria-label="Breadcrumb">';
	$last = count( $items ) - 1;
	foreach ( $items as $i => $item ) {
		if ( $i > 0 ) {
			$out .= '<i>/</i>';
		}
		if ( $item[1] && $i !== $last ) {
			$out .= '<a href="' . esc_url( $item[1] ) . '">' . esc_html( $item[0] ) . '</a>';
		} else {
			$out .= '<span aria-current="page">' . esc_html( $item[0] ) . '</span>';
		}
	}
	return $out . '</nav>';
}

function abq_quick_nav() {
	$divisions = abq_divisions();
	if ( ! $divisions || ! abq_in_services() ) {
		return '';
	}
	$current = get_queried_object_id();
	$chain   = array_merge( array( $current ), get_post_ancestors( $current ) );
	$out     = '<div class="quick"><nav class="container quick__nav" aria-label="Service divisions">';
	foreach ( $divisions as $i => $division ) {
		$active = in_array( $division->ID, $chain, true );
		$out   .= '<a href="' . esc_url( get_permalink( $division ) ) . '"' . ( $active ? ' class="is-active" aria-current="page"' : '' ) . '>'
			. '<span><b>' . sprintf( '%02d', $i + 1 ) . '</b>' . esc_html( $division->post_title ) . '</span>' . abq_icon( 'arrow' ) . '</a>';
	}
	return $out . '</nav></div>';
}

/* ------------------------------------------------------------------
 * Service card (used by Services, Division and Category templates)
 * ---------------------------------------------------------------- */
function abq_render_card( $post, $n, $total = 0, $row = false, $slot = 'hero', $modal = false ) {
	$kids     = abq_children( $post->ID );
	$has_kids = ! empty( $kids );
	$count    = sprintf( '%02d', $n ) . ( $total ? ' / ' . sprintf( '%02d', $total ) : '' );
	$dialog_id = 'service-dialog-' . (int) $post->ID;
	$classes  = 'svc-card rv' . ( $row ? ' svc-card--row' : '' );
	?>
	<article class="<?php echo esc_attr( $classes ); ?>">
		<div class="svc-card__img"><img src="<?php echo esc_url( abq_thumb( $post, 'abq-card', $slot ) ); ?>" alt="" width="800" height="600" loading="lazy"></div>
		<div class="svc-card__body">
			<div class="svc-card__count mono"><?php echo esc_html( $count ); ?></div>
			<h3><?php echo esc_html( $post->post_title ); ?></h3>
			<?php $desc = abq_card_desc( $post ); ?>
			<?php if ( $desc ) : ?><p><?php echo esc_html( $desc ); ?></p><?php endif; ?>
			<?php if ( $has_kids ) : ?>
				<ul class="svc-card__list">
					<?php foreach ( array_slice( $kids, 0, 3 ) as $kid ) : ?>
						<li><?php echo esc_html( $kid->post_title ); ?></li>
					<?php endforeach; ?>
				</ul>
				<a class="explore stretched" href="<?php echo esc_url( get_permalink( $post ) ); ?>">
					Explore <span class="explore__n mono"><?php echo esc_html( count( $kids ) ); ?> <?php echo esc_html( 1 === count( $kids ) ? 'service' : 'services' ); ?></span>
					<?php echo abq_icon( 'arrow' ); // phpcs:ignore ?>
				</a>
			<?php else : ?>
				<?php if ( $modal ) : ?>
					<button class="svc-card__details" type="button" data-service-dialog="<?php echo esc_attr( $dialog_id ); ?>" aria-haspopup="dialog">
						View service overview <span aria-hidden="true">↗</span>
					</button>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php if ( $modal && ! $has_kids ) : ?>
			<dialog class="svc-dialog" id="<?php echo esc_attr( $dialog_id ); ?>" aria-labelledby="<?php echo esc_attr( $dialog_id . '-title' ); ?>">
				<button class="svc-dialog__close" type="button" data-service-dialog-close aria-label="Close service overview">&times;</button>
				<div class="svc-dialog__layout">
					<div class="svc-dialog__media"><img src="<?php echo esc_url( abq_thumb( $post, 'large', $slot ) ); ?>" alt="" width="1000" height="750"></div>
					<div class="svc-dialog__content">
						<p class="svc-dialog__eyebrow">Service overview</p>
						<h2 id="<?php echo esc_attr( $dialog_id . '-title' ); ?>"><?php echo esc_html( $post->post_title ); ?></h2>
						<?php if ( has_excerpt( $post ) ) : ?><p class="svc-dialog__excerpt"><?php echo esc_html( get_the_excerpt( $post ) ); ?></p><?php endif; ?>
						<?php if ( trim( wp_strip_all_tags( $post->post_content ) ) ) : ?>
							<div class="svc-dialog__body"><?php echo wp_kses_post( wpautop( strip_shortcodes( $post->post_content ) ) ); ?></div>
						<?php endif; ?>
						<div class="svc-dialog__actions"><a class="btn btn--pri" href="<?php echo esc_url( abq_enquire_url( $post ) ); ?>">Enquire about this service <span aria-hidden="true">→</span></a></div>
					</div>
				</div>
			</dialog>
		<?php endif; ?>
	</article>
	<?php
}

/* ------------------------------------------------------------------
 * Fallback menu (shown until a menu is assigned in Appearance > Menus)
 * ---------------------------------------------------------------- */
function abq_fallback_menu() {
	$links = array(
		array( 'Home', home_url( '/' ), array() ),
		array( 'About Us', abq_page_url_by_slug( 'about-us' ) ?: '#', array() ),
	);
	$sub = array();
	foreach ( abq_divisions() as $division ) {
		$sub[] = array( $division->post_title, get_permalink( $division ) );
	}
	$root    = abq_services_root();
	$links[] = array( 'Services', $root ? get_permalink( $root ) : '#', $sub );
	$links[] = array( 'Career', abq_page_url_by_slug( 'career' ) ?: '#', array() );
	$links[] = array( 'Contact Us', abq_contact_url(), array() );

	echo '<ul class="menu">';
	foreach ( $links as $link ) {
		echo '<li class="menu-item' . ( $link[2] ? ' menu-item-has-children' : '' ) . '"><a href="' . esc_url( $link[1] ) . '">' . esc_html( $link[0] ) . '</a>';
		if ( $link[2] ) {
			echo '<ul class="sub-menu">';
			foreach ( $link[2] as $s ) {
				echo '<li class="menu-item"><a href="' . esc_url( $s[1] ) . '">' . esc_html( $s[0] ) . '</a></li>';
			}
			echo '</ul>';
		}
		echo '</li>';
	}
	echo '</ul>';
}

/* ------------------------------------------------------------------
 * Page options meta box (hero kicker + listing headline)
 * ---------------------------------------------------------------- */
function abq_add_meta_box() {
	add_meta_box( 'abq_page_options', 'Page header options', 'abq_meta_box_html', 'page', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'abq_add_meta_box' );

function abq_meta_box_html( $post ) {
	wp_nonce_field( 'abq_page_options', 'abq_page_options_nonce' );
	$kicker   = get_post_meta( $post->ID, '_abq_kicker', true );
	$headline = get_post_meta( $post->ID, '_abq_headline', true );
	?>
	<p><label for="abq_kicker"><strong>Hero kicker</strong></label><br>
		<input type="text" id="abq_kicker" name="abq_kicker" class="widefat" value="<?php echo esc_attr( $kicker ); ?>" placeholder="e.g. Division 01 / 03"></p>
	<p><label for="abq_headline"><strong>Intro headline</strong></label><br>
		<input type="text" id="abq_headline" name="abq_headline" class="widefat" value="<?php echo esc_attr( $headline ); ?>" placeholder="Shown above the page text on service listings"></p>
	<p class="description">Excerpt = hero sub-heading and card description. Featured image = hero and card image.</p>
	<?php
}

function abq_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['abq_page_options_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['abq_page_options_nonce'] ) ), 'abq_page_options' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	foreach ( array( 'abq_kicker' => '_abq_kicker', 'abq_headline' => '_abq_headline' ) as $field => $meta_key ) {
		$value = isset( $_POST[ $field ] ) ? sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) : '';
		if ( '' === $value ) {
			delete_post_meta( $post_id, $meta_key );
		} else {
			update_post_meta( $post_id, $meta_key, $value );
		}
	}
}
add_action( 'save_post_page', 'abq_save_meta_box' );
