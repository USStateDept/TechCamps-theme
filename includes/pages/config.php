<?php
/**
 * TechCamp page fields.
 *
 * Usually for specific contexts - home fields, landing page fields, etc.
 *
 * @package techcamp
 */

/**
 * Register a metabox and fields for the homepage.
 */
function techcamp_homepage_fields() {

	$home_box = new_cmb2_box( array(
		'id'           => 'home_box',
		'title'        => __( 'Homepage Fields', 'techcamp' ),
		'object_types' => array( 'page' ),
		'show_on_cb'   => 'techcamp_show_on_homepage_only'
	) );

	$home_box->add_field( array(
		'id'   => 'hero_text',
		'name' => __( 'Hero Text', 'techcamp' ),
		'type' => 'textarea'
	) );

	$home_box->add_field( array(
		'id'   => 'topics_intro',
		'name' => __( 'Topics Intro Text', 'techcamp' ),
		'type' => 'textarea'
	) );

	$home_box->add_field( array(
		'id'         => 'featured_topic_1',
		'name'       => __( 'Featured Topic #1', 'techcamp' ),
		'type'       => 'select',
		'options_cb' => 'techcamp_list_topics',
	) );

	$home_box->add_field( array(
		'id'         => 'featured_topic_2',
		'name'       => __( 'Featured Topic #2', 'techcamp' ),
		'type'       => 'select',
		'options_cb' => 'techcamp_list_topics',
	) );

	$home_box->add_field( array(
		'id'         => 'featured_topic_3',
		'name'       => __( 'Featured Topic #3', 'techcamp' ),
		'type'       => 'select',
		'options_cb' => 'techcamp_list_topics',
	) );

}
add_action( 'cmb2_admin_init', 'techcamp_homepage_fields' );

/**
 * Register a metabox and fields for landing pages.
 */
function techcamp_landing_page_fields() {

	$landing_box = new_cmb2_box( array(
		'id'           => 'landing_box',
		'title'        => __( 'Landing Page Fields', 'techcamp' ),
		'object_types' => array( 'page' ),
		'show_on'      => array( 'key' => 'page-template', 'value' => 'page-templates/landing-page.php' ),
	) );

	$landing_box->add_field( array(
		'id'         => 'landing_type',
		'desc'       => 'This controls the type of content that appears on this page.',
		'name'       => __( 'Landing Page Post Type', 'techcamp' ),
		'type'       => 'select',
		'options_cb' => 'techcamp_list_post_types',
	) );

	$landing_box->add_field( array(
		'id'      => 'hero_text',
		'name'    => __( 'Hero Text', 'techcamp' ),
		'type'    => 'textarea',
		'default' => '<h1>Heading here</h1>' . "\r\n" . '<p>Description here</p>',
	) );

	$landing_box->add_field( array(
		'id'      => 'search_label',
		'name'    => __( 'Search Label', 'techcamp' ),
		'type'    => 'text',
		'default' => 'Explore by Topic, Region&hellip;'
	) );

	$landing_box->add_field( array(
		'id'      => 'topic_label',
		'name'    => __( 'Topic Label', 'techcamp' ),
		'type'    => 'text',
		'default' => 'Explore by Topic',
	) );

	$landing_box->add_field( array(
		'id'         => 'secondary_landing_type',
		'desc'       => 'This controls the featured item and "Learn More" CTA near the bottom of the page.',
		'name'       => __( 'Secondary Post Type', 'techcamp' ),
		'type'       => 'select',
		'options_cb' => 'techcamp_list_post_types'
	) );

	$landing_box->add_field( array(
		'id'      => 'region_label',
		'name'    => __( 'Region Label', 'techcamp' ),
		'type'    => 'text',
		'default' => 'Explore by Region',
	) );

}
add_action( 'cmb2_admin_init', 'techcamp_landing_page_fields' );

/**
 * Register a metabox and fields for hero pages.
 */
function techcamp_hero_page_fields() {

	$hero_box = new_cmb2_box( array(
		'id'           => 'hero_box',
		'title'        => __( 'Hero Page Fields', 'techcamp' ),
		'object_types' => array( 'page' ),
		'show_on'      => array( 'key' => 'page-template', 'value' => 'page-templates/hero-page.php' ),
	) );

	$hero_box->add_field( array(
		'id'      => 'hero_text',
		'name'    => __( 'Hero Text', 'techcamp' ),
		'type'    => 'textarea',
		'default' => '<h1>Page title here</h1>' . "\r\n" . '<p>Description here</p>',
	) );

}
add_action( 'cmb2_admin_init', 'techcamp_hero_page_fields' );

/**
 * Register a metabox and fields for basic pages.
 */
function techcamp_basic_page_fields() {

	$page_box = new_cmb2_box( array(
		'id'           => 'page_box',
		'title'        => __( 'Page Fields', 'techcamp' ),
		'object_types' => array( 'page' ),
	) );

	$page_box->add_field( array(
		'id'      => 'short_description',
		'name'    => __( 'Short Description', 'techcamp' ),
		'type'    => 'wysiwyg',
		'options' => array(
			'textarea_rows' => 6,
		)
	) );

}
add_action( 'cmb2_admin_init', 'techcamp_basic_page_fields' );

/**
 * Callback to only show a metabox on the homepage.
 */
function techcamp_show_on_homepage_only( $cmb ) {
	if ( $cmb->object_id === get_option( 'page_on_front' ) ) {
		return true;
	}
	return false;
}

/**
 * Callback to list all topics in id => name pairs.
 */
function techcamp_list_topics() {
	$topics = get_terms( array(
		'taxonomy'   => 'topic',
		'hide_empty' => false,
		'fields'     => 'id=>name'
	) );
	return $topics;
}

/**
 * Callback to list all registered post types in slug => label pairs.
 */
function techcamp_list_post_types() {
	$post_types = get_post_types( array( 'public' => true ), 'objects' );
	$options    = array();
	foreach( $post_types as $type ) {
		$options[$type->name] = $type->label;
	}

	return $options;
}
