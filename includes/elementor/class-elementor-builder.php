<?php
/**
 * Elementor widgets builder class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer\Elementor;

use Nette\Neon\Neon;
use Nette\PhpGenerator\ClassType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Wpseed\Widgetizer\Helpers;
use Wpseed\Widgetizer\Validate;

/**
 * Class Elementor_Builder
 *
 * @package Wpseed\Widgetizer\Elementor
 */
class Elementor_Builder {

	/**
	 * Elementor widgets directory.
	 *
	 * @var string|null
	 */
	protected $dir;

	/**
	 * Elementor widgets config.
	 *
	 * @var array $config Global config.
	 */
	protected $config;

	/**
	 * Elementor_Builder constructor.
	 *
	 * @param string|null $dir Elementor widgets directory.
	 */
	public function __construct( $dir = null ) {
		$this->dir    = $dir;
		$this->config = $this->parse_config( $dir );
	}

	/**
	 * Initialize builder.
	 */
	public function init() {
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_assets' ) );
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_categories' ) );
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
	}

	/**
	 * Get current widgets config.
	 *
	 * @return array
	 */
	public function get_config() {
		return $this->config;
	}

	/**
	 * Parse widgets from directory.
	 *
	 * @param string $dir Directory for parsing widget configs.
	 * @return array $output Output summary config.
	 */
	public function parse_config( $dir = null ) {
		$output         = array();
		$fs             = new Filesystem();
		$neon           = new Neon();
		$folders_finder = new Finder();
		$folders        = $folders_finder->directories()->in( $dir )->depth( '== 0' )->sortByName();
		foreach ( $folders as $folders_item ) {
			$current_provider            = $folders_item->getFileName();
			$output[ $current_provider ] = false;
			if ( Validate::name( $current_provider ) ) {
				$subfolders_finder           = new Finder();
				$subfolders                  = $subfolders_finder->directories()->in( $dir . '/' . $current_provider )->depth( '== 0' )->sortByName();
				$output[ $current_provider ] = array();
				if ( iterator_count( $subfolders ) ) {
					foreach ( $subfolders as $subfolders_item ) {
						$current_widget                                 = $subfolders_item->getFileName();
						$output[ $current_provider ][ $current_widget ] = array();
						if ( Validate::name( $current_widget ) ) {
							$current_widget_config_path = $dir . '/' . $current_provider . '/' . $current_widget . '/' . $current_widget . '.neon';
							if ( $fs->exists( $current_widget_config_path ) ) {
								$current_widget_config                          = $neon::decode( \Nette\Utils\FileSystem::read( $current_widget_config_path ) );
								$output[ $current_provider ][ $current_widget ] = $current_widget_config;
							}
						}
					};
				}
			}
		}
		return $output;
	}

	/**
	 * Parse assets.
	 *
	 * @param null $dir Elementor widgets directory.
	 *
	 * @return array
	 */
	public function parse_assets( $dir = null ) {
		$output = array();
		return $output;
	}


	/**
	 * Generate widget class
	 *
	 * @param string $class_name Class name.
	 * @param mixed  $properties Array of protected widget properties.
	 * @return ClassType $class Generated class
	 */
	public function generate_widget_class( $class_name, $properties ) {
		$class = new ClassType( $class_name );
		$class
			->setFinal()
			->setExtends( 'Wpseed\Widgetizer\Elementor\Elementor_Widget' );
		foreach ( $properties as $property => $value ) {
			$class
				->addProperty( $property )
				->setValue( $value )
				->setVisibility( 'protected' );
		}
		eval($class); //phpcs:ignore
		return $class;
	}

	/**
	 * Register widgets assets.
	 */
	public function register_assets() {}

	/**
	 * Register Elementor categories.
	 *
	 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
	 */
	public function register_categories( $elements_manager ) {
		$elements_manager->add_category(
			'widgetizer',
			array(
				'title' => __( 'Widgetizer', 'wpseed-widgetizer' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	/**
	 * Register widgets.
	 */
	public function register_widgets() {
		foreach ( $this->config as $provider_name => $provider_items ) {
			foreach ( $provider_items as $widget_name => $widget_content ) {
				$class_name       = 'Wpseed_Widgetizer_Elementor_' . Helpers::dashes_to_class_name( $provider_name . '-' . $widget_name );
				$class_properties = array(
					'widget_name'     => $widget_name,
					'widget_title'    => isset( $widget_content['title'] ) ? $widget_content['title'] : $widget_name,
					'widget_provider' => 'widgetizer',
					'widget_icon'     => isset( $widget_content['icon'] ) ? $widget_content['icon'] : 'eicon-code',
					'template_path'   => $this->dir . '/' . $provider_name . '/' . $widget_name,
				);
				$this->generate_widget_class( $class_name, $class_properties );
				$widget_object = new $class_name();
				\Elementor\Plugin::instance()->widgets_manager->register_widget_type( $widget_object );
			}
		}
	}
}
