<?php
/**
 * Techcamp bio post type and custom fields.
 *
 * @package techcamp
 */

/**
 * Register the bio post type.
 */
function techcamp_bio_post_type() {

	register_post_type( 'bio', array(
		'labels' => array(
			'name'                  => 'Bios',
			'singular_name'         => 'Bio',
			'add_new_item'          => 'Add New Bio',
			'edit_item'             => 'Edit Bio',
			'new_item'              => 'New Bio',
			'view_item'             => 'View Bio',
			'search_items'          => 'Search Bios',
			'not_found'             => 'No bios found.',
			'not_found_in_trash'    => 'No bios found in the trash.',
			'parent_item_colon'     => 'Parent Bio:',
			'all_items'             => 'All Bios',
			'archives'              => 'Bios',
			'insert_into_item'      => 'Insert into bio',
			'uploaded_to_this_item' => 'Uploaded to this bio',
			'filter_items_list'     => 'Filter bios list',
			'items_list_navigation' => 'Bios list navigation',
			'items_list'            => 'Bios list'
		),
		'public'       => true,
		'menu_icon'    => 'dashicons-id-alt',
		'hierarchical' => false,
		'supports'     => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'page-attributes' ),
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'bios' )
	) );

}
add_action( 'init', 'techcamp_bio_post_type' );

/**
 * Register a metabox and fields for the bio post type.
 */
function techcamp_bio_fields() {

	$bio_box = new_cmb2_box( array(
		'id'           => 'bio_box',
		'title'        => __( 'Bio Fields', 'techcamp' ),
		'object_types' => array( 'bio' )
	) );

	$bio_box->add_field( array(
		'id'   => 'position',
		'name' => __( 'Position', 'techcamp' ),
		'type' => 'text'
	) );

	$bio_box->add_field( array(
		'id'   => 'organization',
		'name' => __( 'Organization', 'techcamp' ),
		'type' => 'text'
	) );

	$bio_box->add_field( array(
		'id'         => 'contact',
		'name'       => __( 'Best Ways to Contact Me', 'techcamp' ),
		'type'       => 'text',
		'repeatable' => true,
		'attributes' => array(
			'placeholder' => 'Enter an email address or social media profile URL'
		),
		'options'    => array(
			'add_row_text' => __( 'Add contact method', 'techcamp' )
		)
	) );

}
add_action( 'cmb2_admin_init', 'techcamp_bio_fields' );
