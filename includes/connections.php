<?php
/**
 * Techcamp post-to-post connection registry.
 *
 * Using the Posts to Posts plugin for direct connections.
 *
 * @package techcamp
 */

/**
 * Register connection types.
 *
 * Think of connections as custom fields that appear on two posts that are connected to each other.
 * If you remove a connection from one of the posts, it's removed from the other as well.
 *
 * Connection types are each connection field - for example, between an event and its trainers, or
 * between an event and related blog posts.
 */
function techcamp_connection_types() {

	// connect resources/bios to events/outcomes
	p2p_register_connection_type( array(
		'name'        => 'resource_connections',
		'from'        => array( 'resource', 'bio' ),
		'to'          => array( 'event', 'outcome' ),
		'sortable'    => 'any',
		'title'       => array(
			'from'          => 'Related Events & Outcomes',
			'to'            => 'Related Resources & Bios',
		),
		'from_labels' => array(
			'singular_name' => 'Event or Outcome',
			'search_items'  => 'Search events/outcomes',
			'not_found'     => 'No events or outcomes found.',
		),
		'to_labels'   => array(
			'singular_name' => 'Resource or Bio',
			'search_items'  => 'Search resources/bios',
			'not_found'     => 'No resources or bios found.',
		),
	) );

	// connect blog posts to events/outcomes
	p2p_register_connection_type( array(
		'name'        => 'blog_connections',
		'from'        => array( 'post' ),
		'to'          => array( 'event', 'outcome' ),
		'sortable'    => 'any',
		'title'       => array(
			'from'          => 'Related Events & Outcomes',
			'to'            => 'Related Blog Posts',
		),
		'from_labels'   => array(
			'singular_name' => 'Post',
			'search_items'  => 'Search posts',
			'not_found'     => 'No posts found.',
		),
		'to_labels' => array(
			'singular_name' => 'Event or Outcome',
			'search_items'  => 'Search events/outcomes',
			'not_found'     => 'No events or outcomes found.',
		),
	) );

	// connect events and outcomes to each other
	p2p_register_connection_type( array(
		'name'     => 'events_and_outcomes',
		'from'     => 'event',
		'to'       => 'outcome',
		'sortable' => 'any',
		'title'    => array(
			'from' => 'Related Outcomes',
			'to'   => 'Related Events',
		),
	) );

}
add_action( 'p2p_init', 'techcamp_connection_types' );
