<?php
$projects = site()->find('projects')->children()->listed()->filter(function ($project) {
	return in_array('experiment', $project->tags()->split(','));
});
$index = 0;
?>

<?php if ($projects->isNotEmpty()): ?>
	<section class="project-thumbnails-stack" style="--total-items: <?= count($projects) ?>">
		<?php foreach ($projects as $project): ?>
			<?php if ($image = $project->image()): ?>
				<?php $thumb = $image->thumb('project'); ?>
				<img
					src="<?= $thumb->url() ?>"
					alt="<?= $image->alt()->or($project->title())->esc() ?>"
					width="<?= $thumb->width() ?>"
					height="<?= $thumb->height() ?>"
					style="--stack-i: <?= $index ?>"
					loading="lazy">
			<?php endif ?>
			<?php $index++; ?>
		<?php endforeach ?>
	</section>
<?php endif ?>