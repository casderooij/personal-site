<?php $type = $item->type(); ?>

<div class="artifact__thumbnail" style="aspect-ratio: <?= $item->aspectRatio() ?>; width: 200px; height: auto;">
	<?php if ($type === 'video'): ?>
		<video
			tabindex="-1"
			src="<?= $item->url() ?>"
			loop
			muted
			autoplay
			playsinline
			preload="auto" style="display: block; width: 100%; height: 100%;"></video>
	<?php elseif ($type === 'image'): ?>
		<?php $thumb = $item->thumb('project'); ?>
		<img
			src="<?= $thumb->url() ?>"
			alt="<?= $item->alt()->or($item->title())->esc() ?>"
			width="<?= $thumb->width() ?>"
			height="<?= $thumb->height() ?>"
			loading="lazy" style="width: 100%; height: 100%;">
	<?php endif ?>
</div>