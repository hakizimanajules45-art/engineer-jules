<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
require_once ROOT_PATH . '/models/Message.php';

$messageModel = new Message();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);

    if ($id && $action === 'delete') {
        $messageModel->delete($id);
        set_flash('success', 'Message deleted.');
    } elseif ($id && $action === 'mark_read') {
        $messageModel->markRead($id);
        set_flash('success', 'Message marked as read.');
    }
    redirect('messages.php');
}

// View single message (mark as read automatically)
$viewId = isset($_GET['view']) ? (int) $_GET['view'] : 0;
$viewMessage = null;
if ($viewId) {
    $viewMessage = $messageModel->find($viewId);
    if ($viewMessage && !$viewMessage['is_read']) {
        $messageModel->markRead($viewId);
        $viewMessage['is_read'] = 1;
    }
}

$messages = $messageModel->all();

$pageTitle = 'Messages';
$activeNav = 'messages';
require __DIR__ . '/views/layout-top.php';
?>

<?php if ($viewMessage): ?>
    <div class="admin-form" style="margin-bottom:28px;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
            <div>
                <h3 style="margin-bottom:4px;"><?= e($viewMessage['name']) ?></h3>
                <p style="margin:0;color:var(--text-faint);font-size:0.88rem;"><?= e($viewMessage['email']) ?> &middot; <?= e($viewMessage['project_type'] ?: 'General inquiry') ?></p>
            </div>
            <a href="messages.php" class="icon-btn" title="Close"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></a>
        </div>
        <p style="margin-top:18px;white-space:pre-wrap;color:var(--text);"><?= e($viewMessage['message']) ?></p>
        <div style="display:flex;gap:10px;margin-top:20px;">
            <a href="mailto:<?= e($viewMessage['email']) ?>" class="btn btn-primary btn-sm">Reply by Email</a>
            <form method="POST" onsubmit="return confirm('Delete this message?');">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $viewMessage['id'] ?>">
                <button type="submit" class="btn btn-outline btn-sm">Delete</button>
            </form>
        </div>
    </div>
<?php endif; ?>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>Name</th><th>Email</th><th>Type</th><th>Status</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($messages as $m): ?>
            <tr>
                <td><a href="messages.php?view=<?= $m['id'] ?>" style="color:var(--text);font-weight:600;"><?= e($m['name']) ?></a></td>
                <td style="color:var(--text-faint);"><?= e($m['email']) ?></td>
                <td><?= e($m['project_type'] ?: '—') ?></td>
                <td><span class="badge-status <?= $m['is_read'] ? 'badge-read' : 'badge-unread' ?>"><?= $m['is_read'] ? 'Read' : 'New' ?></span></td>
                <td>
                    <div class="table-actions">
                        <a href="messages.php?view=<?= $m['id'] ?>" class="icon-btn" title="View">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                        <form method="POST" onsubmit="return confirm('Delete this message?');" style="display:inline;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $m['id'] ?>">
                            <button type="submit" class="icon-btn danger" title="Delete">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14z"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($messages)): ?>
            <tr><td colspan="5" style="text-align:center;color:var(--text-faint);padding:32px;">No messages received yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/views/layout-bottom.php'; ?>
