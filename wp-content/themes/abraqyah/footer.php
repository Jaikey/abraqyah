<?php
/**
 * Site footer.
 */
$co        = abq_company();
$divisions = abq_divisions();
$privacy   = abq_page_url_by_slug( 'privacy-policy' );
$terms     = abq_page_url_by_slug( 'terms-and-conditions' );
?>
</main>

<footer class="site-footer" id="contact">
	<div class="container footer-grid">
		<div class="footer-col footer-col--brand">
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span class="brand__mark">
					<?php
					if ( has_custom_logo() ) {
						echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full', false, array( 'alt' => '' ) );
					} else {
						echo abq_logo_svg(); // phpcs:ignore WordPress.Security.EscapeOutput
					}
					?>
				</span>
				<span class="brand__text"><b><?php echo esc_html( $co['brand_name'] ); ?></b><small><?php echo esc_html( $co['brand_sub'] ); ?></small></span>
			</a>
			<p class="footer-about"><?php echo esc_html( $co['footer_blurb'] ); ?></p>
			<a class="btn btn--pri" href="<?php echo esc_url( abq_contact_url() ); ?>">Send an Enquiry</a>
		</div>

		<div class="footer-col">
			<p class="eyebrow">Quick Links</p>
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'footer-links', 'depth' => 1 ) );
			} else {
				?>
				<ul class="footer-links">
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
					<?php foreach ( array( 'about-us' => 'About Us', 'services' => 'Services', 'career' => 'Career' ) as $slug => $label ) : ?>
						<?php $url = abq_page_url_by_slug( $slug ); ?>
						<?php if ( $url ) : ?><li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li><?php endif; ?>
					<?php endforeach; ?>
					<li><a href="<?php echo esc_url( abq_contact_url() ); ?>">Contact Us</a></li>
				</ul>
				<?php
			}
			?>
		</div>

		<div class="footer-col">
			<p class="eyebrow">Services</p>
			<ul class="footer-links">
				<?php foreach ( $divisions as $division ) : ?>
					<li><a href="<?php echo esc_url( get_permalink( $division ) ); ?>"><?php echo esc_html( $division->post_title ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="footer-col footer-contact">
			<p class="eyebrow">Contact</p>
			<p class="footer-person"><?php echo esc_html( $co['person'] ); ?></p>
			<p class="footer-role"><?php echo esc_html( $co['role'] ); ?></p>
			<?php if ( $co['phone1'] ) : ?><a href="tel:<?php echo esc_attr( abq_tel_number( $co['phone1'] ) ); ?>"><?php echo abq_icon( 'phone' ); // phpcs:ignore ?><?php echo esc_html( $co['phone1'] ); ?></a><?php endif; ?>
			<?php if ( $co['phone2'] ) : ?><a href="tel:<?php echo esc_attr( abq_tel_number( $co['phone2'] ) ); ?>"><?php echo abq_icon( 'phone' ); // phpcs:ignore ?><?php echo esc_html( $co['phone2'] ); ?></a><?php endif; ?>
			<?php if ( $co['email'] ) : ?><a href="mailto:<?php echo esc_attr( antispambot( $co['email'] ) ); ?>"><?php echo abq_icon( 'mail' ); // phpcs:ignore ?><?php echo esc_html( antispambot( $co['email'] ) ); ?></a><?php endif; ?>
			<span class="footer-line"><?php echo abq_icon( 'pin' ); // phpcs:ignore ?><?php echo esc_html( $co['region'] ); ?></span>
		</div>
	</div>

	<div class="footer-bar">
		<div class="container footer-bar__in">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( $co['legal'] ); ?></p>
			<?php if ( $privacy || $terms ) : ?>
				<p class="footer-legal">
					<?php if ( $privacy ) : ?><a href="<?php echo esc_url( $privacy ); ?>">Privacy Policy</a><?php endif; ?>
					<?php if ( $terms ) : ?><a href="<?php echo esc_url( $terms ); ?>">Terms &amp; Conditions</a><?php endif; ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
