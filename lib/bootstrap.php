<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.use_strict_mode', '1');
    $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function app_file_config(): array
{
    static $config = null;
    if (is_array($config)) {
        return $config;
    }

    $config = [];
    $projectRoot = dirname(__DIR__);
    $parent1 = dirname($projectRoot);
    $parent2 = dirname($parent1);
    $parent3 = dirname($parent2);
    $candidates = [
        $projectRoot . '/app-config.php',
        $projectRoot . '/learning-design-secret.php',
        $projectRoot . '/config.local.php',
        $parent1 . '/learning-design-secret.php',
        $parent2 . '/learning-design-secret.php',
        $parent3 . '/learning-design-secret.php',
        $parent1 . '/config.local.php',
        $parent2 . '/config.local.php',
        $parent3 . '/config.local.php',
    ];

    foreach ($candidates as $path) {
        if (!is_file($path)) {
            continue;
        }
        $loaded = require $path;
        if (is_array($loaded)) {
            $config = array_replace($config, $loaded);
        }
    }

    return $config;
}

function app_env(string $key): ?string
{
    $envValue = getenv($key);
    if ($envValue !== false && $envValue !== '') {
        return (string)$envValue;
    }

    if (isset($_SERVER[$key]) && (string)$_SERVER[$key] !== '') {
        return (string)$_SERVER[$key];
    }

    $fileConfig = app_file_config();
    if (array_key_exists($key, $fileConfig) && (string)$fileConfig[$key] !== '') {
        return (string)$fileConfig[$key];
    }

    return null;
}

function app_is_https(): bool
{
    return !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
}

