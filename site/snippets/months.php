<?php
date_default_timezone_set('Europe/Amsterdam');

$now = new \DateTime('now');
$artifacts = $kirby->collection('artifacts');

if ($artifacts->isNotEmpty()) {
	$oldestArtifactDate = new \DateTime($artifacts->last()->date());
	$oldestArtifactDate->modify('first day of this month');
	$interval = $oldestArtifactDate->diff($now);
	$monthsDifference = $interval->y * 12 + $interval->m;

	$timelineMonths = [];
	$current = clone $oldestArtifactDate;

	for ($i = 0; $i <= $monthsDifference; $i++) {
		if ($i > 0) {
			$timelineMonths[] = clone $current;
		}
		$current->modify('+1 month');
	}
}
?>

<?php foreach ($timelineMonths as $monthDate): ?>
	<?php $monthOffset = $now->diff($monthDate)->days; ?>

	<div class="timeline__date-container" style="--time-offset: <?= $monthOffset ?>;">
		<div class="timeline__date">
			<div class="timeline__date-line"></div>
			<span class="timeline__date-label"><?= $monthDate->format('F') ?></span>
		</div>
	</div>
<?php endforeach; ?>