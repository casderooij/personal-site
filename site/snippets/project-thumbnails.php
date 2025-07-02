<?php
$projects = site()->find('projects')->children()->listed()->filter(function ($project) {
	return in_array('experiment', $project->tags()->split(','));
});
$index = 0;
?>

<?php if ($projects->isNotEmpty()): ?>
	<section class="project-thumbnails-stack" style="--total-items: <?= count($projects) ?>">
		<?php foreach ($projects as $project): ?>
			<?php
			$mediaElement = null;
			$posterUrl = null;

			// Prefer video if available
			if ($video = $project->video()->toFile()) {
				$mediaElement = $video;
				// Check if a poster image is linked in the video's content file
				if ($poster = $video->content()->poster()->toFile()) {
					$posterUrl = $poster->url();
				}
			} elseif ($image = $project->image()->toFile()) {
				// Fallback to image if no video
				$mediaElement = $image;
			}
			?>

			<?php if ($mediaElement): ?>
				<?php $thumb = $mediaElement->thumb('project'); ?>
				<div
					class="stack-item"
					style="--stack-i: <?= $index ?>"
					data-original-index="<?= $index ?>"
					data-type="<?= $mediaElement->type() ?>">
					<?php if ($mediaElement->type() === 'video'): ?>
						<video
							src="<?= $mediaElement->url() ?>"
							<?= $posterUrl ? 'poster="' . $posterUrl . '"' : '' ?>
							width="<?= $thumb->width() ?>"
							height="<?= $thumb->height() ?>"
							loop
							muted
							playsinline
							preload="auto"></video>
					<?php else: ?>
						<img
							src="<?= $thumb->url() ?>"
							alt="<?= $mediaElement->alt()->or($project->title())->esc() ?>"
							width="<?= $thumb->width() ?>"
							height="<?= $thumb->height() ?>"
							loading="lazy">
					<?php endif ?>
				</div>
			<?php endif ?>
			<?php $index++; ?>
		<?php endforeach ?>

		<div class="indicator glass-effect"><span id="project-stack-indicator">1 / <?= count($projects) ?></span></div>
	</section>
<?php endif ?>