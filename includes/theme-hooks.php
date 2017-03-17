<?php
/**
 * Load theme hooks.
 *
 * All theme hook templating can be found in the /theme-hooks folder.
 *
 * This file loads them all so those files can focus on the HTML.
 *
 * @package techcamp
 */

/**
 * Register all theme hooks.
 */
function techcamp_load_theme_hooks() {

	$hooks = array(
		'tha_before_html',
			'tha_head_top',
			'tha_head_bottom',
			'tha_body_top',
				'tha_header_before',
					'tha_header_top',
					'tha_header_bottom',
				'tha_header_after',
				'corona_menu_before',
					'corona_menu_top',
					'corona_menu_bottom',
				'corona_menu_after',
				'tha_content_before',
					'tha_content_top',
						'tha_content_while_before',
							'tha_entry_before',
								'tha_entry_top',
									'tha_entry_content_before',
									'tha_entry_content_after',
								'tha_entry_bottom',
								'tha_comments_before',
								'tha_comments_after',
							'tha_entry_after',
						'tha_content_while_after',
					'tha_content_bottom',
				'tha_content_after',
				'tha_sidebars_before',
					'tha_sidebar_top',
					'tha_sidebar_bottom',
					'corona_sidebar_secondary_top',
					'corona_sidebar_secondary_bottom',
				'tha_sidebars_after',
				'tha_footer_before',
					'tha_footer_top',
					'tha_footer_bottom',
				'tha_footer_after',
			'tha_body_bottom'
	);

	foreach( $hooks as $hook ) {
		add_action( $hook, 'techcamp_load_theme_hook' );
	}

}
add_action( 'init', 'techcamp_load_theme_hooks' );

/**
 * Quick-load a theme hook file.
 */
function techcamp_load_theme_hook() {

	// get current action
	$hook = current_action();

	// trim prefix
	if ( substr( $hook, 0, 4 ) === 'tha_' ) {
		$hook = substr( $hook, 4 );
	}
	if ( substr( $hook, 0, 7 ) === 'corona_' ) {
		$hook = substr( $hook, 7 );
	}

	// include file
	$path = get_stylesheet_directory() . '/theme-hooks/' . $hook . '.php';
	if ( file_exists( $path ) ) {
		include( $path );
	}

}
