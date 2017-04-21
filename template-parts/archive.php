<?php
/**
 * Template part for displaying a generic result in an archive.
 */
?>

<?php tha_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry archive-entry' ); ?>>

	<?php tha_entry_top(); ?>

	<header class="archive-entry__header">
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

</article><!-- #post-## -->

<?php tha_entry_after(); ?>
