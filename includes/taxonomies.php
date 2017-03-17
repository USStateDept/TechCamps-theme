<?php
/**
 * Techcamp custom taxonomy registry.
 *
 * @package techcamp
 */

/**
 * Register each taxonomy, hooked to init.
 */
function techcamp_taxonomies() {

	register_taxonomy( 'topic', array( 'event', 'outcome', 'resource', 'post' ), array(
		'labels' => array(
			'name'                       => 'Topics',
			'singular_name'              => 'Topic',
			'search_items'               => 'Search Topics',
			'popular_items'              => 'Popular Topics',
			'all_items'                  => 'All Topics',
			'parent_item'                => 'Parent Topic',
			'parent_item_colon'          => 'Parent Topic:',
			'edit_item'                  => 'Edit Topic',
			'view_item'                  => 'View Topic',
			'update_item'                => 'Update Topic',
			'add_new_item'               => 'Add New Topic',
			'new_item_name'              => 'New Topic Name',
			'separate_items_with_commas' => 'Separate topics with commas',
			'add_or_remove_items'        => 'Add or remove topics',
			'choose_from_most_used'      => 'Choose from the most used topics',
			'not_found'                  => 'No topics found',
			'no_terms'                   => 'No topics',
			'items_list_navigation'      => 'Topics list navigation',
			'items_list'                 => 'Topics list'
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_tagcloud'     => false,
		'rewrite'           => array( 'slug' => 'topics' )
	) );

	register_taxonomy( 'country', array( 'event', 'outcome' ), array(
		'labels' => array(
			'name'                       => 'Countries',
			'singular_name'              => 'Country',
			'search_items'               => 'Search Countries',
			'popular_items'              => 'Popular Countries',
			'all_items'                  => 'All Countries',
			'parent_item'                => 'Parent Country',
			'parent_item_colon'          => 'Parent Country:',
			'edit_item'                  => 'Edit Country',
			'view_item'                  => 'View Country',
			'update_item'                => 'Update Country',
			'add_new_item'               => 'Add New Country',
			'new_item_name'              => 'New Country Name',
			'separate_items_with_commas' => 'Separate countries with commas',
			'add_or_remove_items'        => 'Add or remove countries',
			'choose_from_most_used'      => 'Choose from the most used countries',
			'not_found'                  => 'No countries found',
			'no_terms'                   => 'No countries',
			'items_list_navigation'      => 'Countries list navigation',
			'items_list'                 => 'Countries list'
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_tagcloud'     => false,
		'rewrite'           => array( 'slug' => 'countries' )
	) );

	// participating countries is a separate taxonomy, though it will have the same terms
	register_taxonomy( 'participator', array( 'event' ), array(
		'labels' => array(
			'name'                       => 'Participating Countries',
			'singular_name'              => 'Participating Country',
			'search_items'               => 'Search Participating Countries',
			'popular_items'              => 'Popular Participating Countries',
			'all_items'                  => 'All Participating Countries',
			'parent_item'                => 'Parent Participating Country',
			'parent_item_colon'          => 'Parent Participating Country:',
			'edit_item'                  => 'Edit Participating Country',
			'view_item'                  => 'View Participating Country',
			'update_item'                => 'Update Participating Country',
			'add_new_item'               => 'Add New Participating Country',
			'new_item_name'              => 'New Participating Country Name',
			'separate_items_with_commas' => 'Separate participating countries with commas',
			'add_or_remove_items'        => 'Add or remove participating countries',
			'choose_from_most_used'      => 'Choose from the most used participating countries',
			'not_found'                  => 'No participating countries found',
			'no_terms'                   => 'No participating countries',
			'items_list_navigation'      => 'Participating countries list navigation',
			'items_list'                 => 'Participating countries list'
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_tagcloud'     => false,
		'rewrite'           => array( 'slug' => 'countries' )
	) );

	register_taxonomy( 'resource_type', array( 'resource' ), array(
		'labels' => array(
			'name'                       => 'Resource Types',
			'singular_name'              => 'Resource Type',
			'search_items'               => 'Search Resource Types',
			'popular_items'              => 'Popular Resource Types',
			'all_items'                  => 'All Resource Types',
			'parent_item'                => 'Parent Resource Type',
			'parent_item_colon'          => 'Parent Resource Type:',
			'edit_item'                  => 'Edit Resource Type',
			'view_item'                  => 'View Resource Type',
			'update_item'                => 'Update Resource Type',
			'add_new_item'               => 'Add New Resource Type',
			'new_item_name'              => 'New Resource Type Name',
			'separate_items_with_commas' => 'Separate resource types with commas',
			'add_or_remove_items'        => 'Add or remove resource types',
			'choose_from_most_used'      => 'Choose from the most used resource types',
			'not_found'                  => 'No resource types found',
			'no_terms'                   => 'No resource types',
			'items_list_navigation'      => 'Resource Types list navigation',
			'items_list'                 => 'Resource Types list'
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_tagcloud'     => false,
		'rewrite'           => array( 'slug' => 'resource-types' )
	) );

}
add_action( 'init', 'techcamp_taxonomies', 10 );