</div><!-- .footer-middle -->

<div class="footer-bottom">

	<div class="container footer-bottom__container">

		<div class="footer-bottom__primary">
			<?php wp_nav_menu( array(
				'theme_location'  => 'footer-links',
				'container_class' => 'footer-links'
			) ); ?>
		</div>

		<div class="footer-bottom__secondary">
			<img class="footer-bottom__flag" src="<?php echo esc_attr( get_stylesheet_directory_uri() ); ?>/images/us-flag.png" alt="United States Flag" />
			<img class="footer-bottom__seal" src="<?php echo esc_attr( get_stylesheet_directory_uri() ); ?>/images/us-dos-seal.png" alt="United States Department of State Seal" />
		</div>

	</div><!-- .container -->

</div><!-- .footer-bottom -->
