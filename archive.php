<?php
/**
 * The template for displaying archive pages.
 *
 * @package techcamp
 */

get_header(); ?>

	<?php tha_content_before(); ?>

	<main id="main" class="content main-archive <?php if ( is_home() || is_tax() || is_category() || is_tag() ) { ?>main-archive--no-search<?php } ?> full-width" role="main"><!-- post loop -->

		<?php if ( is_post_type_archive( 'resource') ) { ?>

			<div class="hero hero--landing hero--resources">
				<?php $resource_settings = get_option( 'resource_settings' );
				$resource_settings = wp_parse_args( $resource_settings, array(
					'hero_image'    => '',
					'hero_image_id' => 0,
					'hero_text'     => '',
				) );
				if ( $resource_settings['hero_image_id'] ) {
					echo wp_get_attachment_image( $resource_settings['hero_image_id'], 'inner-hero', false, array(
						'class' => 'hero__image',
					) );
				} ?>
				<div class="hero__container container">
					<div class="hero__text-box">
						<?php echo wp_kses_post( $resource_settings['hero_text'] ); ?>
					</div>
				</div>
			</div>

		<?php } else { ?>

			<header class="archive-header page-header">
				<?php if ( is_search() ) { ?>
					<h1 class="archive-title">Search Results</h1>
				<?php } else if ( is_category() || is_tag() || is_tax() ) { ?>
					<h1 class="archive-title">Blog</h1>
				<?php } else {
					the_archive_title( '<h1 class="archive-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
				} ?>
			</header><!-- .page-header -->

		<?php } ?>

		<?php tha_content_top(); ?>

		<div class="archive-body">
			<div class="archive-container container <?php if ( is_post_type_archive( 'resource' ) ) { ?>archive-container--two-col<?php } ?>">
				<?php tha_content_while_before(); ?>
				<div class="archive-inner">
					<?php corona_loop( 'template-parts/archive', get_post_type() ); ?>
				</div>
				<?php tha_content_while_after(); ?>
			</div>
		</div>

		<?php tha_content_bottom(); ?>

	</main><!-- #main -->
	<?php tha_content_after(); ?>

<?php get_footer();
