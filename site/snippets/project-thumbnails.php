<?php
$projects = site()->find('projects')->children()->listed()->filter(function ($project) {
	return in_array('experiment', $project->tags()->split(','));
});
?>

<?php if ($projects->isNotEmpty()): ?>
	<section>
		<h2>Experiments</h2>

		<div>
			<?php foreach ($projects as $project): ?>
				<?php if ($image = $project->image()): ?>
					<?php $thumb = $image->thumb('project'); ?>
					<img
						src="<?= $thumb->url() ?>"
						alt="<?= $image->alt()->or($project->title())->esc() ?>"
						width="<?= $thumb->width() ?>"
						height="<?= $thumb->height() ?>"
						loading="lazy"
					>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	</section>
<?php endif ?>