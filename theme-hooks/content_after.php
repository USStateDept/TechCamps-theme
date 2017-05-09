<?php
/**
 * Content after </main> but before the footer.
 *
 * Contains the logic for which blog posts show up in the Related section.
 *
 * @package techcamp
 */

if ( !is_front_page() && !is_singular() ) {
	return;
}

if ( is_page_template( 'page-templates/landing-page.php' )
  || is_page_template( 'page-templates/topics.php' )
  || is_page_template( 'page-templates/map.php' ) ) {
	return;
}

// grab three posts
$args = $starting_args = array(
	'suppress_filters' => false,
	'post_type'        => 'post',
	'posts_per_page'   => 3,
	'no_found_rows'    => true,
);

if ( !is_front_page() ) {
	global $post;
}

// if event or outcome, relate post by connection
if ( is_singular( array( 'event', 'outcome' ) ) ) {
	$args['connected_type']  = 'blog_connections';
	$args['connected_items'] = array( $post );
}

// if resource or bio, relate by related event
if ( is_singular( array( 'resource', 'bio' ) ) ) {

	// get related events or outcomes
	$events = get_posts( array(
		'fields'          => 'ids',
		'posts_per_page'  => 10, // usually 0 or 1
		'connected_type'  => 'resource_connections',
		'connected_items' => array( $post ),
	) );

	// plug into main query
	$args['connected_type']  = 'blog_connections';
	$args['connected_items'] = $events;

}

// if post, exclude current post and relate to same event/outcome
if ( is_singular( 'post' ) ) {

	// get posts connected to the same event/outcomes
	$has_connected = p2p_type( 'blog_connections' )->get_connected( $post )->posts;
	if ( $has_connected ) {
		$related_posts = p2p_type( 'blog_connections' )->get_related( $post )->posts;

		// this can contain many posts and duplicates, so let's clean it up
		if ( $related_posts ) {

			// get rid of duplicates
			$unique = array();
			$id_tracker = array();
			foreach( $related_posts as $object ) {
				if ( !in_array( $object->ID, $id_tracker ) ) {
					$unique[] = $object;
					$id_tracker[] = $object->ID;
				}
			}
			$related_posts = $unique;

			// limit to 3
			if ( count( $related_posts ) > 3 ) {
				$related_posts = array_slice( $related_posts, 0, 3 );
			}

		}

	} else {
		$related_posts = array();
	}

} else {

	// run the query for everything except posts, since we already did
	$related_posts = get_posts( $args );

}

// if not 3, get extra
if ( count( $related_posts ) < 3 ) {
	$need_this_more = 3 - count( $related_posts );

	// get original args
	$args = $starting_args;

	// exclude current post and any posts we already found
	$related_ids = wp_list_pluck( $related_posts, 'ID' );

	if ( is_singular( 'post' ) ) {
		$related_ids[] = $post->ID;
	}
	$args['post__not_in']   = $related_ids;
	$args['posts_per_page'] = $need_this_more;

	$more_related_posts = get_posts( $args );
	$related_posts = array_merge( $related_posts, $more_related_posts );

}

// finally, output the posts
techcamp_surfaced_posts(
	is_front_page() ? 'home' : 'single',
	is_front_page() ? 'From the Blog' : 'Related Blog Posts',
	$related_posts,
	'Explore Our Blog',
	get_post_type_archive_link( 'post' )
);
