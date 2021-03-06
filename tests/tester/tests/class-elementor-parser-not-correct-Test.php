<?php

use Tester\Assert;
use Wpseed\Widgetizer\Elementor\Elementor_Builder;

require __DIR__ . '/../bootstrap.php';

$o = new Elementor_Builder( [ '../../test-widgets/widgets-not-correct/elementor' ] );

$expect_result = require '../../test-widgets/widgets-not-correct/elementor/test-result.php';

Assert::same( $expect_result, $o->get_config() );
