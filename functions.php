<?php
/**
 * Initialize Techcamp functions.
 *
 * @package techcamp
 */

/**
 * Register custom post types and fields.
 */
require_once( __DIR__ . '/includes/post-types/events.php' );
require_once( __DIR__ . '/includes/post-types/outcomes.php' );
require_once( __DIR__ . '/includes/post-types/resources.php' );
require_once( __DIR__ . '/includes/post-types/bios.php' );

/**
 * Register custom taxonomies.
 */
require_once( __DIR__ . '/includes/taxonomies.php' );
require_once( __DIR__ . '/includes/connections.php' );