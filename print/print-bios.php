<?php
/**
 * The template used for printing/saving the agenda only.
 *
 * @package techcamp
 */

tha_html_before(); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php tha_head_top(); ?>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php tha_head_bottom();?>
	<?php wp_head(); ?>

	<script>
		window.print();
	</script>

	<style>
		@page {
			size:portrait;
		}
	</style>

</head>

<body <?php body_class( 'print print-bios' ); ?>>

	<div class="agenda">
		<h1>Trainer Bios</h1>
		<?php $trainers = get_posts( array(
			'posts_per_page'  => 200,
			'post_type'       => 'bio',
			'connected_type'  => 'resource_connections',
			'connected_items' => get_post(),
			'no_found_rows'   => true
		) );
		if ( $trainers ) {
			foreach( $trainers as $post ) {
				setup_postdata( $post ); ?>
				<h2><?php the_title(); ?></h2>
				<p>
					<span class="bios__position"><?php echo get_post_meta( get_the_ID(), 'position', true ); ?></span>
					<span class="bios__organization"><?php echo get_post_meta( get_the_ID(), 'organization', true ); ?></span>
				</p>
				<div><?php the_content(); ?></div>
				<hr />
			<?php }
			wp_reset_postdata();
		} ?>
	</div>

	<?php wp_footer(); ?>
</body>
</html>
