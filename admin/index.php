<?php
require_once __DIR__ . '/../config/config.php';
require_admin();

require_once ROOT_PATH . '/models/Project.php';
require_once ROOT_PATH . '/models/Service.php';
require_once ROOT_PATH . '/models/Message.php';

$projectModel = new Project();
$serviceModel = new ServiceModel();
$messageModel = new Message();

$stats = [
    'projects' => $projectModel->count(),
    'services' => $serviceModel->count(),
    'messages' => $messageModel->count(),
    'unread'   => $messageModel->unreadCount(),
];

$recentMessages = array_slice($messageModel->all(), 0, 5);
$recentProjects = array_slice($projectModel->all(), 0, 5);

$pageTitle = 'Dashboard';
$activeNav = 'dashboard';
require __DIR__ . '/views/layout-top.php';
?>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label">Total Projects</div>
        <div class="stat-value"><?= $stats['projects'] ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Services Listed</div>
        <div class="stat-value"><?= $stats['services'] ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Messages</div>
        <div class="stat-value"><?= $stats['messages'] ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Unread Messages</div>
        <div class="stat-value"><?= $stats['unread'] ?></div>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px;">
    <div>
        <h3 style="margin-bottom:14px; font-size:1rem;">Recent Messages</h3>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead><tr><th>From</th><th>Type</th><th>Status</th></tr></thead>
                <tbody>
                <?php foreach ($recentMessages as $m): ?>
                    <tr>
                        <td><?= e($m['name']) ?></td>
                        <td><?= e($m['project_type'] ?: '—') ?></td>
                        <td><span class="badge-status <?= $m['is_read'] ? 'badge-read' : 'badge-unread' ?>"><?= $m['is_read'] ? 'Read' : 'New' ?></span></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($recentMessages)): ?>
                    <tr><td colspan="3" style="text-align:center;color:var(--text-faint);">No messages yet.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <h3 style="margin-bottom:14px; font-size:1rem;">Recent Projects</h3>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead><tr><th>Title</th><th>Featured</th></tr></thead>
                <tbody>
                <?php foreach ($recentProjects as $p): ?>
                    <tr>
                        <td><?= e($p['title']) ?></td>
                        <td><?= $p['featured'] ? '<span class="badge-status badge-featured">Yes</span>' : '—' ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($recentProjects)): ?>
                    <tr><td colspan="2" style="text-align:center;color:var(--text-faint);">No projects yet.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/views/layout-bottom.php'; ?>
