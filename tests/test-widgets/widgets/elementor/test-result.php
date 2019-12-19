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
			'path' => '/plugins/widgetizer/tests/test-widgets/widgets/elementor/widgetizer/hello-world',
			'config' => [
				'title' => 'Hello World!',
				'icon' => 'eicon-posts-ticker',
				'content' => [
					'general' => [
						'tab' => 'content',
						'widget_title' => [
							'type' => 'text',
							'label' => 'Widget Title',
							'default' => 'Default Title Content',
						],
						'widget_content' => [
							'type' => 'textarea',
							'label' => 'Widget Content',
							'default' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
						],
					],
					'advanced' => [
						'tab' => 'style',
						'widget_code' => ['type' => 'code', 'label' => 'Widget Code'],
					],
				],
			],
		],
		'minimal' => [
			'path' => '/plugins/widgetizer/tests/test-widgets/widgets/elementor/widgetizer/minimal',
			'config' => ['title' => 'Minimal', 'content' => ['general' => null]],
		],
	],
];
