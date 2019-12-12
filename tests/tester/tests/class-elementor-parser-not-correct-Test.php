<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$o = new \Wpseed\Widgetizer\Elementor\Parser();

$expect_result = require '../../test-widgets/widgets-not-correct/elementor/test-result.php';

Assert::same( $expect_result, $o->parse_widgets( realpath( '../../test-widgets/widgets-not-correct/elementor' ) ) );
