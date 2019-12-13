<?php
/**
 * Pages class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer\Admin;

use Latte\Engine;
use Wpseed\Widgetizer\Elementor\Elementor_Builder;
use Wpseed\Widgetizer\Elementor\Parser;

/**
 * Class Pages
 *
 * @package Wpseed\Widgetizer\Admin
 */
class Pages {

	/**
	 * Engine class.
	 *
	 * @var Engine Engine class.
	 */
	private $latte;

	/**
	 * Pages constructor.
	 */
	public function __construct() {
		$this->latte = new Engine();
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Init.
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'add_main_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	/**
	 * Add main admin page.
	 */
	public function add_main_page() {
		$page_title = __( 'Widgetizer', 'wpseed-widgetizer' );
		$menu_title = __( 'Widgetizer', 'wpseed-widgetizer' );
		$capability = 'manage_options';
		$slug       = 'widgetizer';
		add_menu_page( $page_title, $menu_title, $capability, $slug, array( $this, 'main_page' ), 'dashicons-welcome-widgets-menus' );
	}

	/**
	 * Render main admin page.
	 */
	public function main_page() {
		$template       = WPSEED_WIDGETIZER_PATH . '/admin/templates/main.latte';
		$widgets_parser = new Elementor_Builder(
			array(
				WPSEED_WIDGETIZER_PATH . '/widgets/elementor',
				WP_CONTENT_DIR . '/widgets/elementor',
				get_stylesheet_directory() . '/widgetizer/elementor',
			)
		);
		$widgets_config = $widgets_parser->get_config();
		$parameters     = array(
			'widgets_config' => $widgets_config,
		);
		$this->latte->render( $template, $parameters );
	}

	/**
	 * Enqueue admin scripts.
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_script(
			'wpseed-widgetizer-admin',
			WPSEED_WIDGETIZER_URL . '/admin/assets/scripts/wpseed-widgetizer-admin.js',
			array(),
			WPSEED_WIDGETIZER_VERSION,
			true
		);
		wp_enqueue_style(
			'wpseed-widgetizer-admin',
			WPSEED_WIDGETIZER_URL . '/admin/assets/styles/wpseed-widgetizer-admin.css',
			array(),
			WPSEED_WIDGETIZER_VERSION
		);
	}
}
