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

				<?php the_post_thumbnail( 'hero', array(
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
							<a class="featured-items__image-link" href="<?php the_permalink(); ?>">
								<?php if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'featured', array(
										'class' => 'featured-items__image'
									) );
								} else { ?>
									<img class="featured-items__image default" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/default-featured.jpg" alt="" />
								<?php } ?>
							</a>
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

			<?php $args = array(
				'post_type'        => $post_type,
				'posts_per_page'   => 3,
				'suppress_filters' => false,
				'post__not_in'     => array( $featured_post_id ),
			);
			if ( $post_type === 'event' ) {
				$args['meta_key'] = 'start_date';
				$args['orderby']  = 'meta_value';
			}
			$recent_posts = get_posts( $args );
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
							<a class="secondary-cta__button button button--on-dark button--secondary" href="<?php echo esc_url( get_post_type_archive_link( $secondary_post_type ) ); ?>">
								View All <?php echo esc_html( $secondary_plural ); ?>
							</a>
						</div>
					</div>
				</div>

			<?php } ?>

			<?php if ( techcamp_get_setting( 'enable_email_signup' ) ) { ?>
				<div class="landing-signup">
					<div class="landing-signup__container container">
						<h2 class="landing-signup__heading">
							<?php echo esc_html( techcamp_get_setting( 'email_heading' ) ); ?>
						</h2>
						<?php echo do_shortcode( esc_html( techcamp_get_setting( 'email_signup_shortcode' ) ) ); ?>
					</div>
				</div>
			<?php } ?>

			<div class="explore-sections explore-sections--regions">
				<div class="explore-sections__container container">
					<h2 class="explore-sections__header"><?php echo esc_html( get_post_meta( get_the_ID(), 'region_label', true ) ); ?></h2>

					<div class="explore-sections__list-container">
						<ul class="explore-sections__list">

							<?php

							$terms = array();
							if ( $post_type === 'outcome' ) {
								// there doesn't seem to be a more efficient way to do this
								$outcomes = get_posts( array(
									'posts_per_page' => 100,
									'post_type'      => 'outcome',
									'fields'         => 'ids',
								) );
								foreach( $outcomes as $outcome ) {
									$ots = wp_get_object_terms( $outcome, 'country' );
									foreach ( $ots as $term ) {
										if ( !in_array( $term->term_id, $terms ) ) {
											$terms[] = $term->term_id;
										}
									}
								}
								// get region parent
								foreach( $terms as $term_id ) {
									$parents = get_ancestors( $term_id, 'country', 'taxonomy' );
									if ( $parents ) {
										$terms = array_merge( $terms, $parents );
									}
								}
							}

							// hook to adjust classes
							add_filter( 'category_css_class', 'techcamp_category_css_class' );

							// hook to adjust link destination
							add_filter( 'term_link', 'techcamp_override_term_link_for_' . $post_type, 10, 3 );

							wp_list_categories( array(
								'depth'      => 2,
								'hide_empty' => true,
								'taxonomy'   => 'country',
								'title_li'   => '',
								'include'    => $terms ? $terms : null,
							) );

							// clean up
							remove_filter( 'category_css_class', 'techcamp_category_css_class' );
							remove_filter( 'term_link', 'techcamp_override_term_link_for_' . $post_type, 10, 3 );
							?>

						</ul>
						<a href="<?php echo esc_url( get_permalink( techcamp_get_map_id() ) ); ?>" class="button button--on-dark">View Map</a>
					</div>

				</div>
			</div>

		<?php endwhile; endif; ?>
		<?php tha_content_while_after(); ?>
		<?php tha_content_bottom(); ?>

	</main><!-- #main -->

	<?php tha_content_after(); ?>

<?php get_footer();
