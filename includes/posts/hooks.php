<?php
/**
 * Hooks for posts.
 *
 * @package techcamp
 */

/**
 * Only display posts on taxonomy archive pages.
 *
 * Events and Outcomes handle taxonomy archives in their own way.
 */
function techcamp_post_term_archives( $query ) {

	if ( is_admin() || !$query->is_main_query() ) {
		return;
	}

	if ( !is_tax() && !is_category() && !is_tag() ) {
		return;
	}

	$query->set( 'post_type', 'post' );

}
add_action( 'pre_get_posts', 'techcamp_post_term_archives' );
