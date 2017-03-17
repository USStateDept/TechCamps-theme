<?php
/**
 * Initialize Techcamp functions.
 *
 * @package techcamp
 */

/**
 * Run general theme setup functions such as enqueues.
 */
require_once( __DIR__ . '/includes/setup.php' );

/**
 * Load all theme hooks containing templating.
 */
require_once( __DIR__ . '/includes/theme-hooks.php' );

/**
 * Register custom post types and fields.
 */
require_once( __DIR__ . '/includes/post-types/events.php' );
require_once( __DIR__ . '/includes/post-types/outcomes.php' );
require_once( __DIR__ . '/includes/post-types/resources.php' );
require_once( __DIR__ . '/includes/post-types/bios.php' );
require_once( __DIR__ . '/includes/post-types/posts.php' );

/**
 * Register custom taxonomies.
 */
require_once( __DIR__ . '/includes/taxonomies.php' );

/**
 * Register custom connection types with the Posts to Posts plugin.
 */
require_once( __DIR__ . '/includes/connections.php' );

/**
 * Run custom map functions and hooks.
 */
require_once( __DIR__ . '/includes/map.php' );
