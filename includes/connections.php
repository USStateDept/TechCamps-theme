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

	// relationship between an event and its trainers
	p2p_register_connection_type( array(
		'name' => 'event_trainers',
		'from' => 'event',
		'to'   => 'bio'
	) );

	// relationship between an event and any outcomes
	p2p_register_connection_type( array(
		'name' => 'event_outcomes',
		'from' => 'event',
		'to'   => 'outcome'
	) );

	// relationship between an event and a related blog post
	p2p_register_connection_type( array(
		'name' => 'event_blog_posts',
		'from' => 'event',
		'to'   => 'post'
	) );

	// relationship between an event and its related resources
	p2p_register_connection_type( array(
		'name' => 'event_resources',
		'from' => 'event',
		'to'   => 'resource'
	) );

	// relationship between an outcome and a related blog post
	p2p_register_connection_type( array(
		'name' => 'outcome_blog_posts',
		'from' => 'outcome',
		'to'   => 'post'
	) );

	// relationship between an outcome and a resource
	p2p_register_connection_type( array(
		'name' => 'outcome_resources',
		'from' => 'outcome',
		'to'   => 'resource'
	) );

}
add_action( 'p2p_init', 'techcamp_connection_types' );