<?php
/**
 * Widgetizer class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer;

use Wpseed\Widgetizer\Elementor\Elementor_Builder;
use Wpseed\Widgetizer\Rest_Api\Rest_Api_Widgets_Controller;

/**
 * Main initiation plugin class
 *
 * @since  1.0.0
 */
final class Widgetizer {

	/**
	 * Plugin instance
	 *
	 * @var Widgetizer|null $instance Widgetizer instance.
	 */
	protected static $instance = null;

	/**
	 * Elementor builder
	 *
	 * @var $elementor_builder
	 */
	protected $elementor_builder = null;

	/**
	 * Pages class.
	 *
	 * @var Pages Pages class
	 */
	protected $admin_pages = null;

	/**
	 * Widgetizer constructor
	 */
	public function __construct() {
		if ( ! $this->admin_pages ) {
			$this->admin_pages = new Admin();
		}
		$this->init_hooks();
	}

	/**
	 * Get plugin instance
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
	 * Init plugin
	 */
	public function init() {
		if ( did_action( 'elementor/loaded' ) ) {
			$this->elementor_builder = new Elementor_Builder(
				array(
					WPSEED_WIDGETIZER_PATH . '/widgets/elementor',
					WP_CONTENT_DIR . '/widgets/elementor',
					get_stylesheet_directory() . '/widgetizer/elementor',
				)
			);
			$this->elementor_builder->init();
		}
	}

	private function init_hooks() {
		add_action( 'rest_api_init', array( $this, 'create_rest_api_routes' ) );
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	public function create_rest_api_routes() {
		$rest_api_widgets = new Rest_Api_Widgets_Controller();
		$rest_api_widgets->register_routes();
	}
}
