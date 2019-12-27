<?php

use Tester\Assert;
use Wpseed\Widgetizer\Validator;

require __DIR__ . '/../bootstrap.php';

Assert::same( true, Validator::is_widgetizer_slug( 'hello-world' ) );

Assert::same( false, Validator::is_widgetizer_slug( 'hello-world@' ) );

Assert::same( false, Validator::is_widgetizer_slug( '-hello-world' ) );

Assert::same( false, Validator::is_widgetizer_slug( 'hello-World' ) );
