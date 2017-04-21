<?php
/**
 * Content after </main> but before the footer.
 *
 * @package techcamp
 */

if ( !is_front_page() && !is_singular() ) {
	return;
}

if ( is_page_template( 'page-templates/landing-page.php' )
  || is_page_template( 'page-templates/topics.php' ) ) {
	return;
}

// get three latest blog posts
$latest_posts = get_posts( array(
	'suppress_filters' => false,
	'post_type'        => 'post',
	'posts_per_page'   => 3,
) );

techcamp_surfaced_posts(
	is_front_page() ? 'home' : 'single',
	is_front_page() ? 'From the Blog' : 'Related Blog Posts',
	$latest_posts,
	'Explore Our Blog',
	get_post_type_archive_link( 'post' )
);
