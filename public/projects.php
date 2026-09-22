<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/models/Project.php';

$settings = get_settings();
$projectModel = new Project();
$projects = $projectModel->all();

$currentPage = 'projects';
$pageTitle = 'Projects — ' . $settings['site_name'];
require ROOT_PATH . '/views/partials/header.php';
?>

<section class="page-header">
    <div class="container">
        <div class="breadcrumb"><a href="<?= BASE_URL ?>/index.php">Home</a> / Projects</div>
        <h1>Projects</h1>
        <p>Selected work covering commerce, hospitality and custom business tools.</p>
    </div>
</section>

<section>
    <div class="container">
        <div class="projects-list">
            <?php foreach ($projects as $project): ?>
                <?php $tech = array_filter(array_map('trim', explode(',', $project['technologies']))); ?>
                <div class="project-row">
                    <div class="project-thumb">
                        <?php if (!empty($project['image']) && file_exists(ROOT_PATH . '/public/assets/images/' . $project['image'])): ?>
                            <img src="<?= BASE_URL ?>/assets/images/<?= e($project['image']) ?>" alt="<?= e($project['title']) ?>">
                        <?php else: ?>
                            <?= e($project['title']) ?>
                        <?php endif; ?>
                    </div>
                    <div class="project-info">
                        <h3><?= e($project['title']) ?></h3>
                        <p><?= e($project['short_description']) ?></p>
                        <div class="project-tech">
                            <?php foreach ($tech as $t): ?><span><?= e($t) ?></span><?php endforeach; ?>
                        </div>
                    </div>
                    <div class="project-actions">
                        <a href="<?= BASE_URL ?>/project-details.php?slug=<?= e($project['slug']) ?>" class="btn btn-primary btn-sm">View Details</a>
                        <a href="<?= e($project['github_link']) ?>" target="_blank" rel="noopener" class="btn btn-outline btn-sm">GitHub</a>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($projects)): ?>
                <div class="empty-state">No projects added yet.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/views/partials/footer.php'; ?>
