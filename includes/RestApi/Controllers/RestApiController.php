<?php
/**
 * Rest_Api_Controller class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer\RestApi\Controllers;

/**
 * Rest API Controller class
 *
 * Class Rest_Api_Controller
 *
 * @package Wpseed\Widgetizer\Rest_Api
 */
class RestApiController extends \WP_REST_Controller {

	/**
	 * Plugin Rest API namespace
	 *
	 * @var string Plugin Rest API namespace.
	 */
	protected $namespace = 'widgetizer/v1';

}
