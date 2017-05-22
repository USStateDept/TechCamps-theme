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

	/**
	 * We add 2x thumbnails here so WP generates them, but when using them in the
	 * theme we only use the non-2x version. WP will create responsive image tags
	 * that will automatically use the 2x version when appropriate.
	 *
	 * We don't create 2x of the larger sizes because those tend to display pretty
	 * well on Retina, it slows things down, and often the original image won't be
	 * large enough anyway.
	 */
	add_image_size( 'hero',              920, 861, true );			// big tall hero image
	add_image_size( 'inline',            1070, 700, true );			// large images in post content
	add_image_size( 'featured',          731, 604, true );			// featured post section of landing pages
	add_image_size( 'icon',              200, 201, false );			// topic icons - no hard cropping
	add_image_size( 'icon-2x',           400, 402, false );
	add_image_size( 'portrait',          276, 273, true );			// trainer portraits
	add_image_size( 'portrait-2x',       552, 546, true );;
	add_image_size( 'map-thumb',         200, 200, true );			// inside map info boxes
	add_image_size( 'map-thumb-2x',      400, 400, true );
	add_image_size( 'archive-thumb',     600, 300, true );			// thumbnail in archive pages
	add_image_size( 'archive-thumb-2x',  1200, 600, true );
	add_image_size( 'surfaced-thumb',    391, 300, true );			// thumbnail in footer surfaced posts
	add_image_size( 'surfaced-thumb-2x', 782, 600, true );
	add_image_size( 'banner',            1400, 579, true );			// page header banner images behind color overlay

	register_nav_menu( 'header-social',     'Header Social' );
	register_nav_menu( 'header-utility',    'Header Utility' );
	register_nav_menu( 'header-sticky-nav', 'Primary in Sticky Header' );
	register_nav_menu( 'footer-navigation', 'Footer Navigation' );
	register_nav_menu( 'footer-social',     'Footer Social' );
	register_nav_menu( 'footer-links',      'Footer Links' );

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
