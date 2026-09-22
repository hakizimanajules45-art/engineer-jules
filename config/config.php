<?php
/**
 * Global Site Configuration
 * Engineer Jules Portfolio
 */

// Error reporting - set to 0 in production
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session security settings (must be set before session_start)
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
    ini_set('session.cookie_samesite', 'Lax');
    session_start();
}

// Base paths / URLs — adjust BASE_URL to match your XAMPP folder name
define('BASE_URL', '/engineer-jules/public');
define('ADMIN_URL', '/engineer-jules/admin');
define('ROOT_PATH', dirname(__DIR__));
define('UPLOAD_PATH', ROOT_PATH . '/uploads');
define('UPLOAD_URL', '/engineer-jules/uploads');

// Default site info (overridable from Admin > Site Settings, stored in DB)
define('DEFAULT_SITE_NAME', 'Engineer Jules');
define('DEFAULT_SITE_EMAIL', 'engineerjules250@gmail.com');
define('DEFAULT_SITE_WHATSAPP', '250785689108'); // no + and no leading 0 changes, used for wa.me links
define('DEFAULT_SITE_GITHUB', 'https://github.com/engineerjules');

// CSRF token lifetime not strictly needed (session-based), included for clarity
define('CSRF_TOKEN_NAME', 'csrf_token');

require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/config/helpers.php';
