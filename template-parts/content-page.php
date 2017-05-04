<?php
/**
 * Template part for displaying basic page content.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package techcamp
 */
?>

<?php tha_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php tha_entry_top(); ?>

	<?php
	$classes = 'entry-header';
	$styles = '';
	if ( has_post_thumbnail() ) {
		$classes .= ' ' . techcamp_thumbnail_class();
		$styles = 'background-image:url(' . esc_url( techcamp_thumbnail_url() ) . ');';
	} ?>
	<header class="<?php echo esc_attr( $classes ); ?>" style="<?php echo esc_attr( $styles ); ?>">
		<?php the_title( '<h1 class="entry-title entry-header__title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<?php tha_entry_content_before(); ?>

	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'corona' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php tha_entry_content_after(); ?>

	<footer class="entry-footer"></footer><!-- .entry-footer -->

	<?php tha_entry_bottom(); ?>

</article><!-- #post-## -->

<?php tha_entry_after(); ?>
