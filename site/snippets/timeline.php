<?php
date_default_timezone_set('Europe/Berlin');
$now = new \DateTime('now');
$artifacts = $kirby->collection('artifacts');
$timeOffset = $now->diff(new \DateTime($artifacts->last()->date()))->days;
?>

<section class="timeline" style="--full-timeline-offset: <?= $timeOffset + 10 ?>">
	<div class="timeline__date-container" style="--time-offset: 0;">
		<span class="timeline__date-label">[Today <?= date('F j') ?>]</span>
		<div class="timeline__date-line"></div>
	</div>

	<?php snippet('months') ?>

	<?php
	foreach ($artifacts as $artifact) {
		snippet('artifact', ['now' => $now, 'artifact' => $artifact]);
	}
	?>
</section>