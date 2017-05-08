<?php
/**
 * Basic page template. Overrides Corona's parent template to make
 * all pages single-column by default.
 *
 * @package techcamp
 */

get_header(); ?>

	<?php tha_content_before(); ?>

	<main id="main" class="content main-home full-width" role="main">

		<?php tha_content_top(); ?>

		<?php tha_content_while_before(); ?>

		<div class="hero hero--home">

			<?php the_post_thumbnail( 'hero', array(
				'class' => 'hero__image'
			) ); ?>

			<div class="hero__container container">
				<div class="hero__text-box">
					<?php echo wp_kses_post( get_post_meta( get_the_ID(), 'hero_text', true ) ); ?>
				</div>
			</div>

		</div>

		<div class="home-topics white-icons">
			<div class="home-topics__container container">

				<p class="home-topics__intro">
					<?php echo esc_html( get_post_meta( get_the_ID(), 'topics_intro', true ) ); ?>
				</p>

				<div class="home-topics__row">
					<?php $topics = array();
					for ( $i = 1; $i <= 3; $i++ ) {
						$topics[] = get_post_meta( get_the_ID(), 'featured_topic_' . $i, true );
					}
					if ( array_filter( $topics ) ) {
						foreach( $topics as $topic ) {
							$topic = get_term_by( 'id', $topic, 'topic' ); ?>

							<a class="home-topics__topic" href="<?php echo esc_url( site_url() . '/topics#topic-' . $topic->term_id ); ?>">
								<div class="home-topics__icon">
									<?php
										$icon_name = get_term_meta( $topic->term_id, 'icon', true );
										get_template_part( 'template-parts/topics/' . $icon_name . '.svg' );
									?>
								</div>
								<h2 class="home-topics__name"><?php echo $topic->name; ?></h2>
							</a>

						<?php }
					} ?>
				</div>
				<a class="button button--on-dark home-topics__button" href="<?php echo esc_url( site_url() ); ?>/topics">View All Topics</a>

			</div>
		</div>


		<?php tha_content_while_after(); ?>

		<?php tha_content_bottom(); ?>

	</main><!-- #main -->

	<?php tha_content_after(); ?>

<?php get_footer();
