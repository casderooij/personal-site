<?php
$dateTime = new \DateTime($artifact->date());
$timeOffset = $now->diff($dateTime)->days;

$slug = $artifact->intendedTemplate() == 'artifact-update' ?
	$artifact->parent()->slug() :
	$artifact->slug();
?>

<article class="artifact" style="--time-offset: <?= $timeOffset ?>;">
	<a class="artifact__expand-link" href="/artifact-details/<?= $slug ?>" data-slug="<?= $slug ?>">
		<div class="artifact__x-position">
			<div class="artifact__meta">
				<time datetime="<?= $dateTime->format('Y-m-d') ?>">
					[<?= $artifact->date()->toDate('F j') ?>]
				</time>

				<?php if ($artifact->intendedTemplate() == 'artifact-update'): ?>
					<span class="artifact__icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="11.5" height="11.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="12" cy="12" r="3" />
							<line x1="3" x2="9" y1="12" y2="12" />
							<line x1="15" x2="21" y1="12" y2="12" />
						</svg>
					</span>
				<?php endif ?>
				<?php if ($artifact->hasChildren()): ?>
					<span class="artifact__icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="11.5" height="11.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="6" cy="19" r="3" />
							<path d="M9 19h8.5a3.5 3.5 0 0 0 0-7h-11a3.5 3.5 0 0 1 0-7H15" />
							<circle cx="18" cy="5" r="3" />
						</svg>
					</span>
				<?php endif ?>
			</div>

			<?php snippet('artifact-thumbnail', ['item' => $artifact->media()->toFiles()->first()]) ?>
		</div>
	</a>
</article>