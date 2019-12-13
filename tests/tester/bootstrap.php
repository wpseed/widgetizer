<?php
/**
 * Tester bootstrap file
 *
 * @package Widgetizer
 */

define( 'WPSEED_WIDGETIZER_TESTS_PATH', __DIR__ );

define( 'WP_CONTENT_DIR', realpath('../../../../../') );

require __DIR__ . '/../../vendor/autoload.php';

Tester\Environment::setup();
