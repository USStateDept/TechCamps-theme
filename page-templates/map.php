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

		<div id="map" class="map"></div>
		<div class="legend">
			<dl class="legend__definitions container">
				<dt class="legend__techcamp">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/marker-techcamp.svg" alt="Blue TechCamp Marker" />
				</dt>
				<dd>TechCamps</dd>
				<dt class="legend__outcome">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/marker-outcome.svg" alt="Green Outcome Marker" />
				</dt>
				<dd>Featured Outcomes</dd>
				<dt class="legend__region">
					<span class="element-invisible">Dark Blue</span>
				</dt>
				<dd>Host Regions</dd>
				<dt class="legend__participator">
					<span class="element-invisible">Light Blue</span>
				</dt>
				<dd>Participating Regions</dd>
			</dl>
		</div>

		<?php the_post(); ?>
		<div class="entry-content">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</div>

		<?php tha_content_bottom(); ?>

	</main><!-- #main -->

	<?php tha_content_after(); ?>

<?php get_footer();
