<?php
/**
 * Rest_Api_Widgets_Controller class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer\Rest_Api;

use mysql_xdevapi\Exception;
use WP_REST_Server;
use Symfony\Component\Filesystem\Filesystem;
use Wpseed\Widgetizer\Elementor\Elementor_Builder;

class Rest_Api_Widgets_Controller extends Rest_Api_Controller {

	/**
	 * Constructor.
	 *
	 * @since 4.7.0
	 */
	public function __construct() {
		$this->rest_base = 'widgets';
	}

	/**
	 * Register routes
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/widgets',
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'permissions_check' ),
					'args'                => $this->get_collection_params(),
				),
				'schema' => array( $this, 'get_public_item_schema' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/widgets/(?P<widget_provider>[a-z-]+)/(?P<widget_name>[a-z-]+)',
			array(
				'args'   => array(
					'widget_provider' => array(
						'description' => __( 'Widget provider identifier.' ),
						'type'        => 'string',
					),
					'widget_name'     => array(
						'description' => __( 'Widget name identifier.' ),
						'type'        => 'string',
					),
				),
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_item' ),
					'permission_callback' => array( $this, 'permissions_check' ),
					'args'                => $this->get_collection_params(),
				),
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'create_item' ),
					'permission_callback' => array( $this, 'permissions_check' ),
					'args'                => $this->get_collection_params(),
				),
				array(
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'update_item' ),
					'permission_callback' => array( $this, 'permissions_check' ),
					'args'                => $this->get_collection_params(),
				),
				array(
					'methods'             => WP_REST_Server::DELETABLE,
					'callback'            => array( $this, 'delete_item' ),
					'permission_callback' => array( $this, 'permissions_check' ),
					'args'                => $this->get_collection_params(),
				),
				'schema' => array( $this, 'get_public_item_schema' ),
			)
		);
	}

	/**
	 * Check user permissions
	 *
	 * @param $request
	 *
	 * @return bool|WP_Error
	 */
	public function permissions_check( \WP_REST_Request $request ) {
		// if ( ! current_user_can( 'edit_others_pages' ) ) {
		// return new \WP_Error(
		// 'rest_forbidden_context',
		// __( 'Sorry, you are not allowed to use Widgetizer API.' ),
		// array( 'status' => rest_authorization_required_code() )
		// );
		// }
		return true;
	}

	/**
	 * Retrieves a collection of widgets
	 *
	 * @since 4.7.0
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 * @return \WP_REST_Response|\WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function get_items( $request ) {
		$widgets_parser = new Elementor_Builder(
			array(
				WPSEED_WIDGETIZER_PATH . '/widgets/elementor',
				WP_CONTENT_DIR . '/widgets/elementor',
				get_stylesheet_directory() . '/widgetizer/elementor',
			)
		);
		return new \WP_REST_Response( $widgets_parser->get_widgets() );
	}

	/**
	 * Retrieves on item
	 *
	 * @since 4.7.0
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 * @return \WP_REST_Response|\WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function get_item( $request ) {
		$item = [
			'widget_config' => '',
			'widget_style'  => '',
			'widget_script' => '',
		];
		if ( ! isset( $request['widget_provider'] ) || ! ( isset( $request['widget_name'] ) ) ) {
			return new \WP_Error( 'fields_cannot_be_empty', __( 'Fields cannot be empty' ) );
		}
		$widget_dir = get_stylesheet_directory() . '/widgetizer/elementor/' . $request['widget_provider'] . '/' . $request['widget_name'];
		if ( ! is_dir( $widget_dir ) ) {
			return new \WP_Error( 'widget_not_found', __( 'Widget not found' ), array('status' => 404));
		}
		$widget_config_file = $widget_dir . '/' . $request['widget_name'] . '.neon';
		if ( is_file( $widget_config_file ) ) {
			$item['widget_config'] = file_get_contents( $widget_config_file );
		}
		$widget_style_file = $widget_dir . '/' . $request['widget_name'] . '.css';
		if ( is_file( $widget_style_file ) ) {
			$item['widget_style'] = file_get_contents( $widget_style_file );
		}
		$widget_script_file = $widget_dir . '/' . $request['widget_name'] . '.js';
		if ( is_file( $widget_script_file ) ) {
			$item['widget_script'] = file_get_contents( $widget_script_file );
		}
		return new \WP_REST_Response(
			array_merge(
				array(
					'widget_provider' => $request['widget_provider'],
					'widget_name'     => $request['widget_name'],
				),
				$item
			)
		);
	}


	/**
	 * Creates one item from the collection
	 *
	 * @since 4.7.0
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 * @return \WP_REST_Response|\WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function create_item( $request ) {
		if ( ! isset( $request['widget_provider'] ) || ! ( isset( $request['widget_name'] ) ) ) {
			return new \WP_Error( 'fields_cannot_be_empty', __( 'Fields cannot be empty' ) );
		}
		$widget_dir = get_stylesheet_directory() . '/widgetizer/elementor/' . $request['widget_provider'] . '/' . $request['widget_name'];
		if ( is_dir( $widget_dir ) ) {
			return new \WP_Error( 'widget_already_exists', __( 'Widget already exists' ), array('status' => 403));
		}
		$filesystem = new Filesystem();
		$filesystem->mkdir( $widget_dir, 0755 );
		return new \WP_REST_Response(
			array(
				'widget_provider' => $request['widget_provider'],
				'widget_name'     => $request['widget_name'],
			)
		);
	}

	/**
	 * Update one item from the collection.
	 *
	 * @since 4.7.0
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 * @return \WP_REST_Response|\WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function update_item( \WP_REST_Request $request ) {
		$filesystem = new Filesystem();
		if ( ! isset( $request['widget_provider'] ) || ! isset( $request['widget_name']  ) ) {
			return new \WP_Error( 'fields_cannot_be_empty', __( 'Fields cannot be empty' ) );
		}
		$widget_dir = get_stylesheet_directory() . '/widgetizer/elementor/' . $request['widget_provider'] . '/' . $request['widget_name'];
		if ( ! is_dir( $widget_dir ) ) {
			return new \WP_Error( 'widget_not_found', __( 'Widget not found' ), array('status' => 404));
		}
		$widget_config_file = $widget_dir . '/' . $request['widget_name'] . '.neon';
		$filesystem->dumpFile($widget_config_file, $request['params']['widget_config']);
		$widget_style_file = $widget_dir . '/' . $request['widget_name'] . '.css';
		$filesystem->dumpFile($widget_style_file, $request['params']['widget_style']);
		$widget_script_file = $widget_dir . '/' . $request['widget_name'] . '.js';
		$filesystem->dumpFile($widget_script_file, $request['params']['widget_script']);
		return new \WP_REST_Response(
			array(
				'widget_provider' => $request['widget_provider'],
				'widget_name'     => $request['widget_name'],
				'widget_config'   => $request['params']['widget_config'],
				'widget_style'    => $request['params']['widget_style'],
				'widget_script'   => $request['params']['widget_script'],
			)
		);
	}

	/**
	 * Delete one item from the collection.
	 *
	 * @since 4.7.0
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 * @return \WP_REST_Response|\WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function delete_item( \WP_REST_Request $request ) {
		if ( ! isset( $request['widget_provider'] ) || ! isset( $request['widget_name']  ) ) {
			return new \WP_Error( 'fields_cannot_be_empty', __( 'Fields cannot be empty' ) );
		}
		$dir = get_stylesheet_directory() . '/widgetizer/elementor/' . $request['widget_provider'] . '/' . $request['widget_name'];
		if ( ! is_dir( $dir ) ) {
			return new \WP_Error( 'widget_not_found', __( 'Widget not found' ), array('status' => 404));
		}
		$filesystem = new Filesystem();
		try {
			$filesystem->remove( array( $dir ) );
		} catch ( \Exception $exception ) {
			return new \WP_Error( 'widget_delete_failed', __( 'Widget delete failed' ), array('status' => 403));
		}
		return new \WP_REST_Response(
			array(
				'widget_provider' => $request['widget_provider'],
				'widget_name'     => $request['widget_name'],
				'dir'             => $dir
			)
		);
	}

}
