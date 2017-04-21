<?php
/**
 * Basic template for posts of any post type except pages.
 *
 * Overrides Corona's parent template to allow for full-width post headers that
 * aren't restricted by .content-sidebar-wrap.
 *
 * Also change the template parts to look for get_post_type() instead of
 * get_post_format(), so we can create template parts like content-event.php.
 *
 * @package techcamp
 */

get_header(); ?>

	<?php tha_content_before(); ?>

	<?php $classes = 'main-' . get_post_type();
	if ( in_array( get_post_type(), array( 'post', 'bio', 'resource' ) ) ) {
		$classes .= ' main-basic';
	} ?>

	<main id="main" class="content main-singular full-width <?php echo esc_attr( $classes ); ?>" role="main">

		<?php tha_content_top(); ?>

		<?php if ( is_active_sidebar( 'before-entry' ) ) : ?>
			<div class="before-entry">
				<?php dynamic_sidebar( 'before-entry' ); ?>
			</div>
		<?php endif; ?>

		<?php
			tha_content_while_before();
			corona_loop( 'template-parts/content', get_post_type(), $comments = true );
			tha_content_while_after();
		?>

		<?php if ( is_active_sidebar( 'after-entry' ) ) : ?>
			<div class="after-entry">
				<?php dynamic_sidebar( 'after-entry' ); ?>
			</div>
		<?php endif; ?>

		<?php tha_content_bottom(); ?>

	</main><!-- #main -->

	<?php tha_content_after(); ?>

<?php get_footer();
