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
		add_action( 'plugins_loaded', [ $this, 'init' ] );
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
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
	}

	public function register_widgets() {
		$this->register_elementor_widgets( WPSEED_WIDGETIZER_WIDGETS_PATH . '/elementor');
	}

	/**
	 * Register Elementor widgets.
	 *
	 * @param mixed $widgets_dir Elementor widgets path.
	 */
	public function register_elementor_widgets( $widgets_dir = null ) {
		if ( ! $widgets_dir ) {
			return;
		}
		$finder = new Finder();
		$elementor_widgets_providers = $finder->directories()->in( $widgets_dir )->depth('== 0');
		$deb = array();
		$filenames = array();
		foreach ( $elementor_widgets_providers as $elementor_widgets_providers_item ) {
			$subFinder = new Finder();
			$widgets = $subFinder->directories()->in($widgets_dir . '/' . $elementor_widgets_providers_item->getFileName())->depth('== 0');
			foreach ($widgets as $currentWidget) {
				$class_name = 'Wpseed_Widgetizer_Elementor_' . ucfirst( strtolower( str_replace( '-', '_', $currentWidget->getFileName() ) ) );
				$code       = "class {$class_name} extends Wpseed\Widgetizer\Elementor\Widget{}";
				eval( $code ); 
				$widgetObject = new $class_name(); //phpcs:ignore
				$widgetObject->set_properties( $currentWidget->getFileName(), $widgets_dir . '/' . $elementor_widgets_providers_item->getFileName() . '/' . $currentWidget->getFileName() );
				\Elementor\Plugin::instance()->widgets_manager->register_widget_type( $widgetObject );
			}
			$name = $elementor_widgets_providers_item->getFileName();
		}
	}
}
