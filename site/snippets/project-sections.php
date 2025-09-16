<?php
$projects = $page->projects()->toStructure();

foreach ($projects as $project):
    $projectPage = $project->page()->toPage();
?>
    <section class="float float--<?= $project->position() ?>">
        <div class="float-inner project" style="background-color: <?= $project->backgroundColor() ?>;">
            <div class="project-tags">
                <?php foreach ($projectPage->tags()->split() as $tag): ?>
                    <span class="project-tag"><?= $tag ?></span>
                <?php endforeach ?>
            </div>

            <h2><?= $projectPage->title() ?></h2>
            <?php snippet('gallery', ['media' => $projectPage->media()->toFiles()]) ?>
            <div class="project-description">
                <?= $projectPage->description() ?>
            </div>
        </div>
    </section>
<?php endforeach ?>