<?php
/**
 * Basic page template. Overrides Corona's parent template to make
 * all pages single-column by default.
 *
 * @package techcamp
 */

get_header(); ?>

	<?php tha_content_before(); ?>

	<main id="main" class="content main-basic full-width" role="main">

		<section class="error-404 not-found">
			<header class="entry-header page-header">
				<div class="entry-header__crumb">Error 404</div>
				<h1 class="entry-header__title entry-title page-title">Page Not Found</h1>
				<div class="entry-header__meta">
					<?php echo wp_kses_post( wpautop( techcamp_get_setting( '404_content' ) ) ); ?>
				</div>
			</header><!-- .page-header -->
		</section><!-- .error-404 -->

		<?php tha_content_top(); ?>

		<?php tha_content_bottom(); ?>

	</main><!-- #main -->

	<?php tha_content_after(); ?>

<?php get_footer();
