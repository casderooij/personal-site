<div class="artifact-details__container">
	<div class="artifact-details">
		<div class="artifact-details__header">
			<div class="artifact-details__header-top">
				<h2><?= $artifact->title() ?></h2>
				<button id="close-details" class="artifact-details__close-button">Close</button>
			</div>

			<div class="artifact-details__tags">
				<?php snippet('artifact-tags', ['tags' => $artifact->tags()]) ?>
			</div>
		</div>

		<div class="artifact-details__body">


			<p><?= $artifact->description() ?></p>

			<?php if ($artifact->hasChildren()): ?>
				<section>
					<p>Updates:</p>
					<ul>
						<?php foreach ($artifact->children() as $update): ?>
							<li><?= $update->date()->toDate('M j') ?>

							</li>
						<?php endforeach ?>
					</ul>
				</section>
			<?php endif ?>
		</div>
	</div>
</div>