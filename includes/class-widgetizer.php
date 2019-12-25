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
			$this->admin_pages = new Pages();
		}
		add_action( 'plugins_loaded', array( $this, 'init' ) );
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
		add_action( 'rest_api_init', array( $this, 'register_api' ) );
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
	
	/**
	 * Register API
	 */
	public function register_api() {
		$api_namespace = 'widgetizer/v1';

		register_rest_route(
			$api_namespace,
			'/widgets/',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_all_widgets' ),
				'permission_callback' => function () {
					$user       = wp_get_current_user();
					$role_check = in_array( 'administrator', $user->roles, true ) + in_array( 'editor', $user->roles, true );
					if ( ! $role_check ) {
						return false;
					}
					return true;
				},
			)
		);
	}

	/**
	 * Get all widgets
	 *
	 * @return array $widgets All widgets.
	 */
	public function get_all_widgets() {
		$widgets_parser = new Elementor_Builder(
			array(
				WPSEED_WIDGETIZER_PATH . '/widgets/elementor',
				WP_CONTENT_DIR . '/widgets/elementor',
				get_stylesheet_directory() . '/widgetizer/elementor',
			)
		);
		$widgets        = $widgets_parser->get_widgets();
		return $widgets;
	}
}
