<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
require_once ROOT_PATH . '/models/Settings.php';

$settingsModel = new Settings();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $data = [
        'site_name'        => clean($_POST['site_name'] ?? ''),
        'tagline'          => clean($_POST['tagline'] ?? ''),
        'hero_title'       => clean($_POST['hero_title'] ?? ''),
        'hero_subtitle'    => clean($_POST['hero_subtitle'] ?? ''),
        'email'            => clean($_POST['email'] ?? ''),
        'whatsapp'         => preg_replace('/[^0-9]/', '', $_POST['whatsapp'] ?? ''),
        'github'           => clean($_POST['github'] ?? ''),
        'whatsapp_message' => clean($_POST['whatsapp_message'] ?? ''),
    ];

    if ($data['site_name'] === '') $errors[] = 'Site name is required.';
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';

    if (empty($errors)) {
        $settingsModel->update($data);
        set_flash('success', 'Settings updated.');
        redirect('settings.php');
    }
}

$settings = $settingsModel->get();

$pageTitle = 'Site Settings';
$activeNav = 'settings';
require __DIR__ . '/views/layout-top.php';
?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error"><?php foreach ($errors as $err): ?><?= e($err) ?><br><?php endforeach; ?></div>
<?php endif; ?>

<form method="POST" class="admin-form">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="site_name">Site Name</label>
        <input type="text" id="site_name" name="site_name" class="form-control" value="<?= e($settings['site_name'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label for="tagline">Tagline</label>
        <input type="text" id="tagline" name="tagline" class="form-control" value="<?= e($settings['tagline'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="hero_title">Homepage Hero Title</label>
        <input type="text" id="hero_title" name="hero_title" class="form-control" value="<?= e($settings['hero_title'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="hero_subtitle">Homepage Hero Subtitle</label>
        <textarea id="hero_subtitle" name="hero_subtitle" class="form-control"><?= e($settings['hero_subtitle'] ?? '') ?></textarea>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="email">Contact Email</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= e($settings['email'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label for="whatsapp">WhatsApp Number (with country code, digits only)</label>
            <input type="text" id="whatsapp" name="whatsapp" class="form-control" placeholder="250785689108" value="<?= e($settings['whatsapp'] ?? '') ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="whatsapp_message">Default WhatsApp Message</label>
        <input type="text" id="whatsapp_message" name="whatsapp_message" class="form-control" value="<?= e($settings['whatsapp_message'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="github">GitHub Profile URL</label>
        <input type="url" id="github" name="github" class="form-control" value="<?= e($settings['github'] ?? '') ?>">
        <p class="form-hint">This is your main profile link. Individual project GitHub links are set per-project under Projects.</p>
    </div>

    <button type="submit" class="btn btn-primary">Save Settings</button>
</form>

<?php require __DIR__ . '/views/layout-bottom.php'; ?>
