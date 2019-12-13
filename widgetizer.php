<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * Plugin Name: Widgetizer
 * Plugin URI:  https://github.com/wpseed/widgetizer
 * Description: Widgets Generator for Page Builders.
 * Version:     1.0.0
 * Author:      WP Seed
 * Author URI:  https://wpseed.io/
 * Donate link: https://wpseed.io/donate/
 * License:     GPLv2
 *
 * Text Domain: wpseed-widgetizer
 * Domain Path: /languages
 *
 * @link    https://wpseed.io/
 *
 * @package Widgetizer
 * @version 1.0.0
 */

/**
 * Currently plugin version.
 * Starts at version 1.0.0 and uses SemVer - https://semver.org
 */
define( 'WPSEED_WIDGETIZER_VERSION', '1.0.0' );

/**
 * Minimum required php version.
 */
define( 'WPSEED_WIDGETIZER_MIN_PHP_VERSION', '5.6.20' );

/**
 * Path to the plugin dir.
 */
define( 'WPSEED_WIDGETIZER_PATH', __DIR__ );


/**
 * Base path of the plugin.
 */
define( 'WPSEED_WIDGETIZER_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Url of the plugin dir.
 */
define( 'WPSEED_WIDGETIZER_URL', plugin_dir_url( __FILE__ ) );

/**
 * Base path of the marketplace widgets dir.
 */
define( 'WPSEED_WIDGETIZER_MARKETPLACE_WIDGETS_PATH', WP_CONTENT_DIR . '/widgets' );

/**
 * Url of the marketplace widgets dir.
 */
define( 'WPSEED_WIDGETIZER_MARKETPLACE_WIDGETS_URL', WP_CONTENT_URL . '/widgets' );

/**
 * Load vendor packages.
 */
require_once WPSEED_WIDGETIZER_PATH . '/vendor/autoload.php';

// Kick it off.
add_action( 'plugins_loaded', array( \Wpseed\Widgetizer\Widgetizer::get_instance(), 'init' ) );
