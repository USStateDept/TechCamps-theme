<?php
/**
 * Template Name: Map
 *
 * This is the template that displays the map, which is built
 * with the Google Maps JavaScript API.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package corona
 */

get_header(); ?>

	<?php tha_content_before(); ?>

	<main id="main" class="content main-basic full-width main-map" role="main">

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

		<!-- Begin Map -->
		<div id="map" class="map"></div>
		<!-- End Map (that's it.) -->

		<?php if ( is_active_sidebar( 'after-entry' ) ) : ?>
			<div class="after-entry">
				<?php dynamic_sidebar( 'after-entry' ); ?>
			</div>
		<?php endif; ?>

		<?php tha_content_bottom(); ?>

	</main><!-- #main -->

	<?php tha_content_after(); ?>

<?php get_footer();
