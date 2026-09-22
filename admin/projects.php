<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
require_once ROOT_PATH . '/models/Project.php';

$projectModel = new Project();

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    verify_csrf();
    $id = (int) ($_POST['id'] ?? 0);
    if ($id) {
        $projectModel->delete($id);
        set_flash('success', 'Project deleted.');
    }
    redirect('projects.php');
}

$projects = $projectModel->all();

$pageTitle = 'Projects';
$activeNav = 'projects';
require __DIR__ . '/views/layout-top.php';
?>

<div class="page-actions">
    <p style="margin:0;color:var(--text-faint);font-size:0.9rem;">Manage the projects shown on your portfolio.</p>
    <a href="project-form.php" class="btn btn-primary btn-sm">+ Add Project</a>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Technologies</th>
            <th>Featured</th>
            <th>Links</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($projects as $p): ?>
            <tr>
                <td><strong><?= e($p['title']) ?></strong></td>
                <td style="color:var(--text-faint);font-size:0.85rem;"><?= e($p['technologies']) ?></td>
                <td><?= $p['featured'] ? '<span class="badge-status badge-featured">Featured</span>' : '—' ?></td>
                <td>
                    <a href="<?= e($p['github_link']) ?>" target="_blank" style="color:var(--accent);font-size:0.85rem;">GitHub</a>
                </td>
                <td>
                    <div class="table-actions">
                        <a href="project-form.php?id=<?= $p['id'] ?>" class="icon-btn" title="Edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.1 2.1 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
                        </a>
                        <form method="POST" onsubmit="return confirm('Delete this project? This cannot be undone.');" style="display:inline;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <button type="submit" class="icon-btn danger" title="Delete">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14z"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($projects)): ?>
            <tr><td colspan="5" style="text-align:center;color:var(--text-faint);padding:32px;">No projects yet. <a href="project-form.php" style="color:var(--accent);">Add your first one</a>.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/views/layout-bottom.php'; ?>
