<?php
/**
 * Template Name: Topics
 *
 * A list of topics with images and descriptions. Based on archive pages.
 *
 * @package techcamp
 */

get_header(); ?>

	<?php tha_content_before(); ?>

	<?php the_post(); ?>

	<main id="main" class="content main-archive main-archive--no-search full-width" role="main"><!-- post loop -->

		<header class="archive-header page-header">
			<h1 class="archive-title"><?php the_title(); ?></h1>
			<div class="archive-description">
				<?php the_content(); ?>
			</div>
		</header><!-- .page-header -->

		<?php tha_content_top(); ?>

		<div class="archive-body">
			<div class="archive-container container">
				<?php tha_content_while_before(); ?>
				<div class="archive-inner">
					<?php $topics = get_terms( array(
						'taxonomy' => 'topic',
						'hide_empty' => false,
					) );
					foreach( $topics as $topic ) { ?>

						<?php tha_entry_before(); ?>

						<article id="topic-<?php echo esc_attr( $topic->term_id ); ?>" <?php post_class( 'entry archive-entry archive-entry--with-thumb archive-entry--topic' ); ?>>

							<?php tha_entry_top(); ?>

							<div class="archive-entry--with-thumb__thumb archive-entry--topic__icon">
								<?php $icon_id = get_term_meta( $topic->term_id, 'icon_id', true );
								if ( $icon_id ) {
									echo wp_get_attachment_image( $icon_id, 'icon' );
								} else { ?>
									<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/world-thumbnail.png" alt="" />
								<?php } ?>
							</div>

							<div class="archive-entry--with-thumb__inner">

								<header class="archive-entry__header">
									<h2 class="archive-entry__title"><?php echo esc_html( $topic->name ); ?></h2>
								</header>

								<?php tha_entry_content_before(); ?>

								<div class="archive-entry__excerpt entry-excerpt archive-content container">
									<?php echo wp_kses_post( $topic->description ); ?>
								</div><!-- .archive-content -->

								<?php tha_entry_content_after(); ?>

							</div>

							<footer class="entry-footer">
								<span>Explore:</span>
								<a class="button" href="<?php echo esc_url( techcamp_get_term_link( $topic, 'topic', 'event' ) ); ?>">Related TechCamps</a>
								<a class="button" href="<?php echo esc_url( techcamp_get_term_link( $topic, 'topic', 'outcome' ) ); ?>">Related Outcomes</a>
								<a class="button" href="<?php echo esc_url( techcamp_get_term_link( $topic, 'topic', 'post' ) ); ?>">Related Blogs</a>
								<?php corona_entry_footer(); ?>
							</footer><!-- .entry-footer -->

							<?php tha_entry_bottom(); ?>

						</article><!-- #post-## -->

						<?php tha_entry_after(); ?>

					<?php } ?>
				</div>
				<?php tha_content_while_after(); ?>
			</div>
		</div>

		<?php tha_content_bottom(); ?>

	</main><!-- #main -->
	<?php tha_content_after(); ?>

<?php get_footer();
