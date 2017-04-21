<?php
/**
 * Top of content.
 *
 * Add a search form on search and post type archive pages.
 *
 * @package techcamp
 */

if ( !is_search() && !is_post_type_archive() && !is_404() ) {
	return;
}

if ( is_post_type_archive( 'resource' ) ) {
	return;
}

?>

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
