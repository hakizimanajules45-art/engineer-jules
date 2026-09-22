<?php
/**
 * Admin layout header — expects $pageTitle and $activeNav set before include
 */
require_once ROOT_PATH . '/models/Message.php';
$msgModelForNav = new Message();
$unread = $msgModelForNav->unreadCount();
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle ?? 'Admin') ?> — Engineer Jules</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
<link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="admin-body">

<aside class="admin-sidebar">
    <div class="admin-logo">
        <span class="logo-mark">EJ</span> Admin Panel
    </div>
    <ul class="admin-nav">
        <li><a href="index.php" class="<?= $activeNav === 'dashboard' ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
            Dashboard
        </a></li>
        <li><a href="projects.php" class="<?= $activeNav === 'projects' ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4zM4 9h16M9 9v11"/></svg>
            Projects
        </a></li>
        <li><a href="services.php" class="<?= $activeNav === 'services' ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 3H5a2 2 0 0 0-2 2v4M15 3h4a2 2 0 0 1 2 2v4M9 21H5a2 2 0 0 1-2-2v-4M15 21h4a2 2 0 0 0 2-2v-4"/></svg>
            Services
        </a></li>
        <li><a href="messages.php" class="<?= $activeNav === 'messages' ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="M4 6l8 6 8-6"/></svg>
            Messages
            <?php if ($unread > 0): ?><span class="badge"><?= $unread ?></span><?php endif; ?>
        </a></li>
        <li><a href="settings.php" class="<?= $activeNav === 'settings' ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.6-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.6V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.6 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.6 1z"/></svg>
            Site Settings
        </a></li>
        <li><a href="users.php" class="<?= $activeNav === 'users' ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Users
        </a></li>
    </ul>
    <div class="admin-sidebar-footer">
        <a href="<?= BASE_URL ?>/index.php">&larr; View Site</a> &nbsp;&middot;&nbsp;
        <a href="logout.php">Logout</a>
    </div>
</aside>

<main class="admin-main">
    <div class="admin-topbar">
        <h1><?= e($pageTitle ?? 'Admin') ?></h1>
        <span style="font-size:0.88rem;color:var(--text-faint);">Hi, <?= e($_SESSION['admin_name'] ?? 'Admin') ?></span>
    </div>
    <div class="admin-content">
        <?php if ($flash = get_flash('success')): ?>
            <div class="alert alert-success"><?= e($flash) ?></div>
        <?php endif; ?>
        <?php if ($flash = get_flash('error')): ?>
            <div class="alert alert-error"><?= e($flash) ?></div>
        <?php endif; ?>
