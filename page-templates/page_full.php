<?php
/**
 * Template Name: Full Width (no sidebar)
 *
 *
 * @see /docs/templates
 *
 * @package WordPress
 * @subpackage corona
 * @since Corona 1.0
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/page-templates/
 */

get_header(); ?>

	<?php tha_content_before(); ?>

	<main id="main" class="content full-width" role="main">

		<?php tha_content_top(); ?>

		<?php if ( is_active_sidebar( 'before-entry' ) ) : ?>
			<div class="before-entry">
				<?php dynamic_sidebar( 'before-entry' ); ?>
			</div>
		<?php endif; ?>

		<?php
			tha_content_while_before();
			corona_loop( 'template-parts/content', 'page', $comments = true );
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
