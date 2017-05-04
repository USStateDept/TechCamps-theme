<?php
/**
 * The template for displaying archive pages.
 *
 * @package techcamp
 */

get_header(); ?>

	<?php tha_content_before(); ?>

	<main id="main" class="content main-archive full-width" role="main">

		<?php tha_content_top(); ?>

		<div class="archive-body">
			<div class="archive-container container <?php if ( is_post_type_archive( 'resource' ) || techcamp_is_blog_archive() ) { ?>archive-container--two-col<?php } ?>">
				<?php tha_content_while_before(); ?>
				<div class="archive-inner">
					<?php corona_loop( 'template-parts/archive', get_post_type() ); ?>
				</div>
				<?php tha_content_while_after(); ?>
			</div>
		</div>

		<?php tha_content_bottom(); ?>

	</main><!-- #main -->
	<?php tha_content_after(); ?>

<?php get_footer();
