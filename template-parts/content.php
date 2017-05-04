<?php
/**
 * Template part for displaying blog posts, bios, and resources.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package techcamp
 */
?>

<?php tha_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

	<?php tha_entry_top(); ?>

	<?php
	$classes = 'entry-header';
	$styles  = '';
	if ( is_singular( 'post' ) || is_singular( 'resource' ) ) {
		if ( has_post_thumbnail() ) {
			$classes .= ' ' . techcamp_thumbnail_class();
			$styles = 'background-image:url(' . esc_url( techcamp_thumbnail_url() ) . ');';
		}
	} ?>
	<header class="<?php echo esc_attr( $classes ); ?>" style="<?php echo esc_attr( $styles ); ?>">
		<?php if ( is_singular() && !is_page() ) { ?>
			<div class="entry-header__crumb">
				<?php if ( is_singular( 'post' ) ) { ?>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>">Blog</a>
				<?php } else if ( is_singular( 'bio' ) ) { ?>
					<a href="<?php echo esc_url( techcamp_get_setting( 'archive_url', 'bio' ) ); ?>"><?php echo esc_html( techcamp_get_setting( 'archive_label', 'bio' ) ); ?></a>
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
		<?php } ?>
	</header><!-- .entry-header -->

	<?php tha_entry_content_before(); ?>

	<div class="entry-content">

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
					<?php
					$resource_url = get_post_meta( get_the_ID(), 'resource_url', true );
					$ext = pathinfo( $resource_url, PATHINFO_EXTENSION ); ?>
					<a class="button button--icon button--icon-<?php echo sanitize_key( $ext ); ?>" target="_blank" href="<?php echo esc_url( $resource_url ); ?>">Download <?php echo strtoupper( esc_html( $ext ) ); ?> File</a>
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

			$connected = get_posts( array(
				'connected_type'  => 'resource_connections',
				'connected_items' => array( get_post() ),
				'posts_per_page'  => 50,
			) );
			if ( $connected ) { ?>
				<div class="bio-meta">
					<h2 class="bio-meta__heading"><?php echo esc_html( techcamp_get_setting( 'techcamps_label', 'bio' ) ); ?></h2>
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
