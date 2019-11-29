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
	 * Register widgets.
	 */
	public function register_widgets() {

		$finder = new Finder();

		$elementor_widgets = $finder->directories()->in( WP_CONTENT_DIR . '/widgets/elementor/widgetizer' );

		foreach ( $elementor_widgets as $elementor_widget ) {
			$class_name = 'Wpseed_Widgetizer_Elementor_' . ucfirst( strtolower( str_replace( '-', '_', $elementor_widget->getFileName() ) ) );
			$code       = "class {$class_name} extends Wpseed\Widgetizer\Elementor_Widget{}";
			eval( $code ); // phpcs:ignore
			$widget = new $class_name();
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( $widget );
		}
	}
}
