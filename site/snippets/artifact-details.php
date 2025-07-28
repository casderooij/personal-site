<div class="artifact-details__container">
	<div class="artifact-details">
		<div class="spacer"></div>
		<div class="content-container">
			<time datetime="<?= $artifact->date() ?>">
				[<?= $artifact->date() ?>]
			</time>

			<h1><?= $artifact->title() ?></h1>

			<?php if ($artifact->description()): ?>
				<p><?= $artifact->description() ?></p>
			<?php endif ?>
		</div>
	</div>
</div>