<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/models/Project.php';
require_once ROOT_PATH . '/models/Service.php';

$settings = get_settings();
$projectModel = new Project();
$serviceModel = new ServiceModel();

$featuredProjects = $projectModel->featured(3);
$services = array_slice($serviceModel->all(), 0, 6);

$currentPage = 'home';
$pageTitle = $settings['site_name'] . ' — ' . $settings['tagline'];
require ROOT_PATH . '/views/partials/header.php';
?>

<section class="hero">
    <div class="container hero-grid">
        <div>
            <span class="hero-eyebrow"><span class="dot"></span> Available for new projects</span>
            <h1><?= e($settings['hero_title']) ?></h1>
            <p class="lead"><?= e($settings['hero_subtitle']) ?></p>

            <div class="hero-actions">
                <a href="<?= BASE_URL ?>/projects.php" class="btn btn-primary">View Projects</a>
                <a href="<?= BASE_URL ?>/contact.php" class="btn btn-outline">Contact Me</a>
            </div>

            <div class="hero-stack">
                <span>PHP</span>
                <span>MySQL</span>
                <span>JavaScript</span>
                <span>Tailwind</span>
                <span>REST API</span>
                <span>Git</span>
            </div>
        </div>

        <div class="terminal" aria-hidden="true">
            <div class="terminal-bar">
                <span class="terminal-dot red"></span>
                <span class="terminal-dot yellow"></span>
                <span class="terminal-dot green"></span>
                <span class="terminal-title">jules@engineer — profile.js</span>
            </div>
            <div class="terminal-body" id="terminalBody"></div>
        </div>
    </div>
</section>

<section id="about-preview">
    <div class="container">
        <div class="section-head">
            <h2>Engineering, end to end</h2>
            <p>From database schema to the pixel on screen — I handle the full stack so nothing gets lost in translation between design and deployment.</p>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 17l6-6-6-6M12 19h8"/></svg></div>
                <h3>Full Stack Development</h3>
                <p>Building complete web applications from the database up to a polished, responsive interface.</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18"/></svg></div>
                <h3>Backend Engineering</h3>
                <p>Writing clean, secure server-side logic that stays maintainable as your product grows.</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="8" ry="3"/><path d="M4 5v14c0 1.7 3.6 3 8 3s8-1.3 8-3V5M4 12c0 1.7 3.6 3 8 3s8-1.3 8-3"/></svg></div>
                <h3>Database Design</h3>
                <p>Structuring data efficiently so queries stay fast and your schema scales with the business.</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 3H5a2 2 0 0 0-2 2v4M15 3h4a2 2 0 0 1 2 2v4M9 21H5a2 2 0 0 1-2-2v-4M15 21h4a2 2 0 0 0 2-2v-4"/></svg></div>
                <h3>API Integration</h3>
                <p>Connecting your app to the third-party services it needs, with clean, well-documented endpoints.</p>
            </div>
        </div>
    </div>
</section>

<section id="projects-preview">
    <div class="container">
        <div class="section-head">
            <h2>Recent work</h2>
            <p>A few projects that show how I approach real problems — from commerce to hospitality.</p>
        </div>

        <div class="projects-list">
            <?php foreach ($featuredProjects as $project): ?>
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
            <?php if (empty($featuredProjects)): ?>
                <div class="empty-state">No featured projects yet. Check back soon.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="cta">
    <div class="container text-center">
        <h2>Have a project in mind?</h2>
        <p style="margin: 0 auto 28px;">Let's talk through what you're building and figure out the right approach.</p>
        <div class="hero-actions" style="justify-content:center;">
            <a href="<?= BASE_URL ?>/contact.php" class="btn btn-primary">Start a Conversation</a>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/views/partials/footer.php'; ?>
