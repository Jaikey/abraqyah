<?php
/**
 * Single post.
 */
get_header();
the_post();
get_template_part( 'template-parts/page-hero', null, array(
	'kicker' => get_the_date(),
	'title'  => get_the_title(),
) );
?>
<section class="section">
	<div class="container prose-wrap rv">
		<div class="prose"><?php the_content(); ?></div>
	</div>
</section>
<?php
get_footer();
