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
			'name'                  => 'TechCamps',
			'singular_name'         => 'TechCamp',
			'add_new_item'          => 'Add New TechCamp',
			'edit_item'             => 'Edit TechCamp',
			'new_item'              => 'New TechCamp',
			'view_item'             => 'View TechCamp',
			'search_items'          => 'Search TechCamps',
			'not_found'             => 'No TechCamps found.',
			'not_found_in_trash'    => 'No TechCamps found in Trash.',
			'parent_item_colon'     => 'Parent TechCamp:',
			'all_items'             => 'All TechCamps',
			'archives'              => 'TechCamps',
			'insert_into_item'      => 'Insert into TechCamp',
			'uploaded_to_this_item' => 'Uploaded to this TechCamp',
			'filter_items_list'     => 'Filter TechCamps list',
			'items_list_navigation' => 'TechCamps list navigation',
			'items_list'            => 'TechCamps list'
		),
		'public'       => true,
		'menu_icon'    => 'dashicons-calendar',
		'hierarchical' => false,
		'supports'     => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'page-attributes' ),
		'has_archive'  => 'techcamps/all',
		'rewrite'      => array( 'slug' => 'techcamps', 'with_front' => false )
	) );

}
add_action( 'init', 'techcamp_event_post_type' );

/**
 * Register a metabox and fields for the event post type.
 */
function techcamp_event_fields() {

	$event_box = new_cmb2_box( array(
		'id'           => 'event_box',
		'title'        => __( 'TechCamp Fields', 'techcamp' ),
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
		'name'     => __( 'Region', 'techcamp' ),
		'type'     => 'taxonomy_select',
		'taxonomy' => 'country',
		'desc'     => 'Select the region in which the TechCamp is held.',
		'remove_default' => true
	) );

	$event_box->add_field( array(
		'id'   => 'exclude_from_map',
		'name' => __( 'Exclude from map?', 'techcamp' ),
		'desc' => 'Yes',
		'type' => 'checkbox'
	) );

	$event_box->add_field( array(
		'id'       => 'participator',
		'name'     => __( 'Participating Regions', 'techcamp' ),
		'type'     => 'taxonomy_multicheck',
		'taxonomy' => 'participator',
		'desc'     => 'Select all regions participating in this TechCamp. Scroll to see more.',
		'remove_default' => true,
		'select_all_button' => false,
		'before' => '<style>.cmb2-checkbox-list{max-height:200px;overflow:scroll;}</style>'
	) );

	$event_box->add_field( array(
		'id'   => 'agenda',
		'name' => __( 'Agenda', 'techcamp' ),
		'type' => 'wysiwyg'
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
		'id'   => 'quote',
		'name' => __( 'Quote', 'techcamp' ),
		'type' => 'text'
	) );

	$event_box->add_field( array(
		'id'   => 'attribution',
		'name' => __( 'Quote Attribution', 'techcamp' ),
		'type' => 'text'
	) );

	$links_group = $event_box->add_field( array(
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

	$event_box->add_group_field( $links_group, array(
		'name' => 'Link Text',
		'id'   => 'link_text',
		'type' => 'text',
	) );

	$event_box->add_group_field( $links_group, array(
		'name' => 'Link URL',
		'id'   => 'link_url',
		'type' => 'text_url',
	) );

	$event_box->add_field( array(
		'id'   => 'images',
		'name' => __( 'Flickr image gallery embed', 'techcamp' ),
		'type' => 'textarea_code'
	) );

	$event_box->add_field( array(
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

	$event_box->add_field( array(
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

	$event_box->add_field( array(
		'id'      => 'short_description',
		'name'    => __( 'Short Description', 'techcamp' ),
		'type'    => 'wysiwyg',
		'options' => array(
			'textarea_rows' => 6
		)
	) );

}
add_action( 'cmb2_admin_init', 'techcamp_event_fields' );
