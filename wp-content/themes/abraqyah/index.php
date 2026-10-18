<?php
/**
 * Fallback template (blog index, archives, search).
 */
get_header();

get_template_part( 'template-parts/page-hero', null, array(
	'title' => is_search() ? 'Search results' : ( is_home() ? 'News & Updates' : wp_strip_all_tags( get_the_archive_title() ) ),
) );
?>
<section class="section">
	<div class="container prose-wrap">
		<?php if ( have_posts() ) : ?>
			<div class="post-list" data-stagger>
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'post-item rv' ); ?>>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="mono muted"><?php echo esc_html( get_the_date() ); ?></p>
						<div class="prose"><?php the_excerpt(); ?></div>
					</article>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p class="lead muted">Nothing found here yet.</p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
