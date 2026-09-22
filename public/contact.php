<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/models/Message.php';

$settings = get_settings();
$messageModel = new Message();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $name = clean($_POST['name'] ?? '');
    $email = clean($_POST['email'] ?? '');
    $projectType = clean($_POST['project_type'] ?? '');
    $messageText = clean($_POST['message'] ?? '');

    if ($name === '') $errors[] = 'Name is required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';
    if ($messageText === '') $errors[] = 'Message cannot be empty.';

    if (empty($errors)) {
        $messageModel->create([
            'name'         => $name,
            'email'        => $email,
            'project_type' => $projectType,
            'message'      => $messageText,
        ]);
        $success = true;
        // Clear posted values after success
        $name = $email = $projectType = $messageText = '';
    }
}

$currentPage = 'contact';
$pageTitle = 'Contact — ' . $settings['site_name'];
require ROOT_PATH . '/views/partials/header.php';
?>

<section class="page-header">
    <div class="container">
        <div class="breadcrumb"><a href="<?= BASE_URL ?>/index.php">Home</a> / Contact</div>
        <h1>Let's Talk</h1>
        <p>Tell me about your project and I'll get back to you within a day or two.</p>
    </div>
</section>

<section style="padding-top:0;">
    <div class="container contact-grid">
        <div>
            <h2>Reach out directly</h2>
            <p>Prefer a quicker channel? Message me on WhatsApp or send an email — both go straight to me.</p>

            <div class="contact-methods">
                <a class="contact-method" href="mailto:<?= e($settings['email']) ?>">
                    <div class="contact-method-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 6 10-6"/></svg>
                    </div>
                    <div>
                        <div class="label">Email</div>
                        <div class="value"><?= e($settings['email']) ?></div>
                    </div>
                </a>
                <a class="contact-method" href="<?= e(whatsapp_link($settings['whatsapp'], $settings['whatsapp_message'] ?? '')) ?>" target="_blank" rel="noopener">
                    <div class="contact-method-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    </div>
                    <div>
                        <div class="label">WhatsApp</div>
                        <div class="value">+<?= e($settings['whatsapp']) ?></div>
                    </div>
                </a>
                <a class="contact-method" href="<?= e($settings['github']) ?>" target="_blank" rel="noopener">
                    <div class="contact-method-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                    </div>
                    <div>
                        <div class="label">GitHub</div>
                        <div class="value">View Profile</div>
                    </div>
                </a>
            </div>
        </div>

        <div>
            <h2>Send a message</h2>

            <?php if ($success): ?>
                <div class="alert alert-success">Thanks — your message has been sent. I'll be in touch soon.</div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <?php foreach ($errors as $err): ?><?= e($err) ?><br><?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/contact.php">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= e($name ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?= e($email ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="project_type">Project Type</label>
                    <select id="project_type" name="project_type" class="form-control">
                        <option value="">Select a category</option>
                        <option value="E-Commerce" <?= (($projectType ?? '') === 'E-Commerce') ? 'selected' : '' ?>>E-Commerce</option>
                        <option value="Business Website" <?= (($projectType ?? '') === 'Business Website') ? 'selected' : '' ?>>Business Website</option>
                        <option value="Restaurant Website" <?= (($projectType ?? '') === 'Restaurant Website') ? 'selected' : '' ?>>Restaurant Website</option>
                        <option value="Custom Web App" <?= (($projectType ?? '') === 'Custom Web App') ? 'selected' : '' ?>>Custom Web App</option>
                        <option value="Other" <?= (($projectType ?? '') === 'Other') ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" class="form-control" required><?= e($messageText ?? '') ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/views/partials/footer.php'; ?>
