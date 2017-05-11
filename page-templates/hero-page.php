<?php
/**
 * Template Name: Hero Page
 *
 * An otherwise basic page with the hero section at the top.
 *
 * @package techcamp
 */

get_header(); ?>

	<?php tha_content_before(); ?>

	<main id="main" class="content main-basic full-width" role="main">

		<?php tha_content_top(); ?>
		<?php tha_content_while_before(); ?>
		<?php tha_entry_before(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php tha_entry_top(); ?>

			<div class="hero hero--landing">

				<?php the_post_thumbnail( 'hero', array(
					'class' => 'hero__image'
				) ); ?>

				<div class="hero__container container">
					<div class="hero__text-box">
						<?php echo wp_kses_post( get_post_meta( get_the_ID(), 'hero_text', true ) ); ?>
					</div>
				</div>

			</div>

			<?php tha_entry_content_before(); ?>
			<div class="content-container">
				<div class="entry-content">
					<?php
						the_content();
						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'corona' ),
							'after'  => '</div>',
						) );
					?>
				</div><!-- .entry-content -->
			</div>
			<?php tha_entry_content_after(); ?>

			<?php tha_entry_bottom(); ?>

		</article><!-- #post-## -->

		<?php tha_entry_after(); ?>

		<?php tha_content_while_after(); ?>

		<?php tha_content_bottom(); ?>

	</main><!-- #main -->

	<?php tha_content_after(); ?>

<?php get_footer();
