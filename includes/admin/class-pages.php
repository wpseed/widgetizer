<?php
/**
 * Pages class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer\Admin;

use Latte\Engine;

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
		$template = WPSEED_WIDGETIZER_PATH . '/includes/admin/templates/main.latte';
		$this->latte->render( $template );
	}
}
