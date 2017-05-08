<?php
/**
 * Template part for displaying the outcome detail content.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package techcamp
 */
?>

<?php tha_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

	<?php tha_entry_top(); ?>

	<?php $color_scheme = get_post_meta( get_the_ID(), 'color_scheme', true ); ?>

	<header class="entry-header detail-header has-color <?php echo esc_attr( $color_scheme ); ?> <?php echo esc_attr( techcamp_thumbnail_class() ); ?>"
		style="background-image:url('<?php echo esc_url( techcamp_thumbnail_url() ); ?>">

		<div class="container detail-header__container">
			<div class="detail-header__primary">

				<div class="breadcrumbs detail-header__breadcrumbs">
					<a href="<?php echo esc_url( get_permalink( techcamp_get_landing_id( 'outcome' ) ) ); ?>">Outcomes</a>
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
				<?php techcamp_term_list( 'topic', 'header' ); ?>
				<div class="detail-meta__location">
					<span><?php echo esc_html( techcamp_location() ); ?></span> <a href="<?php echo esc_url( get_permalink( techcamp_get_map_id() ) ); ?>">View Map</a>
				</div>
				<?php if ( $funded_by = get_post_meta( get_the_ID(), 'funded_by', true ) ) { ?>
					<div class="detail-meta__funded">
						Funded by <?php echo esc_html( $funded_by ); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>

	<?php tha_entry_content_before(); ?>

	<div class="detail-content">
		<div class="detail-content__container container">

			<div class="detail-content__primary entry-content">

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

				<!--
				<div class="box">
					<p>Keep up to date with TechCamp. Sign up for email updates.</p>
					<a class="button" href="#">Stay Connected</a>
				</div>
				-->

				<!-- Slack -->
				<div class="box box--slack">
					<img class="slack-logo" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/slack-logo.png" alt="Slack logo" />
					<?php echo wp_kses_post( wpautop( techcamp_get_setting( 'slack_text', 'outcome' ) ) ); ?>
					<a class="button" href="https://slack.com/signin">Log In</a>
				</div>

				<!-- Related TechCamps -->
				<?php $rel_events = get_posts( array(
					'posts_per_page'  => 3,
					'post_type'       => 'event',
					'connected_type'  => 'events_and_outcomes',
					'connected_items' => get_post(),
					'no_found_rows'   => true
				) );
				if ( $rel_events ) { ?>
					<div class="box box--highlight">
						<h2 class="box__title"><?php echo esc_html( techcamp_get_setting( 'rel_event_label', 'outcome' ) ); ?></h2>
						<ul class="box-list">
							<?php foreach( $rel_events as $post ) {
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
						<h2 class="box__title"><?php echo esc_html( techcamp_get_setting( 'rel_posts_label', 'outcome' ) ); ?></h2>
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

				<?php $links = get_post_meta( get_the_ID(), 'external_links', true );
				if ( $links ) { ?>
					<div class="box box--external">
						<h2 class="box__title"><?php echo esc_html( techcamp_get_setting( 'rel_links_label', 'outcome' ) ); ?></h2>
						<ul class="box-list">
							<?php foreach( $links as $link ) {
								$link = wp_parse_args( $link, array(
									'link_text' => '',
									'link_url'  => '',
								) ); ?>
								<li class="box-list__item box-list__item--external">
									<a class="box-list__title" href="<?php echo esc_url( $link['link_url'] ); ?>"><?php echo esc_html( $link['link_text'] ); ?></a>
								</li>
							<?php } ?>
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
					<h2><?php echo esc_html( techcamp_get_setting( 'photos_label', 'outcome' ) ); ?></h2>
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
					<h2><?php echo esc_html( techcamp_get_setting( 'videos_label', 'outcome' ) ); ?></h2>
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
