<?php
/**
 * Parser test file
 *
 * @package Widgetizer
 */

use Tester\Assert;

require __DIR__ . '/../../../../vendor/autoload.php';

Tester\Environment::setup();

$o = new \Wpseed\Widgetizer\Elementor\Parser();

Assert::same( 'Hello John', $o->parse_dir( '../../widgets/elementor' ) );