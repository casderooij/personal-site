<?php
$artifactUpdates = $artifact->children()->sortBy('date', 'desc');
$latestUpdate = $artifactUpdates->last();
$date = $artifact->date()->toDate('d-m-Y');
?>

<div class="artifact-details__container">
	<div class="artifact-details">
		<div class="artifact-details__content">
			<header class="artifact-details__header">
				<div class="artifact-details__header-info">
					<h2><?= $artifact->title() ?></h2>

					<div class="artifact-details__tags">
						<?php foreach ($artifact->tags()->split() as $tag): ?>
							<span><?= $tag ?></span>
						<?php endforeach ?>
					</div>
				</div>
				<a href="/" id="close">close</a>
			</header>

			<div class="artifact-details__updates">
				<?php if ($artifact->description()): ?>
					<p><?= $artifact->description() ?></p>
				<?php endif ?>

				<?php foreach ($artifactUpdates as $artifactUpdate):
					$artifactUpdateDate = $artifactUpdate->date()->toDate('d-m-Y');
				?>
					<div class="artifact-details__update">
						<time datetime="<?= $artifactUpdateDate ?>">[<?= $artifactUpdateDate ?>]</time>
						<?php snippet('artifact-thumbnail', ['item' => $artifactUpdate->media()->toFiles()->first()]) ?>
					</div>
				<?php endforeach ?>

				<div class="artifact-details__update">
					<time datetime="<?= $date ?>">[<?= $date ?>]</time>
					<?php snippet('artifact-thumbnail', ['item' => $artifact->media()->toFiles()->first()]) ?>
				</div>
			</div>
		</div>
	</div>
</div>