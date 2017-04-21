<?php
/**
 * Template part for displaying posts and bios.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package techcamp
 */
?>

<?php tha_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

	<?php tha_entry_top(); ?>

	<header class="entry-header">
		<?php if ( is_singular() && !is_page() ) { ?>
			<div class="entry-header__crumb">
				<?php if ( is_singular( 'post' ) ) { ?>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>">Blog</a>
				<?php } else if ( is_singular( 'bio' ) ) { ?>
					<a href="<?php echo get_post_type_archive_link( 'resource' ); ?>">Trainers</a>
				<?php } else if ( is_singular( 'resource' ) ) { ?>
					<a href="<?php echo get_post_type_archive_link( 'resource' ); ?>">Resources</a>
				<?php } else {
					echo esc_html( techcamp_get_post_type_label( get_post_type() ) );
				} ?>
			</div>
		<?php } ?>
		<?php the_title( '<h1 class="entry-title entry-header__title">', '</h1>' ); ?>
		<?php if ( is_singular( 'post' ) ) { ?>
			<div class="entry-header__meta">
				<?php if ( $blog_author = get_post_meta( get_the_ID(), 'blog_author', true ) ) { ?>
					<div class="entry-header__author">
						<?php echo esc_html( $blog_author ); ?>
					</div>
				<?php } ?>
				<div class="entry-header__date">
					<?php the_time( 'F j, Y' ); ?>
				</div>
			</div>
		<?php } else if ( is_singular( 'bio' ) ) {

			$position     = get_post_meta( get_the_ID(), 'position', true );
			$organization = get_post_meta( get_the_ID(), 'organization', true );
			$output       = '';
			if ( $position && $organization ) {
				$output = $position . ', ' . $organization;
			} else if ( $position ) {
				$output = $position;
			} else if ( $organization ) {
				$output = $organization;
			}
			if ( $output ) { ?>
				<div class="entry-header__meta">
					<div class="entry-header__author">
						<?php echo esc_html( $output ); ?>
					</div>
				</div>
			<?php }

		} else if ( is_singular( 'resource' ) ) { ?>
			<div class="entry-header__meta">
				<?php
				$resource_url = get_post_meta( get_the_ID(), 'resource_url', true );
				$ext = pathinfo( $resource_url, PATHINFO_EXTENSION ); ?>
				<div class="entry-header__meta-item entry-header__ext entry-header__ext--<?php echo sanitize_key( $ext ); ?>">
					<a href="<?php echo esc_url( $resource_url ); ?>"><?php echo strtoupper( esc_html( $ext ) ); ?> File</a>
				</div>

				<?php $types = get_the_terms( get_the_ID(), 'resource_type' );
				$type_list = array();
				foreach( $types as $type ) {
					$type_list[] = '<a href="' . get_post_type_archive_link( 'resource' ) . '?types[]=' . $type->term_id . '">' . $type->name . '</a>';
				}
				$list = implode( ', ', $type_list );
				if ( $list ) { ?>
					<div class="entry-header__meta-item entry-header__type">
						<?php echo wp_kses_post( $list ); ?>
					</div>
				<?php } ?>

				<?php $related = get_posts( array(
					'suppress_filters' => false,
					'connected_items'  => array( get_post() ),
					'connected_type'   => 'resource_connections',
				) );
				$rels = array();
				foreach( $related as $post ) {
					setup_postdata( $post );
					$rels[] = '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
				}
				$relateds = implode( ', ', $rels );
				if ( $relateds ) { ?>
					<div class="entry-header__meta-item entry-header__related">
						<?php echo wp_kses_post( $relateds ); ?>
					</div>
				<?php }
				wp_reset_postdata(); ?>

			</div>
		<?php } ?>
	</header><!-- .entry-header -->

	<?php tha_entry_content_before(); ?>

	<div class="entry-content">
		<?php if ( has_post_thumbnail() ) {

			$size = 'inline-big';
			if ( get_post_type() === 'bio' ) {
				$size = 'surfaced-thumbnail';
			}

			$caption = get_post( get_post_thumbnail_id() )->post_excerpt; ?>
			<figure>
				<?php the_post_thumbnail( $size ); ?>
				<?php if ( $caption ) { ?>
					<figcaption><?php echo wp_kses_post( $caption ); ?></figcaption>
				<?php } ?>
			</figure>
		<?php } ?>

		<?php if ( is_singular( 'resource' ) ) {
			$subhead = get_post_meta( get_the_ID(), 'subhead', true );
			$desc = techcamp_process_wysiwyg( 'short_description' ); ?>

			<div class="resource-content">
				<?php if ( $subhead ) { ?>
					<h2 class="resource-content__subhead"><?php echo esc_html( $subhead ); ?></h2>
				<?php } ?>
				<?php if ( $desc ) { ?>
					<div class="resource-content__desc">
						<?php echo wp_kses_post( $desc ); ?>
					</div>
				<?php } ?>
				<p class="resource-content__link">
					<a class="button" target="_blank" href="<?php echo esc_url( $resource_url ); ?>">View this Resource</a>
				</p>
			</div>

		<?php } else { ?>

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

		<?php } ?>

		<?php if ( is_singular( 'bio' ) ) {

			$contact = get_post_meta( get_the_ID(), 'contact', true );
			if ( $contact ) { ?>
				<div class="bio-meta">
					<h2 class="bio-meta__heading">Best Ways to Contact Me:</h2>
					<ul class="bio-meta__list">
						<?php foreach( $contact as $link ) {
							if ( is_email( $link ) ) { ?>
								<li><a href="mailto:<?php echo esc_attr( sanitize_email( $link ) ); ?>">Email</a></li>
							<?php } else {
								$friendly = $link;
								if ( strpos( $link, 'facebook.com' ) !== false )
									$friendly = 'Facebook';
								if ( strpos( $link, 'twitter.com' ) !== false )
									$friendly = 'Twitter';
								if ( strpos( $link, 'linkedin.com' ) !== false )
									$friendly = 'LinkedIn';
								if ( strpos( $link, 'youtube.com' ) !== false )
									$friendly = 'YouTube';
								if ( strpos( $link, 'medium.com' ) !== false )
									$friendly = 'Medium';
								if ( strpos( $link, 'instagram.com' ) !== false )
									$friendly = 'Instagram'; ?>
								<li><a target="_blank" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $friendly ); ?></a></li>
							<?php } ?>
						<?php } ?>
					</ul>
				</div>
			<?php }

			$connected = get_posts( array(
				'connected_type'  => 'resource_connections',
				'connected_items' => array( get_post() ),
				'posts_per_page'  => 50,
			) );
			if ( $connected ) { ?>
				<div class="bio-meta">
					<h2 class="bio-meta__heading">Events:</h2>
					<ul class="bio-meta__list">
						<?php foreach( $connected as $post ) {
							setup_postdata( $post ); ?>
							<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
						<?php }
						wp_reset_postdata(); ?>
					</ul>
				</div>
			<?php }

		} ?>

	</div><!-- .entry-content -->

	<?php tha_entry_content_after(); ?>

	<footer class="entry-footer">
		<?php corona_entry_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php tha_entry_bottom(); ?>

</article><!-- #post-## -->

<?php tha_entry_after(); ?>
