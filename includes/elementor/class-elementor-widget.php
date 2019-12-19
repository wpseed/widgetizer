<?php
/**
 * Elementor widget class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer\Elementor;

use Latte\Engine;
use Nette\Neon\Neon;
use Nette\Utils\FileSystem;

/**
 * Elementor Widget class
 *
 * Class Elementor_Widget
 *
 * @package Wpseed\Widgetizer
 */
class Elementor_Widget extends \Elementor\Widget_Base {

	/**
	 * Widget provider
	 *
	 * @var $widget_provider
	 */
	protected $widget_provider;

	/**
	 * Widget name
	 *
	 * @var $widget_name
	 */
	protected $widget_name;

	/**
	 * Widget title
	 *
	 * @var $widget_title
	 */
	protected $widget_title;

	/**
	 * Widget icon
	 *
	 * @var string $widget_icon widget icon
	 */
	protected $widget_icon;

	/**
	 * Widget styles
	 *
	 * @var string $widget_icon Widget styles.
	 */
	protected $widget_styles;

	/**
	 * Widget scripts
	 *
	 * @var string $widget_scripts Widget scripts.
	 */
	protected $widget_scripts;

	/**
	 * Base path of widget
	 *
	 * @var string $widget_path Widget path.
	 */
	protected $widget_path;

	/**
	 * Widget config
	 *
	 * @var mixed $widget_config Widget config.
	 */
	protected $widget_config;

	/**
	 * Get widget categories
	 *
	 * @return array
	 */
	public function get_categories() {
		return array( $this->widget_provider );
	}

	/**
	 * Get widget name
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->widget_provider . '-' . $this->widget_name;
	}

	/**
	 * Get widget title
	 *
	 * @return mixed
	 */
	public function get_title() {
		return $this->widget_title;
	}

	/**
	 * Get widget icon
	 *
	 * @return string
	 */
	public function get_icon() {
		return $this->widget_icon;
	}

	/**
	 * Widget styles array
	 *
	 * @return array Array of widget styles.
	 */
	public function get_style_depends() {
		return $this->widget_styles;
	}

	/**
	 * Widget scripts array
	 *
	 * @return array Array of widget scripts.
	 */
	public function get_script_depends() {
		return $this->widget_scripts;
	}

	/**
	 * Register widget controls
	 */
	protected function _register_controls() { // phpcs:ignore
		$widget_config  = $this->widget_config;
		$widget_content = array_key_exists( 'content', $widget_config ) ? $widget_config['content'] : array();
		foreach ( $widget_content as $widget_content_item_index => $widget_content_item_value ) {
			$this->start_controls_section(
				'section_' . $widget_content_item_index,
				array(
					'label' => esc_html( $widget_content_item_index ),
				)
			);

			if ( is_array( $widget_content_item_value ) ) {
				foreach ( $widget_content_item_value as $widget_content_subitem_index => $widget_content_subitem_value ) {
					$this->add_control( $widget_content_subitem_index, $widget_content_subitem_value );
				}
			}

			$this->end_controls_section();
		}
	}

	/**
	 * Render widget
	 */
	protected function render() {
		$latte         = new Engine();
		$parameters    = array(
			'content' => $this->get_settings_for_display(),
		);
		$template_file = $this->widget_path . '/' . $this->widget_name . '.latte';
		if ( is_readable( $template_file ) ) {
			$html = $latte->renderToString( $this->widget_path . '/' . $this->widget_name . '.latte', $parameters );
			echo $html; // phpcs:ignore
		}
	}
}
