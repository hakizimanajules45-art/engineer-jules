<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/models/Project.php';

$settings = get_settings();
$projectModel = new Project();

$slug = clean($_GET['slug'] ?? '');
$project = $slug ? $projectModel->findBySlug($slug) : null;

if (!$project) {
    http_response_code(404);
    $currentPage = 'projects';
    $pageTitle = 'Project Not Found — ' . $settings['site_name'];
    require ROOT_PATH . '/views/partials/header.php';
    echo '<section class="container text-center" style="padding:80px 24px;"><h1>Project not found</h1><p style="margin:0 auto 24px;">This project may have been removed or the link is incorrect.</p><a href="' . BASE_URL . '/projects.php" class="btn btn-primary">Back to Projects</a></section>';
    require ROOT_PATH . '/views/partials/footer.php';
    exit;
}

$tech = array_filter(array_map('trim', explode(',', $project['technologies'] ?? '')));
$features = array_filter(array_map('trim', explode("\n", $project['features'] ?? '')));
$gallery = array_filter(array_map('trim', explode(',', $project['gallery'] ?? '')));

$currentPage = 'projects';
$pageTitle = $project['title'] . ' — ' . $settings['site_name'];
$pageDescription = $project['short_description'];
require ROOT_PATH . '/views/partials/header.php';
?>

<section class="page-header">
    <div class="container">
        <div class="breadcrumb"><a href="<?= BASE_URL ?>/index.php">Home</a> / <a href="<?= BASE_URL ?>/projects.php">Projects</a> / <?= e($project['title']) ?></div>
        <h1><?= e($project['title']) ?></h1>
        <p><?= e($project['short_description']) ?></p>
    </div>
</section>

<section style="padding-top: 0;">
    <div class="container">
        <div class="detail-hero">
            <?php if (!empty($project['image']) && file_exists(ROOT_PATH . '/public/assets/images/' . $project['image'])): ?>
                <img src="<?= BASE_URL ?>/assets/images/<?= e($project['image']) ?>" alt="<?= e($project['title']) ?>">
            <?php endif; ?>
        </div>

        <div class="detail-grid">
            <div>
                <h2>Overview</h2>
                <p><?= nl2br(e($project['description'])) ?></p>

                <?php if (!empty($features)): ?>
                    <h2 style="margin-top:40px;">Features</h2>
                    <ul class="feature-list">
                        <?php foreach ($features as $feature): ?>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                                <?= e($feature) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if (!empty($gallery)): ?>
                    <h2 style="margin-top:40px;">Screenshots</h2>
                    <div class="gallery-grid">
                        <?php foreach ($gallery as $img): ?>
                            <div class="g-item">
                                <?php if (file_exists(ROOT_PATH . '/public/assets/images/' . $img)): ?>
                                    <img src="<?= BASE_URL ?>/assets/images/<?= e($img) ?>" alt="Screenshot">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <aside class="detail-sidebar">
                <h4>Technology Stack</h4>
                <div class="project-tech" style="margin-bottom:24px;">
                    <?php foreach ($tech as $t): ?><span><?= e($t) ?></span><?php endforeach; ?>
                </div>

                <a href="<?= e($project['live_demo']) ?>" target="_blank" rel="noopener" class="btn btn-primary">Live Demo</a>
                <a href="<?= e($project['github_link']) ?>" target="_blank" rel="noopener" class="btn btn-outline">View on GitHub</a>
            </aside>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/views/partials/footer.php'; ?>
