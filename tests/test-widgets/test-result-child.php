<?php

return [
	'non-widgetizer' => [
		'no-config' => [
			'path' => '/plugins/widgetizer/tests/test-widgets/widgets/elementor/non-widgetizer/no-config',
		],
	],
	'third-provider' => [],
	'widgetizer' => [
		'hello-world' => [
			'path' => '/plugins/widgetizer/tests/test-widgets/widgets-child/elementor/widgetizer/hello-world',
			'config' => [
				'title' => 'Hello World!',
				'icon' => 'eicon-posts-ticker',
				'content' => [
					'general' => [
						'widget_title' => [
							'type' => 'text',
							'label' => 'Widget Title',
							'default' => 'Default Title Content',
						],
					],
					'advanced' => ['widget_code' => ['type' => 'code', 'label' => 'Widget Code']],
				],
			],
		],
		'minimal' => [
			'path' => '/plugins/widgetizer/tests/test-widgets/widgets-child/elementor/widgetizer/minimal',
			'config' => ['title' => 'Minimal', 'content' => ['general' => null]],
		],
	],
];
