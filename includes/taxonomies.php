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

	register_taxonomy( 'topic', array( 'event', 'outcome', 'post', 'resource' ), array(
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
			'name'                       => 'Regions',
			'singular_name'              => 'Region',
			'search_items'               => 'Search Regions',
			'popular_items'              => 'Popular Regions',
			'all_items'                  => 'All Regions',
			'parent_item'                => 'Parent Region',
			'parent_item_colon'          => 'Parent Region:',
			'edit_item'                  => 'Edit Region',
			'view_item'                  => 'View Region',
			'update_item'                => 'Update Region',
			'add_new_item'               => 'Add New Region',
			'new_item_name'              => 'New Region Name',
			'separate_items_with_commas' => 'Separate regions with commas',
			'add_or_remove_items'        => 'Add or remove regions',
			'choose_from_most_used'      => 'Choose from the most used regions',
			'not_found'                  => 'No regions found',
			'no_terms'                   => 'No regions',
			'items_list_navigation'      => 'Regions list navigation',
			'items_list'                 => 'Regions list'
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_tagcloud'     => false,
		'rewrite'           => array( 'slug' => 'regions' )
	) );

	// participators is a separate taxonomy, though it will have the same terms
	register_taxonomy( 'participator', array( 'event' ), array(
		'labels' => array(
			'name'                       => 'Participating Regions',
			'singular_name'              => 'Participating Region',
			'search_items'               => 'Search Participating Regions',
			'popular_items'              => 'Popular Participating Regions',
			'all_items'                  => 'All Participating Regions',
			'parent_item'                => 'Parent Participating Region',
			'parent_item_colon'          => 'Parent Participating Region:',
			'edit_item'                  => 'Edit Participating Region',
			'view_item'                  => 'View Participating Region',
			'update_item'                => 'Update Participating Region',
			'add_new_item'               => 'Add New Participating Region',
			'new_item_name'              => 'New Participating Region Name',
			'separate_items_with_commas' => 'Separate participating regions with commas',
			'add_or_remove_items'        => 'Add or remove participating regions',
			'choose_from_most_used'      => 'Choose from the most used participating regions',
			'not_found'                  => 'No participating regions found',
			'no_terms'                   => 'No participating regions',
			'items_list_navigation'      => 'Participating regions list navigation',
			'items_list'                 => 'Participating regions list'
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_tagcloud'     => false,
		'rewrite'           => array( 'slug' => 'participating-regions' )
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

	register_taxonomy( 'language', array( 'resource' ), array(
		'labels' => array(
			'name'                       => 'Languages',
			'singular_name'              => 'Language',
			'search_items'               => 'Search Languages',
			'popular_items'              => 'Popular Languages',
			'all_items'                  => 'All Languages',
			'parent_item'                => 'Parent Language',
			'parent_item_colon'          => 'Parent Language:',
			'edit_item'                  => 'Edit Language',
			'view_item'                  => 'View Language',
			'update_item'                => 'Update Language',
			'add_new_item'               => 'Add New Language',
			'new_item_name'              => 'New Language Name',
			'separate_items_with_commas' => 'Separate languages with commas',
			'add_or_remove_items'        => 'Add or remove languages',
			'choose_from_most_used'      => 'Choose from the most used languages',
			'not_found'                  => 'No languages found',
			'no_terms'                   => 'No languages',
			'items_list_navigation'      => 'Languages list navigation',
			'items_list'                 => 'Languages list'
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_tagcloud'     => false,
		'rewrite'           => array( 'slug' => 'languages' )
	) );

	//
	// The following are HIDDEN taxonomies.
	//
	// They are used for various functionality to store data automatically
	// that the user shouldn't have control over.
	//

	// needs prefix because 'year' is reserved by wp and causes a mess of weird rewrite behavior
	register_taxonomy( 'event_year', array( 'event' ), array(
		'labels' => array(
			'name'          => 'Years',
			'singular_name' => 'Year',
		),
		'public' => false
	) );

	/*

	register_taxonomy( 'resource_techcamp', array( 'resource', 'bio' ), array(
		'labels' => array(
			'name'          => 'TechCamps',
			'singular_name' => 'TechCamp',
		),
		'public'       => true,
		'show_ui'      => false,
		'hierarchical' => true,
	) );

	register_taxonomy( 'resource_topic', array( 'resource', 'bio' ), array(
		'labels' => array(
			'name'          => 'TechCamps',
			'singular_name' => 'TechCamp',
		),
		'public'       => true,
		'show_ui'      => false,
		'hierarchical' => true,
	) );

	register_taxonomy( 'resource_country', array( 'resource', 'bio' ), array(
		'labels' => array(
			'name'          => 'TechCamps',
			'singular_name' => 'TechCamp',
		),
		'public'       => true,
		'show_ui'      => false,
		'hierarchical' => true,
	) );

	*/

}
add_action( 'init', 'techcamp_taxonomies', 10 );

/**
 * Additional fields for the Topics taxonomy.
 */
function techcamp_topics_fields() {

	$home_box = new_cmb2_box( array(
		'id'           => 'topic_box',
		'title'        => __( 'Topic Fields', 'techcamp' ),
		'object_types' => array( 'term' ),
		'taxonomies'   => array( 'topic' ),
	) );

	$dir = get_stylesheet_directory_uri() . '/template-parts/topics/';
	$path = get_stylesheet_directory() . '/template-parts/topics/';

	$home_box->add_field( array(
		'id'   => 'icon',
		'name' => __( 'Icon', 'techcamp' ),
		'type' => 'radio',
		'options' => array(
			'communications' => '<style type="text/css">.cmb2-radio-list svg {max-width:100px;max-height:100px;}</style>Communications<br /><br />' . file_get_contents( $path . 'communications.svg.php' ) . '<br /><br />',
			'education'      => 'Education<br /><br />' . file_get_contents( $path . 'education.svg.php' ) . '<br /><br />',
			'elections'      => 'Elections<br /><br />' . file_get_contents( $path . 'elections.svg.php' ) . '<br /><br />',
			'energy'         => 'Energy<br /><br />' . file_get_contents( $path . 'energy.svg.php' ) . '<br /><br />',
			'environment'    => 'Environment<br /><br />' . file_get_contents( $path . 'environment.svg.php' ) . '<br /><br />',
			'governance'     => 'Governance<br /><br />' . file_get_contents( $path . 'governance.svg.php' ) . '<br /><br />',
			'health'         => 'Health<br /><br />' . file_get_contents( $path . 'health.svg.php' ) . '<br /><br />',
			'journalism'     => 'Journalism<br /><br />' . file_get_contents( $path . 'journalism.svg.php' ) . '<br /><br />',
			'opportunity'    => 'Opportunity<br /><br />' . file_get_contents( $path . 'opportunity.svg.php' ) . '<br /><br />',
			'peace'          => 'Peace<br /><br />' . file_get_contents( $path . 'peace.svg.php' ) . '<br /><br />',
			'rights'         => 'Rights<br /><br />' . file_get_contents( $path . 'rights.svg.php' ) . '<br /><br />',
			'security'       => 'Security<br /><br />' . file_get_contents( $path . 'security.svg.php' ) . '<br /><br />',
		),
	) );


}
add_action( 'cmb2_admin_init', 'techcamp_topics_fields' );
