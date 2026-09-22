<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/models/User.php';

if (is_admin_logged_in()) {
    redirect(ADMIN_URL . '/index.php');
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $email = clean($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $userModel = new User();
    $user = $userModel->attemptLogin($email, $password);

    if ($user) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_name'] = $user['name'];
        redirect(ADMIN_URL . '/index.php');
    } else {
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login — Engineer Jules</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
<link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="admin-login-body">

<div class="login-card">
    <div class="login-logo">
        <span class="logo-mark">EJ</span> Engineer Jules
    </div>
    <h1>Admin Login</h1>
    <p>Sign in to manage your portfolio.</p>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" required autofocus>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Sign In</button>
    </form>

    <p style="margin-top:20px; font-size:0.82rem;">
        <a href="<?= BASE_URL ?>/index.php" style="color:var(--accent);">&larr; Back to site</a>
    </p>
</div>

</body>
</html>
