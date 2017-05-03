<?php
/**
* Template partial that displays the site header
*
* @package techcamp
*/
?>

<header id="masthead" class="site-header" role="banner">
<?php tha_header_top(); ?>

	<div class="title-area">

		<?php if ( get_header_image() ) : ?>
			<h1 class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php get_template_part( 'template-parts/logo.svg' ); ?>
				</a>
			</h1>
		<?php endif; ?>

		<?php $description = get_bloginfo( 'description', 'display' );
		if ( $description || is_customize_preview() ) : ?>
			<p class="site-description"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>

	</div><!-- .title-area -->

<?php tha_header_bottom(); ?>
</header><!-- #masthead -->
