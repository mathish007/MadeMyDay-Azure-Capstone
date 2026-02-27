<?php
// MadeMyDay Capstone - DB connection
// Recommended: create /var/www/html/.env (copy from .env.example) and set values.
// Fallback: hardcode values below if you prefer.

function load_env($path) {
    if (!file_exists($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $key = trim($parts[0]);
            $val = trim($parts[1]);
            $_ENV[$key] = $val;
        }
    }
}

load_env(__DIR__ . '/.env');

$host = $_ENV['DB_HOST'] ?? '10.0.1.5';
$user = $_ENV['DB_USER'] ?? 'mademydayuser';
$pass = $_ENV['DB_PASS'] ?? 'StrongPassword123';
$db   = $_ENV['DB_NAME'] ?? 'mademyday';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}
?>
