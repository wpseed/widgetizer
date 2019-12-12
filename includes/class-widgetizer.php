<?php
/**
 * Widgetizer class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer;

use Symfony\Component\Finder\Finder;
use Nette\PhpGenerator\ClassType;
use Wpseed\Widgetizer\Admin\Pages;
use Wpseed\Widgetizer\Elementor\Parser;

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
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_categories' ) );
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
	}

	/**
	 * Register elementor categories.
	 *
	 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
	 */
	public function register_elementor_categories( $elements_manager ) {
		$elements_manager->add_category(
			'widgetizer',
			array(
				'title' => __( 'Widgetizer', 'wpseed-widgetizer' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	/**
	 * Register widgets
	 */
	public function register_widgets() {
		$this->register_elementor_widgets( WPSEED_WIDGETIZER_WIDGETS_PATH . '/elementor' );
	}

	/**
	 * Generate widget class
	 *
	 * @param string $class_name  Class name.
	 * @param mixed  $properties  Array of protected widget properties.
	 * @return ClassType $class Generated class
	 */
	public function generate_widget_class( $class_name, $properties ) {
		$class = new ClassType( $class_name );
		$class
			->setFinal()
			->setExtends( 'Wpseed\Widgetizer\Elementor\Widget' );
		foreach ( $properties as $property => $value ) {
			$class
				->addProperty( $property )
				->setValue( $value )
				->setVisibility( 'protected' );
		}
		eval( $class ); //phpcs:ignore
		return $class;
	}

	/**
	 * Register Elementor widgets.
	 *
	 * @param mixed $widgets_dir Elementor widgets path.
	 */
	public function register_elementor_widgets( $widgets_dir = null ) {
		if ( ! is_dir( $widgets_dir ) ) {
			$widgets_dir = is_dir( get_stylesheet_directory() . '/widgets/elementor' ) ? get_stylesheet_directory() . '/widgets/elementor' : WPSEED_WIDGETIZER_PATH . '/widgets/elementor';
		}

		$widgets_parser = new Parser();

		$parsed_data = $widgets_parser->parse_widgets( $widgets_dir );

		foreach ( $parsed_data as $provider_name => $provider_items ) {
			foreach ( $provider_items as $widget_name => $widget_content ) {
				$class_name = 'Wpseed_Widgetizer_Elementor_' . Helpers::dashes_to_class_name( $widget_name );

				$class_properties = array(
					'widget_name'     => $widget_name,
					'widget_title'    => isset( $widget_content['title'] ) ? $widget_content['title'] : $widget_name,
					'widget_provider' => 'widgetizer',
					'widget_icon'     => isset( $widget_content['icon'] ) ? $widget_content['icon'] : 'eicon-code',
					'template_path'   => $widgets_dir . '/' . $provider_name . '/' . $widget_name,
				);
				$this->generate_widget_class( $class_name, $class_properties );
				$widget_object = new $class_name();
				\Elementor\Plugin::instance()->widgets_manager->register_widget_type( $widget_object );
			}
		}
	}
}
