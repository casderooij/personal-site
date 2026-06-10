<?php

/** @var \Kirby\Cms\Page $sketch */
/** @var int $index */

// Clean date formatting
$dateValue = $sketch->date();
$formattedDate = $dateValue->isNotEmpty() ? $dateValue->toDate('d m Y') : '';
$machineDate = $dateValue->isNotEmpty() ? $dateValue->toDate('Y-m-d') : '';

// Retrieve primary image or fallback to first image in page folder
$image = null;
if ($sketch->gallery()->isNotEmpty()) {
    $image = $sketch->gallery()->toFile();
} else {
    $image = $sketch->images()->first();
}
?>

<div class="wavy-item group" style="--index: <?= $index ?>;">
    <?php if ($index === 0 && $formattedDate): ?>
        <!-- Today timeline marker and alignment line spanning full screen behind elements -->
        <div class="absolute right-full top-6 mr-6 flex items-baseline pointer-events-none select-none whitespace-nowrap z-20">
            <div class="text-left font-mono text-xs leading-none uppercase tracking-wider text-neutral-800">
                <span class="block opacity-60 mb-1 text-[10px]">today</span>
                <time datetime="<?= $machineDate ?>" class="font-bold"><?= $formattedDate ?></time>
            </div>
            <!-- Horizontal keyline: extends infinitely both left and right underneath the cards -->
            <div class="absolute top-[22px] left-[-100vw] w-[300vw] border-t border-white/60 -z-10"></div>
        </div>
    <?php endif ?>

    <article class="w-full h-full rounded-2xl overflow-hidden shadow-lg border border-white/10 bg-neutral-200/50 backdrop-blur-sm transition-all duration-300">
        <?php if ($image): ?>
            <img
                src="<?= $image->url() ?>"
                alt="<?= $image->alt()->or($sketch->title())->esc() ?>"
                loading="<?= $index < 4 ? 'eager' : 'lazy' ?>"
                class="w-full h-full object-cover grayscale-[15%] group-hover:grayscale-0 transition-all duration-500" />
        <?php else: ?>
            <!-- Fallback design framework block -->
            <div class="w-full h-full bg-neutral-400 flex items-center justify-center font-mono text-xs text-neutral-600">
                [Empty Sketch]
            </div>
        <?php endif ?>
    </article>
</div>