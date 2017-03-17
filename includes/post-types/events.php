<?php
/**
 * Techcamp event post type and custom fields.
 *
 * @package techcamp
 */

/**
 * Register the event post type.
 */
function techcamp_event_post_type() {

	register_post_type( 'event', array(
		'labels' => array(
			'name'                  => 'Events',
			'singular_name'         => 'Event',
			'add_new_item'          => 'Add New Event',
			'edit_item'             => 'Edit Event',
			'new_item'              => 'New Event',
			'view_item'             => 'View Event',
			'search_items'          => 'Search Events',
			'not_found'             => 'No events found.',
			'not_found_in_trash'    => 'No events found in Trash.',
			'parent_item_colon'     => 'Parent Event:',
			'all_items'             => 'All Events',
			'archives'              => 'Events',
			'insert_into_item'      => 'Insert into event',
			'uploaded_to_this_item' => 'Uploaded to this event',
			'filter_items_list'     => 'Filter events list',
			'items_list_navigation' => 'Events list navigation',
			'items_list'            => 'Events list'
		),
		'public'       => true,
		'menu_icon'    => 'dashicons-calendar',
		'hierarchical' => false,
		'supports'     => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'page-attributes' ),
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'events' )
	) );

}
add_action( 'init', 'techcamp_event_post_type' );

/**
 * Register a metabox and fields for the event post type.
 */
function techcamp_event_fields() {

	$event_box = new_cmb2_box( array(
		'id'           => 'event_box',
		'title'        => __( 'Event Fields', 'techcamp' ),
		'object_types' => array( 'event' )
	) );

	$event_box->add_field( array(
		'id'   => 'subhead',
		'name' => __( 'Subhead', 'techcamp' ),
		'type' => 'text'
	) );

	$event_box->add_field( array(
		'id'   => 'start_date',
		'name' => __( 'Start Date', 'techcamp' ),
		'type' => 'text_date_timestamp',
		'desc' => 'Click to select date'
	) );

	$event_box->add_field( array(
		'id'   => 'end_date',
		'name' => __( 'End Date', 'techcamp' ),
		'type' => 'text_date_timestamp',
		'desc' => 'Click to select date if different than start date'
	) );

	$event_box->add_field( array(
		'id'   => 'address',
		'name' => __( 'Address', 'techcamp' ),
		'type' => 'text',
		'desc' => 'Enter the city in which the TechCamp is held. Do not include the country.'
	) );

	$event_box->add_field( array(
		'id'       => 'country_field',
		'name'     => __( 'Country', 'techcamp' ),
		'type'     => 'taxonomy_select',
		'taxonomy' => 'country',
		'desc'     => 'Select the country in which the TechCamp is held.',
		'remove_default' => true
	) );

	$event_box->add_field( array(
		'id'       => 'participator',
		'name'     => __( 'Participating Countries', 'techcamp' ),
		'type'     => 'taxonomy_multicheck',
		'taxonomy' => 'participator',
		'desc'     => 'Select all countries participating in this TechCamp. Scroll to see more.',
		'remove_default' => true,
		'select_all_button' => false,
		'before' => '<style>.cmb2-checkbox-list{max-height:200px;overflow:scroll;}</style>'
	) );

	$event_box->add_field( array(
		'id'   => 'website_url',
		'name' => __( 'Website URL', 'techcamp' ),
		'type' => 'text_url'
	) );

	$event_box->add_field( array(
		'id'   => 'press_release_url',
		'name' => __( 'Press Release URL', 'techcamp' ),
		'type' => 'text_url'
	) );

	$event_box->add_field( array(
		'id'      => 'short_description',
		'name'    => __( 'Short Description', 'techcamp' ),
		'type'    => 'wysiwyg',
		'options' => array(
			'textarea_rows' => 6
		)
	) );

	$event_box->add_field( array(
		'id'   => 'quote',
		'name' => __( 'Quote', 'techcamp' ),
		'type' => 'text'
	) );

}
add_action( 'cmb2_admin_init', 'techcamp_event_fields' );