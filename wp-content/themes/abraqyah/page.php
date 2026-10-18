<?php
/**
 * Default page / individual service page.
 */
get_header();
the_post();

$id         = get_the_ID();
$parent     = $post->post_parent ? get_post( $post->post_parent ) : null;
$in_service = abq_in_services( $id );
$kicker     = get_post_meta( $id, '_abq_kicker', true );
if ( ! $kicker && $parent ) {
	$kicker = $parent->post_title;
}

get_template_part( 'template-parts/page-hero', null, array(
	'kicker' => $kicker,
	'title'  => get_the_title(),
	'sub'    => has_excerpt() ? get_the_excerpt() : '',
	'quick'  => $in_service,
	'image'  => has_post_thumbnail() ? get_the_post_thumbnail_url( $id, 'full' ) : '',
) );

$siblings = array();
if ( $in_service && $parent ) {
	foreach ( abq_children( $parent->ID ) as $sibling ) {
		if ( $sibling->ID !== $id ) {
			$siblings[] = $sibling;
		}
	}
}
?>
<section class="section">
	<div class="container <?php echo $in_service ? 'g12' : 'prose-wrap'; ?>">
		<div class="<?php echo $in_service ? 'c7 rv' : 'rv'; ?>">
			<div class="prose"><?php the_content(); ?></div>
			<?php if ( $in_service ) : ?>
				<div class="btn-row" style="margin-top:40px">
					<a class="btn btn--pri" href="<?php echo esc_url( abq_enquire_url( $post ) ); ?>">Enquire about this service <span aria-hidden="true">→</span></a>
					<?php if ( $parent ) : ?><a class="btn btn--line" href="<?php echo esc_url( get_permalink( $parent ) ); ?>">Back to <?php echo esc_html( $parent->post_title ); ?></a><?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php if ( $in_service && $siblings ) : ?>
			<aside class="c5 rv">
				<div class="label"><b>→</b><i></i>More in <?php echo esc_html( $parent->post_title ); ?></div>
				<ul class="side-links">
					<?php foreach ( $siblings as $sibling ) : ?>
						<li><a href="<?php echo esc_url( get_permalink( $sibling ) ); ?>"><?php echo esc_html( $sibling->post_title ); ?><?php echo abq_icon( 'arrow' ); // phpcs:ignore ?></a></li>
					<?php endforeach; ?>
				</ul>
			</aside>
		<?php endif; ?>
	</div>
</section>
<?php
get_template_part( 'template-parts/cta' );
get_footer();
