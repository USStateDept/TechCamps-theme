<?php
/**
 * Custom fields and modifications for basic blog posts.
 *
 * @package techcamp
 */

/**
 * Register a metabox and fields for basic posts.
 */
function techcamp_post_fields() {

	$post_box = new_cmb2_box( array(
		'id'           => 'post_box',
		'title'        => __( 'Blog Post Fields', 'techcamp' ),
		'object_types' => array( 'post' )
	) );

	$post_box->add_field( array(
		'id'      => 'short_description',
		'name'    => __( 'Short Description', 'techcamp' ),
		'type'    => 'wysiwyg',
		'options' => array(
			'textarea_rows' => 6
		)
	) );

}
add_action( 'cmb2_admin_init', 'techcamp_post_fields' );

/**
 * Remove default fields from posts.
 */
function techcamp_remove_post_defaults() {

	// remove post formats
	remove_post_type_support( 'post', 'post-formats' );

	// remove category taxonomy
	unregister_taxonomy_for_object_type( 'category', 'post' );

}
add_action( 'init', 'techcamp_remove_post_defaults' );