<?php
/**
 * Widgetizer class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer;

use Symfony\Component\Finder\Finder;

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
	 * Widgetizer constructor.
	 */
	public function __construct() {

		// Register widgets.
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
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

	}

	/**
	 * Init hooks.
	 */
	public function hooks() {

	}

	/**
	 * Check Elementor plugin installed or not.
	 *
	 * @return bool
	 */
	public function check_elementor() {
		return defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base' );
	}

	/**
	 * Register Elementor widgets.
	 *
	 * @param mixed $widgets_dir Elementor widgets path.
	 */
	public function register_elementor_widgets( $widgets_dir = null ) {

		if ( ! $widgets_dir ) {
			$widgets_dirs = array(
				get_stylesheet_directory() . '/widgets/elementor',
				WPSEED_WIDGETIZER_PATH . '/tests/widgets/elementor',
			);

			foreach ( $widgets_dirs as $dir ) {
				if ( is_dir( $dir ) ) {
					$widgets_dir = $dir;
					break;
				}
			}
		}

		$finder = new Finder();

		$elementor_widgets_providers = $finder->directories()->in( $widgets_dir );

		foreach ( $elementor_widgets_providers as $elementor_widgets_providers_item ) {
			$class_name = 'Wpseed_Widgetizer_Elementor_' . ucfirst( strtolower( str_replace( '-', '_', $elementor_widgets_providers_item->getFileName() ) ) );
			$code       = "class {$class_name} extends Wpseed\Widgetizer\Elementor_Widget{}";
			eval( $code ); // phpcs:ignore
			$widget = new $class_name();
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( $widget );
		}
	}
}
