<?php
$updates = $artifact->children()->sortBy('date', 'desc');
$latestUpdate = isset($updates) ? $updates : null;
$date = $artifact->date()->toDate('d-m-Y');
?>

<div class="artifact-details__container">
	<div class="artifact-details">
		<div class="artifact-details__content">
			<header class="artifact-details__header">
				<div>
					<time datetime="<?= $date ?>">[<?= $date ?>]</time>
					<h2><?= $artifact->title() ?></h2>
				</div>
				<a href="/" id="close">close</a>
			</header>

			<?php if ($artifact->description()): ?>
				<p><?= $artifact->description() ?></p>
			<?php endif ?>
		</div>
	</div>
</div>