<?php $index = 0; ?>

<?php if ($slides->isNotEmpty()): ?>
	<div class="stack-container">

		<div class="stack wave <?= $slides->count() === 1 ? 'single-slide' : '' ?>"
			style="--total-items: <?= count($slides) ?>"
			data-index="0">

			<?php foreach ($slides as $slide): ?>
				<?php
				$mediaElement = $slide;
				$posterUrl = null;

				// Prefer video if available
				if ($slide->type() === 'video') {
					$video = $slide;
					// Check if a poster image is linked in the video's content file
					if ($poster = $video->content()->poster()->toFile()) {
						$posterUrl = $poster->url();
					}
				}
				?>

				<?php if ($mediaElement): ?>
					<?php $thumb = $mediaElement->thumb('project'); ?>
					<div
						class="stack-item <?= $index === 0 ? 'is-top' : 'is-hidden' ?>"
						style="--stack-i: <?= $index ?>"
						data-index="<?= $index ?>"
						data-type="<?= $mediaElement->type() ?>">
						<?php if ($mediaElement->type() === 'video'): ?>
							<video
								src="<?= $mediaElement->url() ?>"
								loop
								muted
								playsinline
								preload="auto"></video>
						<?php else: ?>
							<img
								src="<?= $thumb->url() ?>"
								alt="<?= $mediaElement->alt()->or($slide->title())->esc() ?>"
								width="<?= $thumb->width() ?>"
								height="<?= $thumb->height() ?>"
								loading="lazy">
						<?php endif ?>
					</div>
				<?php endif ?>
				<?php $index++; ?>
			<?php endforeach ?>

			<?php if ($slides->count() > 1): ?>
				<div class="indicator glass-effect">
					<span>
						<?php
						$indicator = '';
						for ($i = 0; $i < count($slides); $i++) {
							$indicator .= $i === 0 ? '#' : '-';
						}
						echo $indicator;
						?>
					</span>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif ?>