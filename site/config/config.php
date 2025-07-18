<?php

return [
	'debug' => true,
	'thumbs' => [
		'presets' => [
			'project' => [
				'width' => 400,
				'format' => 'webp'
			]
		]
	],
	'routes' => [
		[
			'pattern' => 'artifact/(:any)',
			'method' => 'GET',
			'action' => function (string $artifactId) {
				$artifact = page('artifacts/' . $artifactId);
				if ($artifact) {
					return snippet('artifact-details', ['artifact' => $artifact], true);
				} else {
					return kirby()->response()->code(404);
				}
			}
		]
	]
];
