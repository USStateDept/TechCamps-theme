<?php
/**
 * Top of content.
 *
 * @package techcamp
 */

/**
 * Display an archive heading - either some basic text or a full
 * hero section, depending on context.
 */
if ( is_home() || is_archive() ) {

	if ( is_post_type_archive( 'resource' ) || techcamp_is_blog_archive() ) {

		$context = is_post_type_archive( 'resource' ) ? 'resource' : 'post'; ?>

		<div class="hero hero--landing hero--<?php echo esc_attr( $context ); ?>">
			<?php $hero_settings = get_option( $context . '_settings' );
			$hero_settings = wp_parse_args( $hero_settings, array(
				'hero_image'    => '',
				'hero_image_id' => 0,
				'hero_text'     => '',
			) );
			if ( $hero_settings['hero_image_id'] ) {
				echo wp_get_attachment_image( $hero_settings['hero_image_id'], 'hero', false, array(
					'class' => 'hero__image',
				) );
			} ?>
			<div class="hero__container container">
				<div class="hero__text-box">
					<?php echo wp_kses_post( $hero_settings['hero_text'] ); ?>
				</div>
			</div>
		</div>

	<?php } else { ?>

		<header class="archive-header page-header">
			<?php if ( is_search() ) { ?>
				<h1 class="archive-title">Search Results</h1>
			<?php } else {
				the_archive_title( '<h1 class="archive-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
			} ?>
		</header><!-- .page-header -->

	<?php }

}

/**
 * Display a search bar if we are on the main search page, the 404,
 * or the event/outcome archive pages.
 */
if ( is_search() || is_404() || is_post_type_archive( 'event' ) || is_post_type_archive( 'outcome' ) ) { ?>

	<div class="archive-search">
		<div class="archive-search__container container">

			<?php if ( is_search() || is_404() ) {
				$id     = 'archive-search-input';
				$action = site_url();
				$name   = 's';
			}

			if ( is_post_type_archive() ) {
				$id     = 'explore-keyword';
				$type   = get_query_var( 'post_type' );
				$action = get_post_type_archive_link( $type );
				$name   = 'keyword';
			} ?>

			<form id="archive-search-form" class="archive-search__form" action="<?php echo esc_attr( $action ); ?>">
				<label class="element-invisible" for="<?php echo esc_attr( $id ); ?>">Search</label>
				<input id="<?php echo esc_attr( $id ); ?>" class="archive-search__input" name="<?php echo esc_attr( $name ); ?>" type="text" placeholder="Type here&hellip;" value="<?php echo esc_attr( techcamp_get_search_query() ); ?>" />
				<button class="archive-search__submit" type="submit"><span class="element-invisible">Go</span></button>
			</form>

		</div>
	</div>

<?php } ?>
