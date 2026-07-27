<?php $externalLinks = site()->footerLinks()->toStructure(); ?>

</div>
<footer class="mt-16 flex gap-4">
    <?php foreach ($externalLinks as $link): ?>
        <a class="underline text-blue-700 dark:text-blue-400 hover:text-blue-950 dark:hover:text-blue-200 transition duration-300" href="<?= $link->url() ?>"><?= $link->label() ?></a>
    <?php endforeach  ?>
</footer>
</body>

</html>