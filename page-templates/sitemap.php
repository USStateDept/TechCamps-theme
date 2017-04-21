<?php
/**
 * Template Name: Sitemap
 *
 * @package techcamp
 */

get_header(); ?>

	<?php tha_content_before(); ?>

	<main id="main" class="content main-basic full-width" role="main">

		<?php tha_content_top(); ?>

		<?php
			tha_content_while_before();
			corona_loop( 'template-parts/content', 'page', $comments = true );
			tha_content_while_after();
		?>

		<div class="entry-content sitemap">

			<h2>Pages</h2>
			<ul>
				<?php wp_list_pages( array(
					'title_li' => false,
				) ); ?>
			</ul>

			<?php $types = array( 'event', 'outcome', 'post', array( 'bio', 'resource' ) );
			foreach( $types as $type ) {
				$posts = get_posts( array(
					'post_type'        => $type,
					'suppress_filters' => false,
					'posts_per_page'   => 10,
				) );
				if ( $posts ) {
					if ( $type === array( 'bio', 'resource' ) ) {
						$label = 'Resources & Bios';
						$archive = get_post_type_archive_link( 'resource' );
					} else {
						$label = techcamp_get_post_type_label( $type );
						$archive = get_post_type_archive_link( $type );
					} ?>
					<h2>Recent <?php echo esc_html( $label ); ?></h2>
					<ul>
						<?php foreach( $posts as $post ) {
							setup_postdata( $post ); ?>
							<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
						<?php } ?>
					</ul>
					<p><a class="button" href="<?php echo esc_url( $archive ); ?>">View All <?php echo esc_html( $label ); ?></a></p>
				<?php }

				wp_reset_postdata();
			} ?>

		</div>

		<?php tha_content_bottom(); ?>

	</main><!-- #main -->

	<?php tha_content_after(); ?>

<?php get_footer();
