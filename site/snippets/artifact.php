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

	<a class="artifact__expand-link" href="/artifact-details/<?= $artifact->slug() ?>">
		<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M10 6.5C10 8.433 8.433 10 6.5 10C4.567 10 3 8.433 3 6.5C3 4.567 4.567 3 6.5 3C8.433 3 10 4.567 10 6.5ZM9.30884 10.0159C8.53901 10.6318 7.56251 11 6.5 11C4.01472 11 2 8.98528 2 6.5C2 4.01472 4.01472 2 6.5 2C8.98528 2 11 4.01472 11 6.5C11 7.56251 10.6318 8.53901 10.0159 9.30884L12.8536 12.1464C13.0488 12.3417 13.0488 12.6583 12.8536 12.8536C12.6583 13.0488 12.3417 13.0488 12.1464 12.8536L9.30884 10.0159Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
		</svg>
	</a>

	<div class="artifact__media">
		<?php snippet('slider', ['slides' => $artifact->media()->toFiles()]) ?>
	</div>

	<div class="artifact__tags">
		<?php foreach ($artifact->tags()->split() as $tag): ?>
			<span class="artifact__tag"><?= $tag ?></span>
		<?php endforeach ?>
	</div>
</article>