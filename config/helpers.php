<?php
/**
 * Global Helper Functions
 * Engineer Jules Portfolio
 */

/**
 * Escape output for safe HTML rendering (XSS protection)
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Generate (or reuse) a CSRF token for the current session
 */
function csrf_token(): string
{
    if (empty($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/**
 * Output a hidden CSRF input field
 */
function csrf_field(): string
{
    return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . e(csrf_token()) . '">';
}

/**
 * Verify a submitted CSRF token; kills the request on failure
 */
function verify_csrf(): void
{
    $submitted = $_POST[CSRF_TOKEN_NAME] ?? '';
    if (empty($submitted) || empty($_SESSION[CSRF_TOKEN_NAME]) || !hash_equals($_SESSION[CSRF_TOKEN_NAME], $submitted)) {
        http_response_code(403);
        die('Invalid CSRF token. Please refresh the page and try again.');
    }
}

/**
 * Sanitize a plain text string
 */
function clean(string $value): string
{
    return trim(strip_tags($value));
}

/**
 * Redirect helper
 */
function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

/**
 * Check if an admin is currently logged in
 */
function is_admin_logged_in(): bool
{
    return !empty($_SESSION['admin_id']);
}

/**
 * Require admin login or redirect to login page
 */
function require_admin(): void
{
    if (!is_admin_logged_in()) {
        redirect(ADMIN_URL . '/login.php');
    }
}

/**
 * Fetch site settings from DB (falls back to defaults if not set)
 */
function get_settings(): array
{
    static $settings = null;

    if ($settings !== null) {
        return $settings;
    }

    $defaults = [
        'site_name' => DEFAULT_SITE_NAME,
        'email'     => DEFAULT_SITE_EMAIL,
        'whatsapp'  => DEFAULT_SITE_WHATSAPP,
        'github'    => DEFAULT_SITE_GITHUB,
    ];

    try {
        $db = Database::getConnection();
        $stmt = $db->query('SELECT * FROM settings ORDER BY id ASC LIMIT 1');
        $row = $stmt->fetch();
        $settings = $row ? array_merge($defaults, array_filter($row, fn($v) => $v !== null && $v !== '')) : $defaults;
    } catch (Throwable $e) {
        $settings = $defaults;
    }

    return $settings;
}

/**
 * Build a wa.me link with a pre-filled message
 */
function whatsapp_link(string $number, string $message = ''): string
{
    $number = preg_replace('/[^0-9]/', '', $number);
    $url = 'https://wa.me/' . $number;
    if ($message !== '') {
        $url .= '?text=' . rawurlencode($message);
    }
    return $url;
}

/**
 * Simple slug generator
 */
function slugify(string $text): string
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = trim($text, '-');
    $text = strtolower($text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    return $text ?: 'n-a';
}

/**
 * Flash message helper (set)
 */
function set_flash(string $key, string $message): void
{
    $_SESSION['flash'][$key] = $message;
}

/**
 * Flash message helper (get + clear)
 */
function get_flash(string $key): ?string
{
    if (!empty($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $message;
    }
    return null;
}
