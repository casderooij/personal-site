<?php
if (!isset($slides)) {
	echo 'Please pass slides array as argument to artifact-slider snippet';
	return false;
}
?>

<div class="artifact-slider">
	<ul>
		<?php foreach ($slides as $slide): ?>
			<li style="--aspect-ratio: <?= $slide->aspectratio() ?>">
				<?php snippet('artifact-media-item', ['media' => $slide]) ?>
			</li>
		<?php endforeach ?>
	</ul>
</div>