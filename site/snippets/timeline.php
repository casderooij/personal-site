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
	<time class="timeline__today"><?= date('D M j') ?></time>

	<?php
	$artifacts = $kirby->collection('artifacts');

	foreach ($artifacts as $artifact):
		snippet('artifact', ['now' => $now, 'artifact' => $artifact]);
	endforeach ?>
</section>