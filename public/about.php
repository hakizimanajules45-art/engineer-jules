<?php
require_once __DIR__ . '/../config/config.php';

$settings = get_settings();
$currentPage = 'about';
$pageTitle = 'About — ' . $settings['site_name'];
require ROOT_PATH . '/views/partials/header.php';
?>

<section class="page-header">
    <div class="container">
        <div class="breadcrumb"><a href="<?= BASE_URL ?>/index.php">Home</a> / About</div>
        <h1>About Me</h1>
        <p>The engineering approach, skills and experience behind the work.</p>
    </div>
</section>

<section>
    <div class="container about-grid">
        <div>
            <h2>What I do</h2>
            <p>I'm a full-stack developer who builds web applications that solve concrete business problems — online stores, booking systems, and internal tools that need to work reliably from day one. My focus is on writing code that's easy to maintain, not just code that works today.</p>
            <p>Every project starts with understanding the actual workflow it needs to support, then choosing the simplest architecture that gets it there without cutting corners on security or performance.</p>

            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-year">2026</div>
                    <strong>Independent Software Engineer</strong>
                    <p style="margin-top:4px;">Designing and building full-stack web applications for clients across e-commerce, hospitality and business services.</p>
                </div>
            </div>
        </div>

        <div>
            <ul class="skill-list">
                <li>
                    <span class="skill-num">01</span>
                    <div>
                        <strong>Full Stack Development</strong>
                        <span class="desc">End-to-end ownership of an application — from schema design to the interface a user actually touches.</span>
                    </div>
                </li>
                <li>
                    <span class="skill-num">02</span>
                    <div>
                        <strong>Backend Engineering</strong>
                        <span class="desc">Server-side logic built in PHP with a focus on clarity, security and predictable behavior under load.</span>
                    </div>
                </li>
                <li>
                    <span class="skill-num">03</span>
                    <div>
                        <strong>Database Design</strong>
                        <span class="desc">Normalized, indexed MySQL schemas that stay fast as data grows, with migrations that don't break production.</span>
                    </div>
                </li>
                <li>
                    <span class="skill-num">04</span>
                    <div>
                        <strong>API Integration</strong>
                        <span class="desc">REST-style APIs and third-party integrations — payments, messaging, maps — wired up cleanly and documented.</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/views/partials/footer.php'; ?>
