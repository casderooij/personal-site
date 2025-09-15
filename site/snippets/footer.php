<?php $externalLinks = $site->footerLinks()->toStructure(); ?>

<footer class="float float--left">
    <div class="float-inner footer-inner">
        <div class="links-container">
            <?php foreach ($externalLinks as $link):
                snippet('external-link', ['label' => $link->label(), 'url' => $link->url()]);
            endforeach  ?>
        </div>
    </div>
</footer>
</body>

</html>