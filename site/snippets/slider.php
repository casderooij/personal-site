<?php $index = 0; ?>

<?php if ($slides->isNotEmpty()): ?>
	<div class="stack-container">

		<div class="stack circle"
			style="--total-items: <?= count($slides) ?>"
			data-index="0">

			<?php foreach ($slides as $slide): ?>
				<?php
				$mediaElement = null;
				$posterUrl = null;

				// Prefer video if available
				if ($video = $slide->video()->toFile()) {
					$mediaElement = $video;
					// Check if a poster image is linked in the video's content file
					if ($poster = $video->content()->poster()->toFile()) {
						$posterUrl = $poster->url();
					}
				} elseif ($image = $slide->image()->toFile()) {
					// Fallback to image if no video
					$mediaElement = $image;
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
		</div>
	</div>
<?php endif ?>