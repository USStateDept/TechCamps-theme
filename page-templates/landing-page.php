<?php
/**
 * Template Name: Landing Page
 *
 * Custom page template for post type landing pages. Directs users to explore
 * posts or go to individual posts in this post type.
 *
 * The markup in here is as generic as possible, to be used for Events, Outcomes,
 * and other contexts as they arise.
 *
 * @package techcamp
 */

get_header(); ?>

	<?php tha_content_before(); ?>

	<main id="main" class="content main-landing full-width" role="main">

		<?php tha_content_top(); ?>
		<?php tha_content_while_before(); ?>
		<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>

			<?php
				$post_type = sanitize_key( get_post_meta( get_the_ID(), 'landing_type', true ) );
				$post_type_label = techcamp_get_post_type_label( $post_type );
			?>

			<div class="hero hero--landing">

				<?php the_post_thumbnail( 'inner-hero', array(
					'class' => 'hero__image'
				) ); ?>

				<div class="hero__container container">
					<div class="hero__text-box">
						<?php echo wp_kses_post( get_post_meta( get_the_ID(), 'hero_text', true ) ); ?>
					</div>
				</div>

			</div>

			<div class="explore-search">
				<div class="explore-search__container container">
					<form class="explore-search__form" action="<?php echo esc_url( get_post_type_archive_link( $post_type ) ); ?>">
						<label for="explore-keyword" class="explore-search__label"><?php echo esc_html( get_post_meta( get_the_ID(), 'search_label', true ) ); ?></label>
						<div class="explore-search__fields">
							<input id="explore-keyword" name="keyword" type="text" class="explore-search__input" placeholder="Search <?php echo esc_attr( $post_type_label ); ?>" />
							<input type="submit" class="explore-search__submit" value="Go" />
						</div>
					</form>
					<div class="explore-search__map">
						<a class="explore-search__map-link" href="<?php echo site_url( 'map' ); ?>">View Map</a>
					</div>
				</div>
			</div>

			<?php $featured_post_id = techcamp_get_featured( $post_type );
			if ( $featured_post_id ) {
				$post = get_post( $featured_post_id );
				setup_postdata( $post ); ?>
				<div class="featured-items">
					<div class="featured-items__container container">
						<div class="featured-items__item">
							<?php the_post_thumbnail( 'featured', array(
								'class' => 'featured-items__image'
							) ); ?>
							<div class="featured-items__text">
								<div class="featured-items__box">
									<h2 class="featured-items__label">
										Featured <?php echo esc_html( techcamp_get_post_type_label( get_post_type(), 'singular' ) ); ?>
									</h2>
									<h3 class="featured-items__title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
								</div>
								<div class="featured-items__sub">
									<span class="featured-items__location"><?php echo esc_html( techcamp_location() ); ?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php } ?>

			<div class="explore-links explore-links--topics">
				<div class="explore-links__container container">
					<h2 class="explore-links__header"><?php echo esc_html( get_post_meta( get_the_ID(), 'topic_label', true ) ); ?></h2>
					<?php $topics = get_terms( array(
						'taxonomy'   => 'topic',
						'hide_empty' => false, // consider
					) );
					if ( $topics ) { ?>
						<div class="explore-links__list-container">
							<ul class="explore-links__list">
								<?php // probably change these links to point to search results on archive page
								foreach( $topics as $topic ) { ?>
									<li class="explore-links__item">
										<a href="<?php echo esc_url( techcamp_get_topic_link( $topic, $post_type ) ); ?>">
											<?php echo esc_html( $topic->name ); ?>
										</a>
									</li>
								<?php } ?>
							</ul>
						</div>
					<?php } ?>
				</div>
			</div>

			<?php $recent_posts = get_posts( array(
				'post_type'        => $post_type,
				'posts_per_page'   => 3,
				'suppress_filters' => false,
				'post__not_in'     => array( $featured_post_id ),
			) );
			techcamp_surfaced_posts(
				$post_type,
				'Most Recent ' . $post_type_label,
				$recent_posts,
				'View All ' . $post_type_label,
				get_post_type_archive_link( $post_type )
			);

			$secondary_post_type = sanitize_key( get_post_meta( get_the_ID(), 'secondary_landing_type', true ) );
			if ( $secondary_post_type ) {
				$secondary_plural   = techcamp_get_post_type_label( $secondary_post_type );
				$secondary_singular = techcamp_get_post_type_label( $secondary_post_type, 'singular' ); ?>

				<div class="secondary-cta">
					<div class="secondary-cta__container container">
						<div class="secondary-cta__featured">
							<?php $featured_post = techcamp_get_featured( $secondary_post_type );
							if ( $featured_post ) {
								$post = get_post( $featured_post );
								setup_postdata( $post ); ?>
								<h2 class="secondary-cta__label">Featured <?php echo esc_html( $secondary_singular ); ?></h2>
								<h3 class="secondary-cta__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="secondary-cta__meta"><?php echo esc_html( techcamp_event_date() ); ?></div>
								<?php wp_reset_postdata();
							} ?>
						</div>
						<div class="secondary-cta__general">
							<h2 class="secondary-cta__title">Learn About our <?php echo esc_html( $secondary_plural ); ?></h2>
							<a class="secondary-cta__button button" href="<?php echo esc_url( get_post_type_archive_link( $secondary_post_type ) ); ?>">
								View All <?php echo esc_html( $secondary_plural ); ?>
							</a>
						</div>
					</div>
				</div>

			<?php } ?>

			<div class="landing-signup">
				<div class="landing-signup__container container">
					<h2 class="landing-signup__heading">
						<?php echo esc_html( get_post_meta( get_the_ID(), 'email_heading', true ) ); ?>
					</h2>
					<?php get_template_part( 'template-parts/email-signup' ); ?>
				</div>
			</div>

			<div class="explore-sections explore-sections--regions">
				<div class="explore-sections__container container">
					<h2 class="explore-sections__header"><?php echo esc_html( get_post_meta( get_the_ID(), 'region_label', true ) ); ?></h2>

					<div class="explore-sections__list-container">
						<ul class="explore-sections__list">

							<?php
							// hook to adjust classes
							add_filter( 'category_css_class', 'techcamp_category_css_class' );

							// hook to adjust link destination
							add_filter( 'term_link', 'techcamp_override_term_link_for_' . $post_type, 10, 3 );

							wp_list_categories( array(
								'depth'     => 2,
								'hide_emty' => true,
								'taxonomy'  => 'country',
								'title_li'  => '',
							) );

							// clean up
							remove_filter( 'category_css_class', 'techcamp_category_css_class' );
							remove_filter( 'term_link', 'techcamp_override_term_link_for_' . $post_type, 10, 3 );
							?>

						</ul>
						<a href="/map" class="button">View Map of All Events and Outcomes</a>
					</div>

				</div>
			</div>

		<?php endwhile; endif; ?>
		<?php tha_content_while_after(); ?>
		<?php tha_content_bottom(); ?>

	</main><!-- #main -->

	<?php tha_content_after(); ?>

<?php get_footer();
