<?php
/**
 * Widgetizer class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer;

use Wpseed\Widgetizer\Admin\Pages;
use Wpseed\Widgetizer\Elementor\Elementor_Builder;

/**
 * Main initiation plugin class.
 *
 * @since  1.0.0
 */
final class Widgetizer {

	/**
	 * Plugin instance.
	 *
	 * @var null
	 */
	protected static $instance = null;

	/**
	 * Pages class.
	 *
	 * @var Pages Pages class.
	 */
	protected $admin_pages;

	/**
	 * Widgetizer constructor.
	 */
	public function __construct() {
		if ( ! $this->admin_pages ) {
			$this->admin_pages = new Pages();
		}
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Get plugin instance.
	 *
	 * @return null
	 */
	public static function get_instance() {
		if ( ! static::$instance ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * Init plugin.
	 */
	public function init() {
		if ( did_action( 'elementor/loaded' ) ) {
			new Elementor_Builder( is_dir( get_stylesheet_directory() . '/widgets/elementor' ) ? get_stylesheet_directory() . '/widgets/elementor' : WPSEED_WIDGETIZER_PATH . '/widgets/elementor' );
		}
	}
}
