<?php $index = 0; ?>

<?php if ($slides->isNotEmpty()): ?>
	<div class="stack-container" style="--total-items: <?= count($slides) ?>">

		<div class="stack wave <?= $slides->count() === 1 ? 'single-slide' : '' ?>"
			data-index="0">

			<?php foreach ($slides as $slide): ?>

				<?php
				$thumb = $slide->thumb('project');
				$type = $slide->type();
				?>
				<div
					class="stack-item <?= $index === 0 ? 'is-top' : 'is-hidden' ?>"
					style="--stack-i: <?= $index ?>; --aspect-ratio: <?= $slide->aspectRatio() ?>"
					data-index="<?= $index ?>"
					data-type="<?= $type ?>">
					<?php if ($type === 'video'): ?>
						<video
							src="<?= $slide->url() ?>"
							loop
							muted
							playsinline
							preload="auto"></video>
					<?php elseif ($type === 'image'): ?>
						<img
							src="<?= $thumb->url() ?>"
							alt="<?= $slide->alt()->or($slide->title())->esc() ?>"
							width="<?= $thumb->width() ?>"
							height="<?= $thumb->height() ?>"
							loading="lazy">
					<?php endif ?>
				</div>

				<?php $index++; ?>
			<?php endforeach ?>

			<?php if ($slides->count() > 1): ?>
				<div class="indicator">
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