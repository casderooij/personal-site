<?php
date_default_timezone_set('Europe/Amsterdam');
$now = new \DateTime('now');
$timeOffset = $now->diff(
	new \DateTime(
		$kirby->collection('artifacts')->last()->date()
	)
)->days;
?>

<section class="timeline" style="--full-timeline-offset: <?= $timeOffset + 10 ?>">

	<?php snippet('months') ?>

	<div class="timeline__date-container" style="--time-offset: 0;">
		<div class="timeline__date">
			<div class="timeline__date-line"></div>
			<span class="timeline__date-label">Today <?= date('M j') ?></span>
		</div>
	</div>

	<?php
	$artifacts = $kirby->collection('artifacts');

	foreach ($artifacts as $artifact):
		snippet('artifact', ['now' => $now, 'artifact' => $artifact]);
	endforeach ?>
</section>