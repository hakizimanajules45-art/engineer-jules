<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/models/Service.php';

$settings = get_settings();
$serviceModel = new ServiceModel();
$services = $serviceModel->all();

$icons = [
    'shopping-cart' => '<path d="M6 6h15l-1.5 9h-12z"/><path d="M6 6L4 3H2"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/>',
    'briefcase'     => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
    'utensils'      => '<path d="M3 2v7c0 1.1.9 2 2 2s2-.9 2-2V2M5 11v11M17 2v20M17 2c-2.2 0-4 2.2-4 5s1.8 5 4 5"/>',
    'layout-grid'   => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
    'database'      => '<ellipse cx="12" cy="5" rx="8" ry="3"/><path d="M4 5v14c0 1.7 3.6 3 8 3s8-1.3 8-3V5M4 12c0 1.7 3.6 3 8 3s8-1.3 8-3"/>',
    'plug'          => '<path d="M9 3H5a2 2 0 0 0-2 2v4M15 3h4a2 2 0 0 1 2 2v4M9 21H5a2 2 0 0 1-2-2v-4M15 21h4a2 2 0 0 0 2-2v-4"/>',
    'code'          => '<path d="M8 4L3 12l5 8M16 4l5 8-5 8"/>',
];

$currentPage = 'services';
$pageTitle = 'Services — ' . $settings['site_name'];
require ROOT_PATH . '/views/partials/header.php';
?>

<section class="page-header">
    <div class="container">
        <div class="breadcrumb"><a href="<?= BASE_URL ?>/index.php">Home</a> / Services</div>
        <h1>Services</h1>
        <p>Practical engineering help, scoped to what your project actually needs.</p>
    </div>
</section>

<section>
    <div class="container">
        <div class="services-grid">
            <?php foreach ($services as $service): ?>
                <?php $iconPath = $icons[$service['icon']] ?? $icons['code']; ?>
                <div class="service-card">
                    <div class="service-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><?= $iconPath ?></svg>
                    </div>
                    <h3><?= e($service['title']) ?></h3>
                    <p><?= e($service['description']) ?></p>
                </div>
            <?php endforeach; ?>
            <?php if (empty($services)): ?>
                <div class="empty-state" style="grid-column: 1/-1;">No services listed yet.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="cta">
    <div class="container text-center">
        <h2>Not sure what you need?</h2>
        <p style="margin: 0 auto 28px;">Tell me about the problem you're solving and I'll help you figure out the right scope.</p>
        <a href="<?= BASE_URL ?>/contact.php" class="btn btn-primary">Get in Touch</a>
    </div>
</section>

<?php require ROOT_PATH . '/views/partials/footer.php'; ?>
