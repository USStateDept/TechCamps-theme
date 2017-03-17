<div class="footer-top container">

	<div class="footer-top__primary">
		<img class="footer-top__logo" src="<?php echo esc_attr( get_stylesheet_directory_uri() ); ?>/images/logo-white.png" alt="TechCamp Logo" />
		<?php wp_nav_menu( array(
			'theme_location'  => 'footer-navigation',
			'container_class' => 'footer-top__menu',
		) ); ?>
	</div>

	<div class="footer-top__secondary">
		<?php wp_nav_menu( array(
			'theme_location'  => 'footer-social',
			'container_class' => 'footer-top__social social-menu',
			'link_before'     => '<span class="element-invisible">',
			'link_after'      => '</span>',
		) ); ?>
	</div>

</div><!-- .footer-top -->

<div class="footer-middle container">
