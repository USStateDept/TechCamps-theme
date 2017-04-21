<?php
/**
 * Template part for displaying the event detail content.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @todo Text strings - "Events", "Apply Now", content headings
 * @todo Responsive images for speed. Specifically the big hero image.
 * @todo Meta links: Map page option?
 * @todo Related Articles icon - external link? Should it be there?
 *
 * @package corona
 */
?>

<?php tha_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

	<?php tha_entry_top(); ?>

	<?php $color_scheme = get_post_meta( get_the_ID(), 'color_scheme', true ); ?>

	<header class="entry-header detail-header <?php echo esc_attr( $color_scheme ); ?> <?php echo esc_attr( techcamp_thumbnail_class() ); ?>"
		style="background-image:url('<?php echo esc_url( techcamp_thumbnail_url() ); ?>">

		<div class="container detail-header__container">
			<div class="detail-header__primary">

				<div class="breadcrumbs detail-header__breadcrumbs">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>">Events</a>
				</div>

				<?php the_title( '<h1 class="entry-title detail-header__title">', '</h1>' ); ?>

				<?php if ( $subhead = get_post_meta( get_the_ID(), 'subhead', true ) ) { ?>
					<h2 class="detail-header__subhead"><?php echo esc_html( $subhead ); ?></h2>
				<?php } ?>

			</div>
		</div>

	</header><!-- .entry-header -->

	<div class="detail-meta">
		<div class="detail-meta__container container">

			<div class="detail-meta__data">
				<?php echo get_the_term_list( get_the_ID(), 'topic', '<div class="detail-meta__topics">', '', '</div>' ); ?>
				<div class="detail-meta__location">
					<span><?php echo esc_html( techcamp_location() ); ?></span> <a href="/map">View Map</a>
				</div>
				<div class="detail-meta__date">
					<?php echo esc_html( techcamp_event_date() ); ?>
				</div>
			</div>

			<?php if ( $website_url = get_post_meta( get_the_ID(), 'website_url', true ) ) { ?>
				<div class="detail-meta__cta">
					<a class="button" href="<?php echo esc_url( $website_url ); ?>">
						<?php if ( techcamp_event_is_upcoming() ) { ?>
							Apply Now
						<?php } else { ?>
							Visit Site
						<?php } ?>
					</a>
				</div>
			<?php } ?>

		</div>
	</div>

	<?php tha_entry_content_before(); ?>

	<div class="detail-content">
		<div class="detail-content__container container">
			<div class="detail-content__primary entry-content">

				<h2>Participating Locations</h2>
				<p><?php echo esc_html( strip_tags( get_the_term_list( get_the_ID(), 'participator', '', '; ', '' ) ) ); ?></p>

				<h2>Description / Overview of Event</h2>
				<?php
					the_content( sprintf(
						/* translators: %s: Name of current post. */
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'corona' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'corona' ),
						'after'  => '</div>',
					) );
				?>

			</div>

			<aside class="detail-content__secondary">
				<div class="box">
					<p>Keep up to date with TechCamp. Sign up for email updates.</p>
					<a class="button secondary" href="#">Stay Connected</a>
				</div>
			</aside>

		</div><!-- .detail-content__container -->
	</div><!-- .detail-content -->

	<?php $trainers = get_posts( array(
		'posts_per_page'  => 200,
		'post_type'       => 'bio',
		'connected_type'  => 'resource_connections',
		'connected_items' => get_post(),
		'no_found_rows'   => true
	) );
	if ( $trainers ) { ?>
		<div class="bios">
			<div class="bios__container container">
				<h2 class="bios__title">Trainer Bios</h2>
				<div class="bios__controls">
					<?php $trainer_count = count( $trainers ); ?>
					<span class="bios__count"><?php echo (int) $trainers; ?> <?php echo _n( 'Bio', 'Bios', $trainer_count ); ?></span>
					<a class="bios__more" href="#" data-alt="View Less">View All</a>
				</div>
				<ul class="bios__list">
					<?php foreach( $trainers as $post ) {
						setup_postdata( $post ); ?>
						<li class="bios__item">
							<div class="bios__image">
								<?php if ( has_post_thumbnail() ) { ?>
									<?php the_post_thumbnail( 'portrait' ); ?>
								<?php } else { ?>
									<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bio.png" alt="Silhouette" />
								<?php } ?>
							</div>
							<div class="bios__text">
								<h3 class="bios__name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<span class="bios__position"><?php echo esc_html( get_post_meta( get_the_ID(), 'position', true ) ); ?></span>
								<span class="bios__organization"><?php echo esc_html( get_post_meta( get_the_ID(), 'organization', true ) ); ?></span>
							</div>
						</li>
					<?php }
					wp_reset_postdata(); ?>
				</ul>
				<div>
					<a class="button" target="_blank" href="<?php the_permalink(); ?>?print=1&amp;context=bios">Print Bios</a>
				</div>
			</div>
		</div><!-- .bios -->
	<?php } ?>

	<div class="detail-content">
		<div class="detail-content__container container">

			<div class="detail-content__primary entry-content">

				<div class="agenda">
					<div class="toggler-content hide">
						<h2>Agenda</h2>
						<?php echo techcamp_process_wysiwyg( 'agenda', get_the_ID() ); ?>
					</div>
					<a href="#" class="toggler" data-alt="Hide Agenda">Expand Agenda</a>
					<div class="agenda__bottom">
						<a class="button" target="_blank" href="<?php the_permalink(); ?>?print=1&amp;context=agenda">Print Agenda</a>
					</div>
				</div>

				<?php $resources = get_posts( array(
					'posts_per_page'  => 50,
					'post_type'       => 'resource',
					'connected_type'  => 'resource_connections',
					'connected_items' => get_post(),
					'no_found_rows'   => true
				) );
				if ( $resources ) { ?>
					<div class="event-resources">
						<h2>Resources</h2>
						<ul class="flat-list">
							<?php foreach( $resources as $post ) {
								setup_postdata( $post ); ?>
								<li class="flat-list__item">
									<?php
										$url = get_post_meta( get_the_ID(), 'resource_url', true );
										if ( ! $url ) {
											$url = get_permalink();
										}
										$ext = pathinfo( $url, PATHINFO_EXTENSION );
										if ( $ext === 'pptx' ) $ext = 'ppt';
										if ( $ext === 'docx' ) $ext = 'doc';
									?>
									<a href="<?php echo esc_url( $url ); ?>" class="flat-list__link"><?php the_title(); ?></a>
									<?php if ( $ext ) { ?><span class="flat-list__icon <?php echo esc_attr( $ext ); ?>"><span class="element-invisible"><?php echo esc_html( $ext ); ?></span></span><?php } ?>
								</li>
							<?php }
							wp_reset_postdata(); ?>
						</ul>
					</div>
				<?php } ?>

			</div>

			<aside class="detail-content__secondary">

				<!-- Quote -->
				<?php if ( $quote = get_post_meta( get_the_ID(), 'quote', true ) ) {
					$quote = trim( $quote, '"' ); // ensure no duplicate quotes ?>
					<div class="box box--secondary">
						<blockquote>
							<?php echo esc_html( $quote ); ?>
							<cite><?php echo esc_html( get_post_meta( get_the_ID(), 'attribution', true ) ); ?></cite>
						</blockquote>
						<?php
							// get 115-char version for twitter
							if ( strlen( $quote ) > 112 ) {
								$quote = substr( $quote, 0, 112 );
								// jump back to the last space so we don't break words
								$quote = explode( ' ', $quote );
								$discard = array_pop( $quote );
								$quote = implode( ' ', $quote );
								// discard punctuation that will look bad with ellipses, and add ellipsis
								$quote = rtrim( $quote, '.:,;?') . '...';
							}
						?>
						<a class="button" href="https://twitter.com/intent/tweet?text=<?php echo urlencode( '"' . $quote . '"' ); ?>&amp;url=<?php echo urlencode( esc_url( get_permalink() ) ); ?>">Tweet This</a>
					</div>
				<?php } ?>

				<!-- Slack -->
				<div class="box box--slack">
					<img class="slack-logo" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/slack-logo.png" alt="Slack logo" />
					<p>Did you attend this TechCamp? Attendees to this event can log in and continue the conversation.</p>
					<a class="button secondary" href="https://slack.com/signin">Log In</a>
				</div>

				<!-- Related Events? -->

				<?php $rel_outcomes = get_posts( array(
					'posts_per_page'  => 3,
					'post_type'       => 'outcome',
					'connected_type'  => 'events_and_outcomes',
					'connected_items' => get_post(),
					'no_found_rows'   => true
				) );
				if ( $rel_outcomes ) { ?>
					<div class="box box--highlight">
						<h2 class="box__title">Outcomes</h2>
						<ul class="box-list">
							<?php foreach( $rel_outcomes as $post ) {
								setup_postdata( $post ); ?>
								<li class="box-list__item">
									<a class="box-list__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
									<span class="box-list__meta"><?php echo esc_html( techcamp_location() ); ?></span>
								</li>
							<?php }
							wp_reset_postdata(); ?>
						</ul>
					</div>
				<?php } ?>

				<?php $rel_articles = get_posts( array(
					'posts_per_page'  => 3,
					'post_type'       => 'post',
					'connected_type'  => 'blog_connections',
					'connected_items' => get_post(),
					'no_found_rows'   => true
				) );
				if ( $rel_articles ) { ?>
					<div class="box box--secondary">
						<h2 class="box__title">Related Articles</h2>
						<ul class="box-list">
							<?php foreach( $rel_articles as $post ) {
								setup_postdata( $post ); ?>
								<li class="box-list__item">
									<a class="box-list__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
								</li>
							<?php }
							wp_reset_postdata(); ?>
						</ul>
					</div>
				<?php } ?>

			</aside>

		</div><!-- .detail-content__container -->
	</div><!-- .detail-content -->

	<?php
	$photos = get_post_meta( get_the_ID(), 'images', true );
	$videos = get_post_meta( get_the_ID(), 'videos', true );
	if ( $photos || $videos ) { ?>

		<div class="detail-bottom detail-media">
			<div class="container">
				<?php if ( $photos ) { ?>
					<h2>Photos from Event</h2>
					<div class="flickr-gallery">
						<div class="flickr-gallery__container">
							<div class="flickr-gallery__item">
								<?php echo $photos; ?>
							</div>
							<div class="ratio-hack"></div>
						</div>
					</div>
				<?php } ?>
				<?php if ( $videos ) { ?>
				<div class="videos">
					<h2>Videos from Event</h2>
					<?php global $wp_embed;
					foreach( $videos as $video ) {
						$video = esc_url_raw( $video );
						$video = $wp_embed->autoembed( $video ); ?>
						<div class="video detail-media__item">
							<?php echo $wp_embed->run_shortcode( $video ); ?>
						</div>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
		</div>

	<?php } ?>

	<?php tha_entry_content_after(); ?>

	<footer class="entry-footer">
		<?php corona_entry_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php tha_entry_bottom(); ?>

</article><!-- #post-## -->

<?php tha_entry_after(); ?>