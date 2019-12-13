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
		$config_file = $this->widget_path . '/' . $this->widget_name . '.neon';
		if ( ! is_readable( $config_file ) ) {
			return false;
		}
		$value    = FileSystem::read( $config_file );
		$neon     = Neon::decode( $value );
		$controls = $neon['content'];

		foreach ( $controls as $controls_item_index => $control_item_value ) {
			$this->start_controls_section(
				'section_' . $controls_item_index,
				array(
					'label' => esc_html( $controls_item_index ),
				)
			);

			foreach ( $control_item_value as $control_subitem_index => $control_subitem_value ) {
				$this->add_control( $control_subitem_index, $control_subitem_value );
			}

			$this->end_controls_section();
		}
	}

	/**
	 * Render widget
	 */
	protected function render() {
		$latte      = new Engine();
		$parameters = array(
			'content' => $this->get_settings_for_display(),
		);
		$html       = $latte->renderToString( $this->widget_path . '/' . $this->widget_name . '.latte', $parameters );
		echo $html; // phpcs:ignore
	}
}
