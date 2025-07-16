<?php
$dateTime = new \DateTime($artifact->date());
$timeOffset = $now->diff($dateTime)->days;
$index = 0;
?>

<article
	class="artifact"
	style="--time-offset: <?= $timeOffset ?>;">

	<div class="artifact__meta">
		<span class="artifact__date"><?= $artifact->date()->toDate('M j') ?></span>
		<span class="artifact__title"><?= $artifact->title() ?></span>
	</div>

	<div class="artifact__media">
		<div class="stack circle" style="--total-items: <?= $artifact->media()->count() ?>"
			data-index="0">
			<?php
			$media = $artifact->media()->toFiles();
			foreach ($media as $element):
				if ($element): ?>
					<?php $thumb = $element->thumb('project'); ?>
					<div
						class="stack-item <?= $index === 0 ? 'is-top' : 'is-hidden' ?>"
						style="--stack-i: <?= $index ?>"
						data-index="<?= $index ?>"
						data-type="<?= $element->type() ?>">
						<?php if ($element->type() === 'video'): ?>
							<video
								src="<?= $element->url() ?>"
								loop
								muted
								playsinline
								preload="auto"></video>
						<?php else: ?>
							<img
								src="<?= $thumb->url() ?>"
								alt="<?= $element->alt()->or($slide->title())->esc() ?>"
								width="<?= $thumb->width() ?>"
								height="<?= $thumb->height() ?>"
								loading="lazy">
						<?php endif ?>
					</div>
				<?php endif ?>
				<?php $index++; ?>
			<?php endforeach ?>
		</div>
	</div>
</article>