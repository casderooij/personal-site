// Save to: site/templates/home.php

<?php snippet('head'); ?>

<div class="min-h-screen bg-[#f3f3f3] text-neutral-900 selection:bg-neutral-900 selection:text-white">

    <!-- Minimalist Nav Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-neutral-200 px-6 py-4 flex items-center justify-between">
        <div class="font-mono text-sm uppercase tracking-wider font-bold">
            <a href="<?= site()->url() ?>">Cas de Rooij</a>
        </div>

        <!-- Apple Calendar Style Controls -->
        <div class="flex items-center gap-4">
            <a href="<?= $todayUrl ?>" class="px-3 py-1.5 text-xs font-semibold bg-white border border-neutral-200 rounded-md hover:bg-neutral-50 transition-colors shadow-sm">
                Today
            </a>
            <div class="flex items-center bg-white border border-neutral-200 rounded-md overflow-hidden shadow-sm">
                <a href="<?= $prevWeekUrl ?>" class="p-2 border-r border-neutral-200 hover:bg-neutral-50 transition-colors" aria-label="Previous Week">
                    <svg class="w-4 h-4 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <a href="<?= $nextWeekUrl ?>" class="p-2 hover:bg-neutral-50 transition-colors" aria-label="Next Week">
                    <svg class="w-4 h-4 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="pt-20 px-0 md:px-2 w-full mx-auto">
        <!-- Month Header -->
        <div class="mt-6 mb-4 px-4 md:px-6">
            <h1 class="text-xl md:text-2xl font-bold tracking-tight text-neutral-800">
                <?= esc($weekTitle) ?>
            </h1>
        </div>

        <!-- 7-Column Calendar Grid -->
        <div class="grid grid-cols-1 md:grid-cols-7 gap-px bg-neutral-200 border-y md:border border-neutral-200">
            <?php foreach ($days as $day): ?>
                <div class="bg-white flex flex-col overflow-hidden relative <?= $day['isToday'] ? 'ring-2 ring-red-500 z-10' : '' ?>">

                    <!-- Calendar Day Indicator -->
                    <div class="px-4 py-3 border-b border-neutral-100 flex flex-row md:flex-col justify-between md:justify-center items-center gap-1 bg-neutral-50/70">
                        <span class="text-[10px] font-bold tracking-wider text-neutral-400 uppercase font-mono">
                            <?= esc($day['dayName']) ?>
                        </span>

                        <span class="flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold transition-all <?= $day['isToday'] ? 'bg-red-500 text-white font-extrabold shadow-sm' : 'text-neutral-800' ?>">
                            <?= esc($day['dayNum']) ?>
                        </span>
                    </div>

                    <!-- Sketch Display Box -->
                    <div class="flex-1 min-h-[320px] md:min-h-[calc(100vh-220px)] flex flex-col justify-between bg-white relative group">
                        <?php if ($day['sketch']): ?>
                            <?php
                            $sketch = $day['sketch'];
                            $image  = $sketch->gallery()->isNotEmpty() ? $sketch->gallery()->toFile() : $sketch->images()->first();
                            ?>

                            <!-- Full Edge-to-Edge Responsive Image with click behavior -->
                            <?php if ($image): ?>
                                <button
                                    class="w-full h-full relative overflow-hidden bg-neutral-100 text-left block cursor-zoom-in focus:outline-none"
                                    onclick="openLightbox('<?= $image->url() ?>', '<?= $sketch->title()->js() ?>')"
                                    aria-label="View fullscreen sketch">
                                    <?php snippet('responsive-image', [
                                        'image' => $image,
                                        'class' => 'w-full h-full object-cover grayscale-[10%] group-hover:grayscale-0 group-hover:scale-[1.02] transition-all duration-700 ease-out',
                                        'lazy'  => !$day['isToday']
                                    ]); ?>
                                </button>
                            <?php endif; ?>

                            <!-- Minimal Hover Overlay -->
                            <div class="absolute inset-x-2 bottom-2 p-2.5 bg-white/90 backdrop-blur-md rounded border border-neutral-100 opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-300 shadow-md">
                                <h3 class="font-bold text-xs text-neutral-900 truncate"><?= $sketch->title()->esc() ?></h3>
                                <?php if ($sketch->tags()->isNotEmpty()): ?>
                                    <p class="text-[9px] text-neutral-500 font-mono mt-0.5 truncate"><?= esc($sketch->tags()) ?></p>
                                <?php endif; ?>
                            </div>

                        <?php else: ?>
                            <!-- Minimal clean empty state grid space -->
                            <div class="flex-1 flex flex-col items-center justify-center text-center bg-neutral-50/20 hover:bg-neutral-50/60 transition-colors h-full">
                                <span class="text-[10px] font-mono font-medium text-neutral-300">Empty</span>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>

<!-- Pure JS Fullscreen Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 z-50 bg-neutral-950/95 backdrop-blur-lg flex flex-col items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 ease-out" onclick="closeLightbox()">

    <!-- Close Button -->
    <button class="absolute top-6 right-6 text-white/70 hover:text-white transition-colors p-2" onclick="closeLightbox()" aria-label="Close lightbox">
        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Lightbox Main Frame -->
    <div class="max-w-[90vw] max-h-[80vh] flex items-center justify-center relative p-4" onclick="event.stopPropagation()">
        <img id="lightbox-img" src="" alt="" class="max-w-full max-h-full rounded-lg shadow-2xl border border-white/5 object-contain" />
    </div>

    <!-- Metadata Display -->
    <div id="lightbox-caption" class="text-center text-white/80 font-medium text-sm mt-4 font-mono select-none px-4"></div>
</div>

<script>
    function openLightbox(imgUrl, title) {
        const lightbox = document.getElementById('lightbox');
        const img = document.getElementById('lightbox-img');
        const caption = document.getElementById('lightbox-caption');

        img.src = imgUrl;
        img.alt = title;
        caption.textContent = title;

        lightbox.classList.remove('opacity-0', 'pointer-events-none');
        document.body.style.overflow = 'hidden'; // Stop background scrolling

        // ESC key event listener
        document.addEventListener('keydown', handleEscClose);
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.add('opacity-0', 'pointer-events-none');
        document.body.style.overflow = ''; // Re-enable background scrolling
        document.removeEventListener('keydown', handleEscClose);
    }

    function handleEscClose(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    }
</script>

<?php snippet('footer'); ?>