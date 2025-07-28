<?php
$type = $media->type();
$thumb = $media->thumb('project');
?>

<?php if ($type == 'image'): ?>
	<img
		src="<?= $thumb->url() ?>"
		alt="<?= $media->alt()->or($media->title())->esc() ?>"
		width="<?= $thumb->width() ?>"
		height="<?= $thumb->height() ?>"
		loading="lazy">
<?php elseif ($type == 'video'): ?>
	<video
		src="<?= $media->url() ?>"
		loop
		muted
		playsinline
		autoplay
		preload="auto"></video>
<?php endif ?>