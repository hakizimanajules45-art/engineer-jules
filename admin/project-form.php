<?php
require_once __DIR__ . '/../config/config.php';
require_admin();
require_once ROOT_PATH . '/models/Project.php';

$projectModel = new Project();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$project = $id ? $projectModel->find($id) : null;
$isEdit = $project !== null;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $title = clean($_POST['title'] ?? '');
    $shortDescription = clean($_POST['short_description'] ?? '');
    $description = clean($_POST['description'] ?? '');
    $features = clean($_POST['features'] ?? '');
    $technologies = clean($_POST['technologies'] ?? '');
    $githubLink = clean($_POST['github_link'] ?? '');
    $liveDemo = clean($_POST['live_demo'] ?? '');
    $gallery = clean($_POST['gallery'] ?? '');
    $featured = isset($_POST['featured']) ? 1 : 0;
    $sortOrder = (int) ($_POST['sort_order'] ?? 0);
    $image = clean($_POST['image'] ?? ($project['image'] ?? ''));

    if ($title === '') $errors[] = 'Title is required.';
    if ($githubLink === '') $errors[] = 'GitHub link is required (use a placeholder if not ready).';

    // Handle image upload if provided
    if (!empty($_FILES['image_upload']['name'])) {
        $uploadDir = ROOT_PATH . '/public/assets/images/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $ext = strtolower(pathinfo($_FILES['image_upload']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ext, $allowed)) {
            $errors[] = 'Image must be jpg, jpeg, png, or webp.';
        } else {
            $filename = 'project-' . time() . '-' . bin2hex(random_bytes(3)) . '.' . $ext;
            if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $uploadDir . $filename)) {
                $image = $filename;
            } else {
                $errors[] = 'Image upload failed.';
            }
        }
    }

    if (empty($errors)) {
        $slug = slugify($title);
        // Ensure slug uniqueness (append id-safe suffix if needed)
        $existingBySlug = $projectModel->findBySlug($slug);
        if ($existingBySlug && (!$isEdit || $existingBySlug['id'] != $id)) {
            $slug .= '-' . substr(md5((string) time()), 0, 4);
        }

        $data = [
            'title'             => $title,
            'slug'              => $slug,
            'short_description' => $shortDescription,
            'description'       => $description,
            'features'          => $features,
            'technologies'      => $technologies,
            'github_link'       => $githubLink,
            'live_demo'         => $liveDemo ?: '#',
            'image'             => $image,
            'gallery'           => $gallery,
            'featured'          => $featured,
            'sort_order'        => $sortOrder,
        ];

        if ($isEdit) {
            $projectModel->update($id, $data);
            set_flash('success', 'Project updated.');
        } else {
            $projectModel->create($data);
            set_flash('success', 'Project created.');
        }
        redirect('projects.php');
    }
}

$pageTitle = $isEdit ? 'Edit Project' : 'Add Project';
$activeNav = 'projects';
require __DIR__ . '/views/layout-top.php';
?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $err): ?><?= e($err) ?><br><?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" class="admin-form" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="title">Project Title</label>
        <input type="text" id="title" name="title" class="form-control" value="<?= e($project['title'] ?? $_POST['title'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label for="short_description">Short Description (shown on cards)</label>
        <input type="text" id="short_description" name="short_description" class="form-control" value="<?= e($project['short_description'] ?? $_POST['short_description'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="description">Full Description</label>
        <textarea id="description" name="description" class="form-control" style="min-height:100px;"><?= e($project['description'] ?? $_POST['description'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <label for="features">Features (one per line)</label>
        <textarea id="features" name="features" class="form-control" style="min-height:100px;"><?= e($project['features'] ?? $_POST['features'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <label for="technologies">Technologies (comma-separated)</label>
        <input type="text" id="technologies" name="technologies" class="form-control" placeholder="PHP, MySQL, JavaScript" value="<?= e($project['technologies'] ?? $_POST['technologies'] ?? '') ?>">
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="github_link">GitHub Link</label>
            <input type="url" id="github_link" name="github_link" class="form-control" value="<?= e($project['github_link'] ?? $_POST['github_link'] ?? 'https://github.com/engineerjules/') ?>" required>
        </div>
        <div class="form-group">
            <label for="live_demo">Live Demo Link</label>
            <input type="text" id="live_demo" name="live_demo" class="form-control" value="<?= e($project['live_demo'] ?? $_POST['live_demo'] ?? '#') ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="image_upload">Project Image</label>
        <input type="file" id="image_upload" name="image_upload" class="form-control" accept=".jpg,.jpeg,.png,.webp">
        <?php if (!empty($project['image'])): ?>
            <p class="form-hint">Current: <?= e($project['image']) ?> (upload a new file to replace it)</p>
        <?php endif; ?>
        <input type="hidden" name="image" value="<?= e($project['image'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label for="gallery">Gallery Filenames (comma-separated, files placed in /public/assets/images/)</label>
        <input type="text" id="gallery" name="gallery" class="form-control" value="<?= e($project['gallery'] ?? $_POST['gallery'] ?? '') ?>">
    </div>

    <div class="form-row">
        <div class="checkbox-row">
            <input type="checkbox" id="featured" name="featured" <?= !empty($project['featured']) ? 'checked' : '' ?>>
            <label for="featured" style="margin:0;">Show on homepage (featured)</label>
        </div>
        <div class="form-group">
            <label for="sort_order">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?= e((string)($project['sort_order'] ?? 0)) ?>">
        </div>
    </div>

    <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update Project' : 'Create Project' ?></button>
    <a href="projects.php" class="btn btn-outline">Cancel</a>
</form>

<?php require __DIR__ . '/views/layout-bottom.php'; ?>
