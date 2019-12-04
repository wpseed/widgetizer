<?php
/**
 * Elementor_Widget class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer\Elementor;

use Latte\Engine;
use Nette\Neon\Exception;
use Nette\Neon\Neon;
use Nette\Utils\FileSystem;
use Symfony\Component\Yaml\Yaml;

/**
 * Elementor Widget class.
 *
 * Class Elementor_Widget
 *
 * @package Wpseed\Widgetizer
 */
class Widget extends \Elementor\Widget_Base {

	/**
	 * Widget provider.
	 *
	 * @var $widget_provider
	 */
	protected $widget_provider;

	/**
	 * Widget name.
	 *
	 * @var $widget_name
	 */
	protected $widget_name;

	/**
	 * Basepath of widget template directory
	 *
	 * @var string $template_path Template path.
	 */
	protected $template_path;

	/**
	 * Get widget provider.
	 *
	 * @return string
	 */
	public function get_provider() {
		return $this->widget_provider;
	}

	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->widget_name;
	}

	/**
	 * Get widget title.
	 *
	 * @return mixed
	 */
	public function get_title() {
		return $this->widget_title;
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-code';
	}

	/**
	 * Register widget controls.
	 */
	protected function _register_controls() { // phpcs:ignore
		$value    = FileSystem::read( $this->template_path . '/' . $this->widget_name . '.neon' );
		do_action('logger', $value);
		$neon     = Neon::encode( $value );
		$controls = $neon['controls'];

		foreach ( $controls as $controls_item_index => $control_item_value ) {
			$this->start_controls_section(
				'section_' . $controls_item_index,
				array(
					'label' => esc_html( $controls_item_index ),
				)
			);

			foreach ( $control_item_value as $control_subitem_index => $control_subitem_value ) {
				$this->add_control(
					'text',
					array(
						'label' => 'Text',
						'type'  => \Elementor\Controls_Manager::TEXT,
					)
				);
			}

			$this->end_controls_section();
		}
	}

	/**
	 * Render widget.
	 */
	protected function render() {
		$latte      = new Engine();
		$parameters = array(
			'settings' => $this->get_settings_for_display(),
		);
		$html       = $latte->renderToString( $this->template_path . '/' . $this->widget_name . '.latte', $parameters );
		echo $html; // phpcs:ignore
	}
}
