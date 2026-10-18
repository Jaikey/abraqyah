<?php
/**
 * Template Name: Service Listing (division or category)
 *
 * Lists the child pages of the current page as cards. Page text becomes the
 * intro column; set the excerpt, featured image and header options in the editor.
 */
get_header();
the_post();

$id       = get_the_ID();
$parent   = $post->post_parent ? get_post( $post->post_parent ) : null;
$ancestors = get_post_ancestors( $id );
$depth    = count( $ancestors ); // Services root = 0, division = 1, category = 2.
$kids     = abq_children( $id );
$has_intro = '' !== trim( wp_strip_all_tags( $post->post_content ) );
$headline = get_post_meta( $id, '_abq_headline', true );
$kicker   = get_post_meta( $id, '_abq_kicker', true );

// Hero kicker: "Division 01 / 03" for divisions, parent name for deeper levels.
if ( ! $kicker ) {
	if ( 1 === $depth ) {
		$divs = abq_divisions();
		foreach ( $divs as $i => $d ) {
			if ( $d->ID === $id ) {
				$kicker = sprintf( 'Division %02d / %02d', $i + 1, count( $divs ) );
			}
		}
	} elseif ( $parent ) {
		$kicker = $parent->post_title;
	}
}

get_template_part( 'template-parts/page-hero', null, array(
	'kicker' => $kicker,
	'title'  => get_the_title(),
	'sub'    => has_excerpt() ? get_the_excerpt() : '',
	'quick'  => true,
	'image'  => has_post_thumbnail() ? get_the_post_thumbnail_url( $id, 'full' ) : '',
) );

// Related: sibling pages at the same level.
$related = array();
if ( $parent ) {
	foreach ( abq_children( $parent->ID ) as $sibling ) {
		if ( $sibling->ID !== $id ) {
			$related[] = $sibling;
		}
	}
}
$slot_map = array( 'pipeline', 'rotating', 'ngu' );
?>

<?php if ( $has_intro ) : ?>
<!-- Intro + stacked cards -->
<section class="section">
	<div class="container listing-split">
		<div class="listing-split__intro">
			<div class="sticky rv">
				<div class="label"><b>01</b><i></i>Our capability</div>
				<h2><?php echo esc_html( $headline ? $headline : get_the_title() ); ?></h2>
				<div class="prose prose--lead muted"><?php the_content(); ?></div>
				<div style="margin-top:32px"><a class="btn btn--pri" href="<?php echo esc_url( abq_enquire_url( $post ) ); ?>">Enquire about this service <span aria-hidden="true">→</span></a></div>
				<div class="areas"><span class="mono">Areas of operation</span><strong><?php echo esc_html( abq_company()['region'] ); ?></strong></div>
			</div>
		</div>
		<div class="listing-split__list cards cards--1" data-stagger>
			<?php foreach ( $kids as $i => $kid ) { abq_render_card( $kid, $i + 1, 0, true, 'hero' ); } ?>
		</div>
	</div>
</section>
<?php else : ?>
<!-- Card grid -->
<section class="section">
	<div class="container">
		<div class="label rv"><b>01</b><i></i>Services &amp; products</div>
		<div class="listhead rv">
			<h2><?php echo esc_html( count( $kids ) ); ?> <?php echo esc_html( 1 === count( $kids ) ? 'service' : 'services' ); ?> in this category</h2>
			<a class="btn btn--pri" href="<?php echo esc_url( abq_enquire_url( $post ) ); ?>">Enquire <span aria-hidden="true">→</span></a>
		</div>
		<div class="cards cards--auto" data-stagger>
			<?php foreach ( $kids as $i => $kid ) { abq_render_card( $kid, $i + 1, 0, false, 'hero' ); } ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( $related ) : ?>
<!-- Related -->
<section class="section section--tint section--tight">
	<div class="container">
		<div class="label rv"><b>02</b><i></i><?php echo esc_html( $depth <= 1 ? 'Related divisions' : 'More in ' . ( $parent ? $parent->post_title : 'this section' ) ); ?></div>
		<h2 class="rv" style="font-size:clamp(1.8rem,3.6vw,2.6rem)"><?php echo esc_html( $depth <= 1 ? 'Explore Our Other Services' : 'Other Sub-Categories' ); ?></h2>
		<div class="related-grid" data-stagger>
			<?php foreach ( $related as $i => $rel ) : ?>
				<a class="related rv" href="<?php echo esc_url( get_permalink( $rel ) ); ?>">
					<span class="related__img"><img src="<?php echo esc_url( abq_thumb( $rel, 'abq-thumb', isset( $slot_map[ $i ] ) ? $slot_map[ $i ] : 'hero' ) ); ?>" alt="" loading="lazy" width="160" height="160"></span>
					<span class="related__txt">
						<strong><?php echo esc_html( $rel->post_title ); ?></strong>
						<?php $d = abq_card_desc( $rel, 14 ); ?>
						<?php if ( $d && $depth > 1 ) : ?><span class="muted"><?php echo esc_html( $d ); ?></span><?php endif; ?>
					</span>
					<?php echo abq_icon( 'arrow' ); // phpcs:ignore ?>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
get_template_part( 'template-parts/cta' );
get_footer();
