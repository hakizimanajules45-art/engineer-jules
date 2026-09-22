<?php
/**
 * Shared header partial
 * Expects optional $pageTitle, $pageDescription, $currentPage variables set before include
 */
$settings = get_settings();
$pageTitle = $pageTitle ?? ($settings['site_name'] . ' — ' . $settings['tagline']);
$pageDescription = $pageDescription ?? $settings['hero_subtitle'] ?? 'Full-stack developer building modern web applications.';
$currentPage = $currentPage ?? '';
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($pageDescription) ?>">

<!-- Open Graph -->
<meta property="og:title" content="<?= e($pageTitle) ?>">
<meta property="og:description" content="<?= e($pageDescription) ?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= e($settings['site_name']) ?>">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($pageTitle) ?>">
<meta name="twitter:description" content="<?= e($pageDescription) ?>">

<!-- Structured Data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Person",
  "name": "<?= e($settings['site_name']) ?>",
  "jobTitle": "<?= e($settings['tagline']) ?>",
  "email": "<?= e($settings['email']) ?>",
  "url": "<?= e($settings['github']) ?>"
}
</script>

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
<link rel="icon" href="data:,">
</head>
<body>

<script>
    // Apply saved theme before paint to avoid flash
    (function() {
        var saved = localStorage.getItem('ej-theme');
        if (saved) document.documentElement.setAttribute('data-theme', saved);
    })();
</script>

<div class="wa-float-wrapper">
    <a class="wa-float" target="_blank" rel="noopener"
       href="<?= e(whatsapp_link($settings['whatsapp'], $settings['whatsapp_message'] ?? '')) ?>"
       aria-label="Chat on WhatsApp">
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.5 14.4c-.3-.1-1.7-.9-2-1-.3-.1-.5-.1-.7.1-.2.3-.8 1-.9 1.1-.2.2-.3.2-.6.1-.3-.1-1.2-.5-2.3-1.5-.9-.8-1.4-1.7-1.6-2-.2-.3 0-.5.1-.6.1-.1.3-.3.4-.5.1-.1.2-.3.3-.5.1-.2 0-.4 0-.5-.1-.1-.7-1.6-.9-2.2-.2-.5-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.4s1.1 2.8 1.2 3c.1.2 2.1 3.2 5.1 4.5.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.7-.7 2-1.4.2-.7.2-1.2.2-1.4-.1-.1-.3-.2-.6-.3z"/><path d="M12 2C6.5 2 2 6.5 2 12c0 1.9.5 3.7 1.5 5.3L2 22l4.8-1.5C8.4 21.5 10.2 22 12 22c5.5 0 10-4.5 10-10S17.5 2 12 2zm0 18.2c-1.6 0-3.2-.4-4.5-1.2l-.3-.2-3.2 1 1-3.1-.2-.3C4 15 3.5 13.5 3.5 12c0-4.7 3.8-8.5 8.5-8.5s8.5 3.8 8.5 8.5-3.8 8.5-8.5 8.5z"/></svg>
    </a>
</div>

<header class="navbar">
    <div class="navbar-inner">
        <a href="<?= BASE_URL ?>/index.php" class="logo">
            <span class="logo-mark">EJ</span>
            <?= e($settings['site_name']) ?>
        </a>

        <nav>
            <ul class="nav-links" id="navLinks">
                <li><a href="<?= BASE_URL ?>/index.php" class="<?= $currentPage === 'home' ? 'active' : '' ?>">Home</a></li>
                <li><a href="<?= BASE_URL ?>/about.php" class="<?= $currentPage === 'about' ? 'active' : '' ?>">About</a></li>
                <li><a href="<?= BASE_URL ?>/services.php" class="<?= $currentPage === 'services' ? 'active' : '' ?>">Services</a></li>
                <li><a href="<?= BASE_URL ?>/projects.php" class="<?= $currentPage === 'projects' ? 'active' : '' ?>">Projects</a></li>
                <li><a href="<?= BASE_URL ?>/contact.php" class="<?= $currentPage === 'contact' ? 'active' : '' ?>">Contact</a></li>
            </ul>
        </nav>

        <div class="nav-actions">
            <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode">
                <svg id="iconMoon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                <svg id="iconSun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
            </button>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
            </button>
        </div>
    </div>
</header>
