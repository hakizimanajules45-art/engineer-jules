<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
require_once ROOT_PATH . '/models/Service.php';

$serviceModel = new ServiceModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    verify_csrf();
    $id = (int) ($_POST['id'] ?? 0);
    if ($id) {
        $serviceModel->delete($id);
        set_flash('success', 'Service deleted.');
    }
    redirect('services.php');
}

$services = $serviceModel->all();

$pageTitle = 'Services';
$activeNav = 'services';
require __DIR__ . '/views/layout-top.php';
?>

<div class="page-actions">
    <p style="margin:0;color:var(--text-faint);font-size:0.9rem;">Manage the services listed on your site.</p>
    <a href="service-form.php" class="btn btn-primary btn-sm">+ Add Service</a>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Description</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($services as $s): ?>
            <tr>
                <td><strong><?= e($s['title']) ?></strong></td>
                <td style="color:var(--text-faint);font-size:0.85rem;"><?= e(mb_strimwidth($s['description'], 0, 80, '...')) ?></td>
                <td>
                    <div class="table-actions">
                        <a href="service-form.php?id=<?= $s['id'] ?>" class="icon-btn" title="Edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.1 2.1 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
                        </a>
                        <form method="POST" onsubmit="return confirm('Delete this service?');" style="display:inline;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $s['id'] ?>">
                            <button type="submit" class="icon-btn danger" title="Delete">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14z"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($services)): ?>
            <tr><td colspan="3" style="text-align:center;color:var(--text-faint);padding:32px;">No services yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/views/layout-bottom.php'; ?>
