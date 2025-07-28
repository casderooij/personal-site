v<div class="artifact-details__container">
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
			<p class="artifact-details__description"><?= $artifact->description() ?></p>

			<div class="artifact-details__media-container">
				<?php snippet('slider', ['slides' => $artifact->media()->toFiles()]); ?>
			</div>

			<?php if ($artifact->hasChildren()): ?>
				<section class="artifact-detail__update-section">
					<p>Updates</p>
					<ul class="artifact-detail__update-list">
						<?php foreach ($artifact->children() as $update): ?>
							<li class="artifact-detail__update">
								<div class="pill artifact-detail__update-date"><?= $update->date()->toDate('F j') ?></div>
								<div class="artifact-detail__update-media-container">
									<!-- <?php snippet('slider', ['slides' => $update->media()->toFiles()]); ?> -->
									<?php snippet('artifact-slider', ['slides' => $update->media()->toFiles()]) ?>
								</div>
							</li>
						<?php endforeach ?>
					</ul>
				</section>
			<?php endif ?>
		</div>
	</div>
</div>