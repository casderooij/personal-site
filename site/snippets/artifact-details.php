<div class="artifact-details__container">
	<div class="artifact-details">
		<div class="spacer"></div>
		<div class="artifact-content">
			<header>
				<div>
					<time datetime="<?= $artifact->date() ?>">
						[<?= $artifact->date() ?>]
					</time>

					<h1><?= $artifact->title() ?></h1>
				</div>
				<a href="/" id="close">Close</a>
			</header>

			<?php if ($artifact->description()): ?>
				<p><?= $artifact->description() ?></p>
			<?php endif ?>
		</div>
	</div>
</div>