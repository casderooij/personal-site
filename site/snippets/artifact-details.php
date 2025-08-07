<?php
$updates = $artifact->children()->sortBy('date', 'desc');
$latestUpdate = $updates->last();
$date = $artifact->date()->toDate('d-m-Y');
?>

<div class="artifact-details__container">
	<div class="artifact-details">
		<div class="artifact-details__content">
			<header class="artifact-details__header">
				<div class="artifact-details__header-info">
					<h2><?= $artifact->title() ?></h2>
					<div class="artifact-time">
						<time datetime="<?= $date ?>">[<?= $date ?>]</time>
						<?php if ($latestUpdate):
							$latestUpdateDate = $latestUpdate->date()->toDate('d-m-Y'); ?>
							<span>-</span><time datetime="<?= $latestUpdateDate ?>">[<?= $latestUpdateDate ?>]</time><?php endif ?>
					</div>
				</div>
				<a href="/" id="close">close</a>
			</header>

			<?php if ($artifact->description()): ?>
				<p><?= $artifact->description() ?></p>
			<?php endif ?>
		</div>
	</div>
</div>