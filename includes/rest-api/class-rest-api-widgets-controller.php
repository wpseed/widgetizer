<?php
/**
 * Rest_Api_Widgets_Controller class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer\Rest_Api;

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
					'methods'             => \WP_REST_Server::READABLE,
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
				'args'   => array (
					'widget_provider' => array(
						'description' => __( 'Widget provider identifier.' ),
						'type'        => 'string',
					),
					'widget_name' => array(
						'description' => __( 'Widget name identifier.' ),
						'type'        => 'string',
					),
				),
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_item' ),
					'permission_callback' => array( $this, 'permissions_check' ),
					'args'                => $this->get_collection_params(),
				),
				array(
					'methods'             => \WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'create_item' ),
					'permission_callback' => array( $this, 'permissions_check' ),
					'args'                => $this->get_collection_params(),
				),
				array(
					'methods'             => \WP_REST_Server::EDITABLE,
					'callback'            => array( $this, 'update_item' ),
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
//		if ( ! current_user_can( 'edit_others_pages' ) ) {
//			return new \WP_Error(
//				'rest_forbidden_context',
//				__( 'Sorry, you are not allowed to use Widgetizer API.' ),
//				array( 'status' => rest_authorization_required_code() )
//			);
//		}
		return true;
	}

	/**
	 * Retrieves a collection of widgets.
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
	 * Creates one item from the collection.
	 *
	 * @since 4.7.0
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 * @return \WP_REST_Response|\WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function create_item( \WP_REST_Request $request ) {
		if ( isset( $request['widget_provider'] ) && ( isset( $request['widget_name'] ) ) ) {
			return new \WP_REST_Response(
				array(
					'widget_provider' => $request['widget_provider'],
					'widget_name' => $request['widget_name'],
				)
			);
		}
		return false;
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
		if ( isset( $request['widget_provider'] ) && ( isset( $request['widget_name'] ) ) ) {
			return new \WP_REST_Response(
				array(
					'widget_provider' => $request['widget_provider'],
					'widget_name' => $request['widget_name'],
				)
			);
		}
		return false;
	}

}
