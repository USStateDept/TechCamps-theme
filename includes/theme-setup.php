<?php
/**
 * Initialize Techcamp general theme setup functions.
 *
 * @package techcamp
 */

/**
 * Theme setup.
 */
function techcamp_setup() {

	add_image_size( 'logo', 299, 66, true );
	add_image_size( 'logo-2x', 598, 132, true );
	add_image_size( 'map-thumbnail', 200, 200, true );
	add_image_size( 'inline-big', 1070, 700, true );
	add_image_size( 'surfaced-thumbnail', 391, 300, true );
	add_image_size( 'surfaced-thumbnail-2x', 782, 600, true );
	add_image_size( 'hero', 920, 950, true );
	add_image_size( 'featured', 731, 604, true );
	add_image_size( 'featured-2x', 1462, 1208, true );
	add_image_size( 'inner-hero', 917, 861, true );
	add_image_size( 'icon', 200, 201, false );
	add_image_size( 'icon-2x', 400, 402, false );

	register_nav_menu( 'header-social', 'Header Social' );
	register_nav_menu( 'header-utility', 'Header Utility' );
	register_nav_menu( 'header-sticky-nav', 'Primary in Sticky Header' );
	register_nav_menu( 'footer-navigation', 'Footer Navigation' );
	register_nav_menu( 'footer-social', 'Footer Social' );
	register_nav_menu( 'footer-links', 'Footer Links' );

}
add_action( 'after_setup_theme', 'techcamp_setup' );

/**
 * Enqueue custom styles.
 */
function techcamp_styles() {
	// techcamp/style.css is already added via corona
	wp_dequeue_script( 'corona-js' );
	wp_enqueue_style( 'techcamp-fonts', 'https://fonts.googleapis.com/css?family=Source+Serif+Pro|Glegoo:400,700|Open+Sans:300,400,600,700' );
}
add_action( 'wp_enqueue_scripts', 'techcamp_styles', 11 );

/**
 * Enqueue custom scripts.
 */
function techcamp_scripts() {
	wp_register_script( 'techcamp-autocomplete', get_stylesheet_directory_uri() . '/js/lib/jquery.autocomplete.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'techcamp-scripts', get_stylesheet_directory_uri() . '/js/dist/script.js', array( 'techcamp-autocomplete' ), false, true );
	wp_localize_script( 'techcamp-scripts', 'techcamp_vars', array(
		'content_url' => content_url(),
		'typeaheads'  => techcamp_get_search_suggestions(),
	) );
}
add_action( 'wp_enqueue_scripts', 'techcamp_scripts' );

/**
 * Modify the Corona custom header args.
 */
function techcamp_custom_header_args( $args = array() ) {
	$args['width'] = 598;
	$args['height'] = 132;
	$args['flex-height'] = false;
	return $args;
}
add_filter( 'corona_custom_header_args', 'techcamp_custom_header_args' );

/**
 * Move Yoast SEO's meta boxes below the more important stuff.
 */
function techcamp_yoast_humility( $priority ) {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'techcamp_yoast_humility' );

/**
 * Turn off Yoast SEO's intrusive and irrelevant "Primary Category" functionality.
 */
function techcamp_empty_array() {
	return array();
}
add_filter( 'wpseo_primary_term_taxonomies', 'techcamp_empty_array' );
