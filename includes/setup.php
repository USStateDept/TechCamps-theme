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

	register_nav_menu( 'header-social', 'Header Social' );
	register_nav_menu( 'header-utility', 'Header Utility' );
	register_nav_menu( 'footer-navigation', 'Footer Navigation' );
	register_nav_menu( 'footer-social', 'Footer Social' );
	register_nav_menu( 'footer-links', 'Footer Links' );

}
add_action( 'after_setup_theme', 'techcamp_setup' );

/**
 * We incorporate Corona styles into our own styles, so we can remove
 * the separate enqueue to avoid loading another CSS file.
 */
remove_action( 'wp_enqueue_scripts', 'corona_styles' );

/**
 * Enqueue custom styles.
 */
function techcamp_styles() {
	wp_enqueue_style( 'techcamp-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'techcamp_styles' );

/**
 * Enqueue custom scripts.
 */
function techcamp_scripts() {
	wp_enqueue_style( 'techcamp-fonts', 'https://fonts.googleapis.com/css?family=Source+Serif+Pro|Glegoo:400,700|Open+Sans:300,400,600,700' );
	wp_enqueue_script( 'techcamp-scripts', get_stylesheet_directory_uri() . '/js/dist/script.js', false, true );
	wp_localize_script( 'techcamp-scripts', 'techcamp_vars', array(
		'content_url' => content_url()
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
