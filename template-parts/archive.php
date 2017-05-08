<?php
/**
 * Template part for displaying a generic result in an archive.
 */
?>

<?php tha_entry_before();

$include_thumb = !is_post_type_archive( 'resource' ) && get_post_type() !== 'bio';
$thumb_class = $include_thumb ? 'has-thumb' : 'no-thumb';

if ( is_search() && !has_post_thumbnail() ) {
	$include_thumb = false;
	$thumb_class = 'no-thumb';
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry archive-entry ' . $thumb_class ); ?>>

	<?php tha_entry_top(); ?>

	<?php if ( $include_thumb ) { ?>
		<div class="archive-entry__thumb">
			<a href="<?php the_permalink(); ?>">
				<?php if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'archive-thumb' );
				} else { ?>
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/world-archive.png" alt="" />
				<?php } ?>
			</a>
		</div>
	<?php } ?>

	<div class="archive-entry__text">
		<?php if ( get_post_type() === 'post' ) { ?>
			<div class="surfaced-posts__date"><?php the_time( 'm.d.Y' ); ?></div>
		<?php } ?>

		<header class="archive-entry__header">
			<?php if ( get_post_type() === 'bio' ) { ?>
				<div class="archive-entry__portrait">
					<a href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'icon' );
						} else { ?>
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bio.png" alt="Silhouette" />
						<?php } ?>
					</a>
				</div>
			<?php } ?>
			<h3 class="archive-entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		</header>

		<?php tha_entry_content_before(); ?>

		<div class="archive-entry__excerpt entry-excerpt archive-content container">
			<?php the_excerpt(); ?>
		</div><!-- .archive-content -->

		<?php tha_entry_content_after(); ?>

		<footer class="entry-footer">
			<?php corona_entry_footer(); ?>
		</footer><!-- .entry-footer -->

		<?php tha_entry_bottom(); ?>

	</div>

</article><!-- #post-## -->

<?php tha_entry_after(); ?>
