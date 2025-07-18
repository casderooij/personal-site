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
		<?php snippet('slider', ['slides' => $artifact->media()->toFiles()]) ?>
	</div>

	<div class="artifact__tags">
		<?php foreach ($artifact->tags()->split() as $tag): ?>
			<span class="artifact__tag"><?= $tag ?></span>
		<?php endforeach ?>
	</div>
</article>