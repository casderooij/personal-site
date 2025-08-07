<?php
$updates = $artifact->children()->sortBy('date', 'desc');
$latestUpdate = $updates->last();
$date = $artifact->date()->toDate('d-m-Y');
?>

<div class="artifact-details__container">
	<div class="artifact-details">
		<div class="artifact-details__content">
			<header class="artifact-details__header">
				<div>
					<time datetime="<?= $date ?>">[<?= $date ?>]</time>
					<?php if ($latestUpdate):
						$latestUpdateDate = $latestUpdate->date()->toDate('d-m-Y'); ?>
						<time datetime="<?= $latestUpdateDate ?>">[<?= $latestUpdateDate ?>]</time><?php endif ?>
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