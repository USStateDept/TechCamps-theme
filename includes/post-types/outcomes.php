<?php
/**
 * Techcamp outcome post type and custom fields.
 *
 * @package techcamp
 */

/**
 * Register the outcome post type.
 */
function techcamp_outcome_post_type() {

	register_post_type( 'outcome', array(
		'labels' => array(
			'name'                  => 'Outcomes',
			'singular_name'         => 'Outcome',
			'add_new_item'          => 'Add New Outcome',
			'edit_item'             => 'Edit Outcome',
			'new_item'              => 'New Outcome',
			'view_item'             => 'View Outcome',
			'search_items'          => 'Search Outcomes',
			'not_found'             => 'No outcomes found.',
			'not_found_in_trash'    => 'No outcomes found in Trash.',
			'parent_item_colon'     => 'Parent Outcome:',
			'all_items'             => 'All Outcomes',
			'archives'              => 'Outcomes',
			'insert_into_item'      => 'Insert into outcome',
			'uploaded_to_this_item' => 'Uploaded to this outcome',
			'filter_items_list'     => 'Filter outcomes list',
			'items_list_navigation' => 'Outcomes list navigation',
			'items_list'            => 'Outcomes list'
		),
		'public'       => true,
		'menu_icon'    => 'dashicons-chart-bar',
		'hierarchical' => false,
		'supports'     => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'page-attributes' ),
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'outcomes' )
	) );

}
add_action( 'init', 'techcamp_outcome_post_type' );

/**
 * Register a metabox and fields for the outcome post type.
 */
function techcamp_outcome_fields() {

	$outcome_box = new_cmb2_box( array(
		'id'           => 'outcome_box',
		'title'        => __( 'Outcome Fields', 'techcamp' ),
		'object_types' => array( 'outcome' )
	) );

	$outcome_box->add_field( array(
		'id'   => 'funded_by',
		'name' => __( 'Funded by', 'techcamp' ),
		'type' => 'text'
	) );

	$outcome_box->add_field( array(
		'id'   => 'follow_on',
		'name' => __( 'Follow-on event?', 'techcamp' ),
		'desc' => 'Yes',
		'type' => 'checkbox'
	) );

	$outcome_box->add_field( array(
		'id'   => 'address',
		'name' => __( 'Address', 'techcamp' ),
		'type' => 'text',
		'desc' => 'Enter the city in which the Outcome is held. Do not include the country.'
	) );

	$outcome_box->add_field( array(
		'id'       => 'country',
		'name'     => __( 'Country', 'techcamp' ),
		'type'     => 'taxonomy_select',
		'taxonomy' => 'country',
		'desc'     => 'Select the country in which the Outcome is held.',
		'remove_default' => true
	) );

	$outcome_box->add_field( array(
		'id'   => 'exclude_from_map',
		'name' => __( 'Exclude from map?', 'techcamp' ),
		'desc' => 'Yes',
		'type' => 'checkbox'
	) );

	$outcome_box->add_field( array(
		'id'   => 'images',
		'name' => __( 'Flickr image gallery embed', 'techcamp' ),
		'type' => 'textarea_code'
	) );

	$outcome_box->add_field( array(
		'id'      => 'color_scheme',
		'name'    => __( 'Color scheme', 'techcamp' ),
		'type'    => 'select',
		'options' => array(
			'blue'  => 'Blue',
			'green' => 'Green'
		)
	) );

	$outcome_box->add_field( array(
		'id'      => 'short_description',
		'name'    => __( 'Short Description', 'techcamp' ),
		'type'    => 'wysiwyg',
		'options' => array(
			'textarea_rows' => 6
		)
	) );

}
add_action( 'cmb2_admin_init', 'techcamp_outcome_fields' );
