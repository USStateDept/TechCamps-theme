<?php
/**
 * Initialize Techcamp functions.
 *
 * @package techcamp
 */

/**
 * Run general theme setup functions such as enqueues.
 */
require_once( __DIR__ . '/includes/theme-setup.php' );

/**
 * Load custom theme template tags.
 */
require_once( __DIR__ . '/includes/template-tags.php' );

/**
 * Load general action and filter hooks.
 */
require_once( __DIR__ . '/includes/hooks.php' );

/**
 * Load all theme hooks containing templating.
 */
require_once( __DIR__ . '/includes/theme-hooks.php' );

/**
 * Add a parent class for creating options pages.
 */
require_once( __DIR__ . '/includes/options-pages.php' );

/**
 * Site-wide general options.
 */
require_once( __DIR__ . '/includes/site-options.php' );

/**
 * Load post type-related functionality.
 */
require_once( __DIR__ . '/includes/pages/config.php' );

require_once( __DIR__ . '/includes/events/config.php' );
require_once( __DIR__ . '/includes/events/hooks.php' );
require_once( __DIR__ . '/includes/events/options-page.php' );

require_once( __DIR__ . '/includes/outcomes/config.php' );
require_once( __DIR__ . '/includes/outcomes/options-page.php' );

require_once( __DIR__ . '/includes/resources/config.php' );
require_once( __DIR__ . '/includes/resources/options-page.php' );
require_once( __DIR__ . '/includes/resources/resource-library.php' );

require_once( __DIR__ . '/includes/bios/config.php' );
require_once( __DIR__ . '/includes/bios/options-page.php' );

require_once( __DIR__ . '/includes/posts/config.php' );
require_once( __DIR__ . '/includes/posts/hooks.php' );
require_once( __DIR__ . '/includes/posts/options-page.php' );

/**
 * Register custom taxonomies.
 */
require_once( __DIR__ . '/includes/taxonomies.php' );

/**
 * Register custom connection types with the Posts to Posts plugin.
 */
require_once( __DIR__ . '/includes/connections.php' );

/**
 * Run custom functions and hooks for Map section.
 */
require_once( __DIR__ . '/includes/map.php' );
