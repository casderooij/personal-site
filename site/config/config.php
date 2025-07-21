<?php

use getID3;

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
			'pattern' => 'artifact-details/(:any)',
			'method' => 'GET',
			'action' => function (string $artifactId) {
				if ($artifact = page('artifacts/' . $artifactId)) {
					return snippet('artifact-details', ['artifact' => $artifact], true);
				} else {
					return kirby()->response()->code(404);
				}
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
