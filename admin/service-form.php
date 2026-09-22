<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
require_once ROOT_PATH . '/models/Service.php';

$serviceModel = new ServiceModel();
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$service = $id ? $serviceModel->find($id) : null;
$isEdit = $service !== null;

$iconOptions = ['shopping-cart', 'briefcase', 'utensils', 'layout-grid', 'database', 'plug', 'code'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $title = clean($_POST['title'] ?? '');
    $description = clean($_POST['description'] ?? '');
    $icon = clean($_POST['icon'] ?? 'code');
    $sortOrder = (int) ($_POST['sort_order'] ?? 0);

    if ($title === '') $errors[] = 'Title is required.';

    if (empty($errors)) {
        $data = compact('title', 'description', 'icon', 'sortOrder');
        $data = ['title' => $title, 'description' => $description, 'icon' => $icon, 'sort_order' => $sortOrder];

        if ($isEdit) {
            $serviceModel->update($id, $data);
            set_flash('success', 'Service updated.');
        } else {
            $serviceModel->create($data);
            set_flash('success', 'Service created.');
        }
        redirect('services.php');
    }
}

$pageTitle = $isEdit ? 'Edit Service' : 'Add Service';
$activeNav = 'services';
require __DIR__ . '/views/layout-top.php';
?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error"><?php foreach ($errors as $err): ?><?= e($err) ?><br><?php endforeach; ?></div>
<?php endif; ?>

<form method="POST" class="admin-form">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="title">Service Title</label>
        <input type="text" id="title" name="title" class="form-control" value="<?= e($service['title'] ?? $_POST['title'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" class="form-control" style="min-height:100px;"><?= e($service['description'] ?? $_POST['description'] ?? '') ?></textarea>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="icon">Icon</label>
            <select id="icon" name="icon" class="form-control">
                <?php foreach ($iconOptions as $opt): ?>
                    <option value="<?= e($opt) ?>" <?= (($service['icon'] ?? '') === $opt) ? 'selected' : '' ?>><?= e($opt) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="sort_order">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?= e((string)($service['sort_order'] ?? 0)) ?>">
        </div>
    </div>

    <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update Service' : 'Create Service' ?></button>
    <a href="services.php" class="btn btn-outline">Cancel</a>
</form>

<?php require __DIR__ . '/views/layout-bottom.php'; ?>
