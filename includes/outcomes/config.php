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
		'has_archive'  => 'outcomes/all',
		'rewrite'      => array( 'slug' => 'outcomes', 'with_front' => false )
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
		'id'   => 'subhead',
		'name' => __( 'Subhead', 'techcamp' ),
		'type' => 'text'
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
		'name'     => __( 'Region', 'techcamp' ),
		'type'     => 'taxonomy_select',
		'taxonomy' => 'country',
		'desc'     => 'Select the region in which the Outcome is held.',
		'remove_default' => true
	) );

	$outcome_box->add_field( array(
		'id'   => 'exclude_from_map',
		'name' => __( 'Exclude from map?', 'techcamp' ),
		'desc' => 'Yes',
		'type' => 'checkbox'
	) );

	$links_group = $outcome_box->add_field( array(
		'name'    => 'Related Links',
		'id'      => 'external_links',
		'type'    => 'group',
		'options' => array(
			'group_title'   => 'Link {#}',
			'sortable'      => true,
			'add_button'    => 'Add Link',
			'remove_button' => 'Remove Link',
		),
	) );

	$outcome_box->add_group_field( $links_group, array(
		'name' => 'Link Text',
		'id'   => 'link_text',
		'type' => 'text',
	) );

	$outcome_box->add_group_field( $links_group, array(
		'name' => 'Link URL',
		'id'   => 'link_url',
		'type' => 'text_url',
	) );

	$outcome_box->add_field( array(
		'id'   => 'images',
		'name' => __( 'Image Embed', 'techcamp' ),
		'type' => 'textarea_code'
	) );

	$outcome_box->add_field( array(
		'id'   => 'images_upload',
		'name' => __( 'Image Upload', 'techcamp' ),
		'type' => 'wysiwyg'
	) );

	$outcome_box->add_field( array(
		'id'         => 'videos',
		'name'       => __( 'Videos', 'techcamp' ),
		'type'       => 'text',
		'repeatable' => true,
		'attributes' => array(
			'placeholder' => 'Enter a YouTube or Vimeo URL'
		),
		'options'    => array(
			'add_row_text' => __( 'Add video', 'techcamp' )
		)
	) );

	$outcome_box->add_field( array(
		'id'      => 'color_scheme',
		'name'    => __( 'Color scheme', 'techcamp' ),
		'type'    => 'select',
		'options' => array(
			'orange' => 'Orange',
			'blue'   => 'Blue',
			'green'  => 'Green',
			'purple' => 'Purple',
			'pink'   => 'Deep Pink',
			'ocean'  => 'Ocean',
			'red'    => 'Red',
			'olive'  => 'Olive',
			'maroon' => 'Maroon'
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
