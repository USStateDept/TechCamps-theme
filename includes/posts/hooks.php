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

/**
 * Only display four posts on blog archive pages.
 */
function techcamp_post_archives( $query ) {

	if ( is_admin() || !techcamp_is_blog_archive() ) {
		return;
	}

	$query->set( 'posts_per_page', 4 );

}
add_action( 'pre_get_posts', 'techcamp_post_archives' );

/**
 * Replace the posts-page message with a friendly message about the blog settings.
 */
function techcamp_extended_posts_page_notice( $post ) {
	remove_action( 'edit_form_after_title', '_wp_posts_page_notice' );
	if ( $post->ID == get_option( 'page_for_posts' ) && empty( $post->post_content ) ) { ?>
		<div class="notice notice-warning inline"><p>You are currently editing the page that shows your latest posts. To edit the hero section of this page, go to <a href="<?php echo esc_url( admin_url( 'edit.php?page=post_settings' ) ); ?>">Posts > Post Settings</a>.</p></div>
	<?php }
}
add_action( 'edit_form_after_title', 'techcamp_extended_posts_page_notice', 9 );
