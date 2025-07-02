<?php

namespace SitePlugin;

use FFMpeg\Coordinate\TimeCode;
use Kirby\Cms\File;
use Kirby\Cms\Page;

class PosterGenerator
{

	/**
	 * Fetch existing poster or generate one.
	 */
	static function getOrGeneratePoster(File $videoFile, Page|null $posterParent): File|null
	{
		if ($videoFile->type() !== 'video') return null;

		if ($videoFile->content()->posterImage()->exists()) {
			$posterFile = $videoFile->content()->posterImage()->toFile();
			if ($posterFile) {
				return $posterFile;
			}
		}
		return self::generatePoster($videoFile, $posterParent);
	}

	/**
	 * Regenerate the poster image of a video file 
	 * and save it under the given parent
	 */
	static function generatePoster(File $videoFile, Page|null $posterParent): File|null
	{
		if ($videoFile->type() !== 'video') return null;

		$oldPoster = null;
		if ($videoFile->content()->posterImage()->exists()) {
			/** @var File */
			$oldPoster = $videoFile->content()->posterImage()->toFile();
		}

		$ffmpeg = \FFMpeg\FFMpeg::create([
			'ffmpeg.binaries'  => exec('which ffmpeg') ?: "/opt/homebrew/bin/ffmpeg",
			'ffprobe.binaries' => exec('which ffprobe') ?: "/opt/homebrew/bin/ffprobe"
		]);

		$video = $ffmpeg->open($videoFile->realpath());

		$temp = tmpfile();
		$tmpFilename = stream_get_meta_data($temp)['uri'];
		$tmpFilename = $tmpFilename . '.jpg';

		$video->frame(TimeCode::fromSeconds(0))
			->save($tmpFilename);

		$poster_filename = explode(".", $videoFile->filename())[0] . '_poster_' . $videoFile->uuid()->id() . '.jpg';
		$poster = File::create([
			'parent' => $posterParent,
			'source' => $tmpFilename,
			'filename' => $poster_filename
		]);

		$videoFile->update([
			'posterImage' => [$poster->uuid()->toString()]
		]);

		if ($oldPoster) {
			$oldPoster->delete();
		}

		return $poster;
	}

	/**
	 * Delete poster image if it exists.
	 */
	static function deletePoster(File $videoFile)
	{
		if ($videoFile->content()->posterImage()->exists()) {
			/** @var File */
			$posterFile = $videoFile->content()->posterImage()->toFile();
			if ($posterFile) {
				$posterFile->delete();
			}
		}
	}
}
