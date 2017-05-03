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

		<header class="archive-header page-header archive-header--topics">
			<h1 class="archive-title archive-title--topics"><?php the_title(); ?></h1>
			<div class="archive-description archive-description--topics">
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

						<article id="topic-<?php echo esc_attr( $topic->term_id ); ?>" <?php post_class( 'entry archive-entry archive-entry--topic' ); ?>>

							<?php tha_entry_top(); ?>

							<div class="archive-entry__text">

								<header class="archive-entry__header">
									<h2 class="archive-entry__title archive-entry__title--topic"><?php echo esc_html( $topic->name ); ?></h2>
								</header>

								<?php tha_entry_content_before(); ?>

								<div class="archive-entry__excerpt archive-entry__excerpt--topic entry-excerpt archive-content container">
									<?php echo wp_kses_post( $topic->description ); ?>
								</div><!-- .archive-content -->

								<?php tha_entry_content_after(); ?>

							</div>

							<footer class="entry-footer entry-footer--topic">
								<?php
									$icon_name = get_term_meta( $topic->term_id, 'icon', true );
									get_template_part( 'template-parts/topics/' . $icon_name . '.svg' );
								?>
								<ul>
									<li><a class="archive-entry__sub-link" href="<?php echo esc_url( techcamp_get_term_link( $topic, 'topic', 'event' ) ); ?>">Related TechCamps</a></li>
									<li><a class="archive-entry__sub-link" href="<?php echo esc_url( techcamp_get_term_link( $topic, 'topic', 'outcome' ) ); ?>">Related Outcomes</a></li>
									<li><a class="archive-entry__sub-link" href="<?php echo esc_url( techcamp_get_term_link( $topic, 'topic', 'post' ) ); ?>">Related Blogs</a></li>
								</ul>
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
