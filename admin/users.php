<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
require_once ROOT_PATH . '/models/User.php';

$userModel = new User();
$errors = [];

// Delete user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    verify_csrf();
    $id = (int) ($_POST['id'] ?? 0);
    if ($id === (int) $_SESSION['admin_id']) {
        set_flash('error', 'You cannot delete your own account while logged in.');
    } elseif ($id) {
        $userModel->delete($id);
        set_flash('success', 'User deleted.');
    }
    redirect('users.php');
}

// Add new admin user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'create') {
    verify_csrf();
    $name = clean($_POST['name'] ?? '');
    $email = clean($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '') $errors[] = 'Name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';
    if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';
    if ($userModel->findByEmail($email)) $errors[] = 'That email is already registered.';

    if (empty($errors)) {
        $userModel->create($name, $email, $password);
        set_flash('success', 'Admin user created.');
        redirect('users.php');
    }
}

$users = $userModel->all();

$pageTitle = 'Users';
$activeNav = 'users';
require __DIR__ . '/views/layout-top.php';
?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error"><?php foreach ($errors as $err): ?><?= e($err) ?><br><?php endforeach; ?></div>
<?php endif; ?>

<div style="display:grid; grid-template-columns: 1fr 340px; gap:24px; align-items:start;">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>Name</th><th>Email</th><th>Role</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><strong><?= e($u['name']) ?></strong></td>
                    <td style="color:var(--text-faint);"><?= e($u['email']) ?></td>
                    <td><?= e(ucfirst($u['role'])) ?></td>
                    <td>
                        <?php if ((int)$u['id'] !== (int)$_SESSION['admin_id']): ?>
                            <form method="POST" onsubmit="return confirm('Delete this admin user?');">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                <button type="submit" class="icon-btn danger" title="Delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14z"/></svg>
                                </button>
                            </form>
                        <?php else: ?>
                            <span style="color:var(--text-faint);font-size:0.8rem;">You</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <form method="POST" class="admin-form" style="max-width:none;">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="create">
        <h3 style="margin-bottom:16px;font-size:1rem;">Add Admin User</h3>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" minlength="8" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Create User</button>
    </form>
</div>

<?php require __DIR__ . '/views/layout-bottom.php'; ?>
