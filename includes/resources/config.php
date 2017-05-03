<?php
/**
 * Techcamp resource post type and custom fields.
 *
 * @package techcamp
 */

/**
 * Register the resource post type.
 */
function techcamp_resource_post_type() {

	register_post_type( 'resource', array(
		'labels' => array(
			'name'                  => 'Resources',
			'singular_name'         => 'Resource',
			'add_new_item'          => 'Add New Resource',
			'edit_item'             => 'Edit Resource',
			'new_item'              => 'New Resource',
			'view_item'             => 'View Resource',
			'search_items'          => 'Search Resources',
			'not_found'             => 'No resources found.',
			'not_found_in_trash'    => 'No resources found in the trash.',
			'parent_item_colon'     => 'Parent Resource:',
			'all_items'             => 'All Resources',
			'archives'              => 'Resources',
			'insert_into_item'      => 'Insert into resource',
			'uploaded_to_this_item' => 'Uploaded to this resource',
			'filter_items_list'     => 'Filter resources list',
			'items_list_navigation' => 'Resources list navigation',
			'items_list'            => 'Resources list'
		),
		'public'       => true,
		'menu_icon'    => 'dashicons-sos',
		'hierarchical' => false,
		'supports'     => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'page-attributes' ),
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'resources', 'with_front' => false )
	) );

}
add_action( 'init', 'techcamp_resource_post_type' );

/**
 * Register a metabox and fields for the resource post type.
 */
function techcamp_resource_fields() {

	$resource_box = new_cmb2_box( array(
		'id'           => 'resource_box',
		'title'        => __( 'Resource Fields', 'techcamp' ),
		'object_types' => array( 'resource' )
	) );

	$resource_box->add_field( array(
		'id'   => 'subhead',
		'name' => __( 'Subhead', 'techcamp' ),
		'type' => 'text'
	) );

	$resource_box->add_field( array(
		'id'   => 'resource_url',
		'name' => __( 'Resource URL', 'techcamp' ),
		'type' => 'text_url'
	) );

	$resource_box->add_field( array(
		'id'   => 'pinned',
		'name' => __( 'Pinned', 'techcamp' ),
		'desc' => 'Pin to top of resource library results',
		'type' => 'select',
		'options' => array( // can't use checkbox because we need a negative value, not no value
			'0' => 'No',
			'1' => 'Yes',
		),
	) );

	$resource_box->add_field( array(
		'id'   => 'post_led_resource',
		'name' => __( 'Related to post-led TechCamp?', 'techcamp' ),
		'desc' => 'Yes',
		'type' => 'checkbox'
	) );

	$resource_box->add_field( array(
		'id'      => 'short_description',
		'name'    => __( 'Short Description', 'techcamp' ),
		'type'    => 'wysiwyg',
		'options' => array(
			'textarea_rows' => 6
		)
	) );

}
add_action( 'cmb2_admin_init', 'techcamp_resource_fields' );
