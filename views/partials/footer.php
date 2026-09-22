<?php $fSettings = get_settings(); ?>
<footer class="footer">
    <div class="container footer-inner">
        <small>&copy; <?= date('Y') ?> <?= e($fSettings['site_name']) ?>. All rights reserved.</small>
        <ul class="footer-links">
            <li><a href="mailto:<?= e($fSettings['email']) ?>">Email</a></li>
            <li><a href="<?= e(whatsapp_link($fSettings['whatsapp'], $fSettings['whatsapp_message'] ?? '')) ?>" target="_blank" rel="noopener">WhatsApp</a></li>
            <li><a href="<?= e($fSettings['github']) ?>" target="_blank" rel="noopener">GitHub</a></li>
        </ul>
    </div>
</footer>

<script src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>
</html>
