<?php

return [
	'debug' => true,
	'thumbs' => [
		'presets' => [
			'sketch-thumb' => [
				'width'  => 400,
				'height' => 400,
				'format' => 'webp'
			],
			'sketch-placeholder' => [
				'width'   => 16,
				'height'  => 16
			],
			'sketch-large' => [
				'width'   => 500,
				'height'  => 500,
				'format'  => 'webp'
			]
		],
	],
	'routes' => [
		[
			'pattern' => '(:num)-(:num)', // matches YY-MM or YYYY-MM
			'action'  => function ($year, $month) {
				// Ensure the month is 2 digits
				$month = sprintf('%02d', $month);

				// If it is a 2-digit year (like 26), convert it to 4-digit (2026)
				if (strlen($year) === 2) {
					$year = '20' . $year;
				}

				// Render the homepage with the parsed year and month parameters passed in
				return site()->visit(site()->homePage())->render([
					'routeYear'  => $year,
					'routeMonth' => $month
				]);
			}
		]
	],
	'hooks' => [
		'file.create:after' => function ($file) {

			// Helper function to calculate aspect ratio
			$calculateAspectRatio = function ($width, $height) {
				if ($width && $height) {
					return $width / $height;
				}
				return null;
			};

			// Check if the file is a video or image
			if (in_array($file->type(), ['video', 'image'])) {

				// Initialize variables
				$width = null;
				$height = null;

				// For videos, use getID3 library
				if ($file->type() === 'video') {
					$getID3 = new getID3();
					$fileInfo = $getID3->analyze($file->realpath());
					$width = $fileInfo['video']['resolution_x'] ?? null;
					$height = $fileInfo['video']['resolution_y'] ?? null;
				}

				// For images, use Kirby's built-in methods
				if ($file->type() === 'image') {
					$width = $file->width();
					$height = $file->height();
				}

				// Calculate aspect ratio
				$aspectRatio = $calculateAspectRatio($width, $height);

				// Check and save the aspect ratio
				if ($aspectRatio !== null) {
					try {
						$file->update([
							'aspectRatio' => number_format($aspectRatio, 2)
						]);
					} catch (Exception $e) {
						error_log("Failed to save metadata: " . $e->getMessage());
						throw $e;
					}
				}
			}
		}
	]
];