function app_base_url(): string
{
    $configured = trim((string)(app_env('APP_BASE_URL') ?? ''));
    if ($configured !== '') {
        return rtrim($configured, '/');
    }

    $scheme = app_is_https() ? 'https' : 'http';
    $host = trim((string)($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost'));
    if ($host === '') {
        $host = 'localhost';
    }

    $scriptDir = trim((string)dirname((string)($_SERVER['SCRIPT_NAME'] ?? '')));
    $scriptDir = str_replace('\\', '/', $scriptDir);
    if ($scriptDir === '/' || $scriptDir === '.') {
        $scriptDir = '';
    }

    return $scheme . '://' . $host . $scriptDir;
}

function app_origin_url(): string
{
    $scheme = app_is_https() ? 'https' : 'http';
    $host = trim((string)($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost'));
    if ($host === '') {
        $host = 'localhost';
    }
    return $scheme . '://' . $host;
}

function app_default_sqlite_path(): string
{
    return dirname(__DIR__) . '/data/learning-designer.sqlite';
}

function app_db(): PDO
{
    static $db = null;
    if ($db instanceof PDO) {
        return $db;
    }

    $dsn = trim((string)(app_env('APP_DB_DSN') ?? ''));
    $dbUser = (string)(app_env('APP_DB_USER') ?? '');
    $dbPass = (string)(app_env('APP_DB_PASS') ?? '');

    if ($dsn === '') {
        $dbHost = trim((string)(app_env('APP_DB_HOST') ?? ''));
        $dbName = trim((string)(app_env('APP_DB_NAME') ?? ''));
        if ($dbHost !== '' && $dbName !== '') {
            $dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";
        } else {
            $sqlitePath = trim((string)(app_env('APP_DB_SQLITE_PATH') ?? ''));
            if ($sqlitePath === '') {
                $sqlitePath = app_default_sqlite_path();
            }
            $sqliteDir = dirname($sqlitePath);
            if (!is_dir($sqliteDir) && !mkdir($sqliteDir, 0775, true) && !is_dir($sqliteDir)) {
                throw new RuntimeException("Impossible de creer le dossier de stockage local.");
            }
            $dsn = 'sqlite:' . $sqlitePath;
        }
    }

    if ($dsn === '') {
        throw new RuntimeException(
            "Configuration base de donnees manquante."
        );
    }

    $isSqlite = str_starts_with($dsn, 'sqlite:');
    if (!$isSqlite && $dbUser === '') {
        throw new RuntimeException(
            "Configuration base de donnees manquante (APP_DB_DSN ou APP_DB_HOST/APP_DB_NAME + APP_DB_USER + APP_DB_PASS)."
        );
    }

    $db = new PDO($dsn, $isSqlite ? null : $dbUser, $isSqlite ? null : $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    if ($isSqlite) {
        $db->exec('PRAGMA foreign_keys = ON');
    }

    ensure_app_tables($db);
    return $db;
}

function ensure_app_tables(PDO $db): void
{
    if ($db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite') {
        $db->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            email TEXT NOT NULL UNIQUE,
            password_hash TEXT NOT NULL,
            role TEXT NOT NULL DEFAULT 'designer' CHECK (role IN ('admin','designer')),
            status TEXT NOT NULL DEFAULT 'active' CHECK (status IN ('active','disabled')),
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            last_login_at TEXT NULL
        )");

        $db->exec("CREATE TABLE IF NOT EXISTS learning_designs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            owner_user_id INTEGER NOT NULL,
            title TEXT NOT NULL DEFAULT '',
            document_json TEXT NOT NULL,
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (owner_user_id) REFERENCES users(id) ON DELETE CASCADE
        )");

        $db->exec("CREATE INDEX IF NOT EXISTS idx_learning_designs_owner ON learning_designs(owner_user_id)");
        return;
    }

    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(80) NOT NULL UNIQUE,
        email VARCHAR(190) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        role ENUM('admin','designer') NOT NULL DEFAULT 'designer',
        status ENUM('active','disabled') NOT NULL DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        last_login_at DATETIME NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $db->exec("CREATE TABLE IF NOT EXISTS learning_designs (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        owner_user_id INT UNSIGNED NOT NULL,
        title VARCHAR(255) NOT NULL DEFAULT '',
        document_json LONGTEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_learning_designs_owner (owner_user_id),
        CONSTRAINT fk_learning_designs_owner
            FOREIGN KEY (owner_user_id) REFERENCES users(id)
            ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

function current_user(): ?array
{
    if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
        return null;
    }
    return $_SESSION['user'];
}

function require_login_json(): array
{
    $user = current_user();
    if (!$user) {
        http_response_code(401);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(['success' => false, 'error' => 'Authentification requise']);
        exit;
    }
    return $user;
}

function require_login_page(): array
{
    $user = current_user();
    if (!$user) {
        header('Location: login.php');
        exit;
    }
    return $user;
}

function require_admin_page(): array
{
    $user = require_login_page();
    if (($user['role'] ?? '') !== 'admin') {
        http_response_code(403);
        echo 'Acces refuse.';
        exit;
    }
    return $user;
}

function is_admin_seed_needed(PDO $db): bool
{
    $stmt = $db->query("SELECT COUNT(*) FROM users WHERE role = 'admin'");
    return ((int)$stmt->fetchColumn()) === 0;
}

function sanitize_username(string $value): string
{
    $value = trim($value);
    $value = preg_replace('/\s+/u', '_', $value) ?? '';
    $value = preg_replace('/[^\p{L}\p{N}_.-]/u', '', $value) ?? '';
    return mb_substr($value, 0, 80, 'UTF-8');
}

function require_same_origin_post(bool $allowJson = false): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
        http_response_code(405);
        exit;
    }

    $origin = trim((string)($_SERVER['HTTP_ORIGIN'] ?? ''));
    $referer = trim((string)($_SERVER['HTTP_REFERER'] ?? ''));
    $baseUrl = app_base_url();
    $originUrl = app_origin_url();
    $basePath = (string)(parse_url($baseUrl, PHP_URL_PATH) ?? '');
    if ($basePath === '/') {
        $basePath = '';
    }

    $matches = false;
    if ($origin !== '') {
        $originScheme = (string)(parse_url($origin, PHP_URL_SCHEME) ?? '');
        $originHost = (string)(parse_url($origin, PHP_URL_HOST) ?? '');
        $appScheme = (string)(parse_url($originUrl, PHP_URL_SCHEME) ?? '');
        $appHost = (string)(parse_url($originUrl, PHP_URL_HOST) ?? '');
        $originPort = (int)(parse_url($origin, PHP_URL_PORT) ?? 0);
        $appPort = (int)(parse_url($originUrl, PHP_URL_PORT) ?? 0);
        if (
            $originScheme !== '' &&
            $originHost !== '' &&
            $originScheme === $appScheme &&
            $originHost === $appHost &&
            $originPort === $appPort
        ) {
            $matches = true;
        }
    }
    if (!$matches && $referer !== '') {
        $refererOrigin = (string)(parse_url($referer, PHP_URL_SCHEME) ?? '') . '://' . (string)(parse_url($referer, PHP_URL_HOST) ?? '');
        $refererPath = (string)(parse_url($referer, PHP_URL_PATH) ?? '');
        $refererPort = (int)(parse_url($referer, PHP_URL_PORT) ?? 0);
        $appPort = (int)(parse_url($originUrl, PHP_URL_PORT) ?? 0);
        if (
            $refererOrigin === $originUrl &&
            $refererPort === $appPort &&
            ($basePath === '' || str_starts_with($refererPath, $basePath))
        ) {
            $matches = true;
        }
    }

    if (!$matches && !$allowJson) {
        http_response_code(403);
        exit('Requete refusee.');
    }
    if (!$matches && $allowJson) {
        header('Content-Type: application/json; charset=UTF-8');
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Requete refusee']);
        exit;
    }
}

function app_json_input(): array
{
    $raw = file_get_contents('php://input');
    $data = json_decode((string)$raw, true);
    return is_array($data) ? $data : [];
}

function app_json_response(array $payload, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function app_design_title_from_document(array $document): string
{
    $title = trim((string)($document['meta']['name'] ?? ''));
    if ($title !== '') {
        return mb_substr($title, 0, 255, 'UTF-8');
    }

    return 'Production sans titre';
}
