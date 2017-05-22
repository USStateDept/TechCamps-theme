<?php
/**
 * General hooks (actions/filters) not related to specific
 * post type functionality.
 *
 * @package techcamp
 */

/**
 * Adjust archive title.
 */
function techcamp_archive_title( $title ) {

	if ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	}

	if ( is_home() ) {
		$title = 'Blog';
	}

	return $title;
}
add_action( 'get_the_archive_title', 'techcamp_archive_title' );

/**
 * Remove broken corona filter (Read More link is empty).
 */
function techcamp_remove_filters() {
	remove_filter( 'excerpt_more', 'corona_excerpt_read_more', 10 );
}
add_action( 'corona_init', 'techcamp_remove_filters', 11 );

/**
 * Hook up the short description field to the excerpt, and force the
 * short description to accept the same word count and trailing text
 * as default excerpts.
 */
function techcamp_excerpt( $excerpt ) {

	global $post;
	$desc = get_post_meta( get_the_ID(), 'short_description', true );
	if ( $desc ) {
		$excerpt_length = apply_filters( 'excerpt_length', techcamp_excerpt_length( 55 ) );
		$excerpt_more   = apply_filters( 'excerpt_more', '&hellip;' );
		$desc = wp_trim_words( $desc, $excerpt_length, $excerpt_more );
		return $desc;
	}

	return $excerpt;

}
add_filter( 'get_the_excerpt', 'techcamp_excerpt' );

/**
 * Smartly adjust the excerpt length.
 */
function techcamp_excerpt_length( $length ) {

	global $post;
	if ( get_post_type() === 'resource' || get_post_type() === 'bio' ) {
		return 42;
	}

	if ( get_post_type() === 'post' ) {
		return 25;
	}

	return $length;

}
add_filter( 'excerpt_length', 'techcamp_excerpt_length', 11 );

/**
 * Adjust the trailing characters of excerpts.
 */
function techcamp_excerpt_more( $excerpt_more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'techcamp_excerpt_more' );

/**
 * Adjust the category list classes - used for the region list on landing pages.
 */
function techcamp_category_css_class( $classes ) {
	$classes[] = 'explore-sections__item';
	return $classes;
}
// no add_filter() here - used in page-templates/landing-page.php

/**
 * Adjust the term link destination to go to the events search - used for the
 * region list on landing pages.
 */
function techcamp_override_term_link_for_event( $link, $term, $taxonomy  ) {
	$link = techcamp_get_term_link( $term, $taxonomy, 'event' );
	return $link;
}
// no add_filter() here - used in page-templates/landing-page.php

/**
 * Adjust the term link destination to go to the outcomes search - used for the
 * region list on landing pages.
 */
function techcamp_override_term_link_for_outcome( $link, $term, $taxonomy  ) {
	$link = techcamp_get_term_link( $term, $taxonomy, 'outcome' );
	return $link;
}
// no add_filter() here - used in page-templates/landing-page.php

/**
 * Remove admin menu items.
 */
function techcamp_remove_admin_menu_items(){
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'techcamp_remove_admin_menu_items' );

/**
 * Add Google Tag Manager to the header.
 */
function techcamp_gtm_head() {
	$id = techcamp_get_setting( 'gtm_id' );
	if ( !$id ) {
		return;
	} ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo esc_attr( $id ); ?>');</script>
<!-- End Google Tag Manager -->

	<?php
}
add_action( 'tha_head_bottom', 'techcamp_gtm_head' );

/**
 * Add Google Tag Manager to the footer.
 */
function techcamp_gtm_body() {
	$id = techcamp_get_setting( 'gtm_id' );
	if ( !$id ) {
		return;
	} ?>

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr( $id ); ?>"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<?php
}
add_action( 'tha_body_top', 'techcamp_gtm_body' );
