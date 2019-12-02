<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$o = new \Wpseed\Widgetizer\Elementor\Parser();

$expect_result = require '../../templates/widgets-not-correct/elementor/test-result.php';

Assert::same( $expect_result, $o->parse_widgets( realpath( '../../templates/widgets-not-correct/elementor' ) ) );
