<?php
$index = 1;
$firstItem = $media->first();
$restOfMedia = $media->slice(1);
?>

<div class="artifact__media-stack">
	<?php if ($media->isNotEmpty()): ?>
		<div class="stack wave" style="--total-items: <?= count($media) ?>">
			<?php if ($item = $firstItem): ?>
				<?php
				$type = $item->type();
				if ($type === 'video'):
				?>
					<div class="media-item stack-item is-top"
						style="--stack-i: 0; width: 200px; aspect-ratio: <?= $item->aspectRatio() ?>;">
						<video
							src="<?= $item->url() ?>"
							loop
							muted
							autoplay
							playsinline
							preload="auto" style="width: 100%; height: 100%;"></video>
					</div>
				<?php elseif ($type === 'image'): ?>
					<div class="media-item stack-item is-top" style="--stack-i: 0; width: 200px; aspect-ratio: <?= $item->aspectRatio() ?>;">
						<?php $thumb = $item->thumb('project'); ?>
						<img
							src="<?= $thumb->url() ?>"
							alt="<?= $item->alt()->or($item->title())->esc() ?>"
							width="<?= $thumb->width() ?>"
							height="<?= $thumb->height() ?>"
							loading="lazy" style="width: 100%; height: 100%;">
					</div>
				<?php endif ?>
			<?php endif ?>

			<?php foreach ($restOfMedia as $item): ?>
				<div class="stack-item"
					style="--stack-i: <?= $index ?>; --dotSize: 0.05rem;
  --bgSize: 0.3rem;
  --bgPosition: calc(var(--bgSize) / 2);

  background-image: radial-gradient(
      circle at center,
      black var(--dotSize),
      transparent 0
    ), radial-gradient(circle at center, black var(--dotSize), transparent 0);
  background-size: var(--bgSize) var(--bgSize);
  background-position: 0 0, var(--bgPosition) var(--bgPosition); aspect-ratio: <?= $item->aspectRatio() ?>;"></div>
				<?php $index++; ?>
			<?php endforeach; ?>
		</div>
	<?php endif ?>
</div>