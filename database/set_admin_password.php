<?php
/**
 * CLI-only Admin Password Setup
 * Engineer Jules Portfolio
 *
 * Run:
 *   php database/set_admin_password.php
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("This script can only be run from the command line.\n");
}

require_once __DIR__ . '/../config/config.php';

function prompt_hidden_password(string $prompt): string
{
    if (DIRECTORY_SEPARATOR === '\\') {
        $command = '$p = Read-Host -AsSecureString "' . addslashes($prompt) . '"; ' .
                   '$bstr = [Runtime.InteropServices.Marshal]::SecureStringToBSTR($p); ' .
                   '[Runtime.InteropServices.Marshal]::PtrToStringBSTR($bstr)';

        $output = shell_exec(
            'powershell.exe -NoProfile -NonInteractive -Command ' .
            escapeshellarg($command)
        );

        return trim((string) $output);
    }

    echo $prompt;
    return trim((string) fgets(STDIN));
}

echo "========================================\n";
echo " Engineer Jules - Admin Password Setup\n";
echo "========================================\n\n";

$email = trim((string) readline("Admin email [admin@engineerjules.com]: "));

if ($email === '') {
    $email = 'admin@engineerjules.com';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Error: Invalid email address.\n");
}

$password = prompt_hidden_password("New admin password: ");

if (strlen($password) < 12) {
    exit("Error: Password must be at least 12 characters.\n");
}

$confirm = prompt_hidden_password("Confirm new password: ");

if (!hash_equals($password, $confirm)) {
    exit("Error: Passwords do not match.\n");
}

try {
    $db = Database::getConnection();

    $stmt = $db->prepare(
        'UPDATE users SET password = :password WHERE email = :email'
    );

    $stmt->execute([
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'email' => $email,
    ]);

    if ($stmt->rowCount() === 0) {
        exit("Error: No admin account was found with that email.\n");
    }

    echo "\nSuccess: Admin password updated.\n";
    echo "Email: {$email}\n";
    echo "Password hash generated with password_hash().\n";
} catch (Throwable $e) {
    exit("Error: Unable to update the admin password.\n");
}
