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
            foreach ($loaded as $key => $value) {
                $valueString = is_scalar($value) ? trim((string)$value) : '';
                $currentString = array_key_exists($key, $config) && is_scalar($config[$key])
                    ? trim((string)$config[$key])
                    : '';
                if (!array_key_exists($key, $config) || ($currentString === '' && $valueString !== '')) {
                    $config[$key] = $value;
                }
            }
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
        $base = rtrim($configured, '/');
        $configuredPath = (string)(parse_url($base, PHP_URL_PATH) ?? '');
        if ($configuredPath !== '' && $configuredPath !== '/') {
            return $base;
        }

        $scriptDir = app_script_base_path();
        return $base . $scriptDir;
    }

    $scheme = app_is_https() ? 'https' : 'http';
    $host = trim((string)($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost'));
    if ($host === '') {
        $host = 'localhost';
    }

    return $scheme . '://' . $host . app_script_base_path();
}

function app_script_base_path(): string
{
    $scriptDir = trim((string)dirname((string)($_SERVER['SCRIPT_NAME'] ?? '')));
    $scriptDir = str_replace('\\', '/', $scriptDir);
    if ($scriptDir === '/' || $scriptDir === '.') {
        return '';
    }

    return '/' . trim($scriptDir, '/');
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
    ensure_app_migrations($db);
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

        $db->exec("CREATE TABLE IF NOT EXISTS learning_cli_tokens (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            name TEXT NOT NULL DEFAULT 'CLI',
            token_hash TEXT NOT NULL UNIQUE,
            token_prefix TEXT NOT NULL DEFAULT '',
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            last_used_at TEXT NULL,
            revoked_at TEXT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )");

        $db->exec("CREATE INDEX IF NOT EXISTS idx_learning_cli_tokens_user ON learning_cli_tokens(user_id)");
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

    $db->exec("CREATE TABLE IF NOT EXISTS learning_cli_tokens (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED NOT NULL,
        name VARCHAR(120) NOT NULL DEFAULT 'CLI',
        token_hash CHAR(64) NOT NULL UNIQUE,
        token_prefix VARCHAR(16) NOT NULL DEFAULT '',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        last_used_at DATETIME NULL,
        revoked_at DATETIME NULL,
        INDEX idx_learning_cli_tokens_user (user_id),
        CONSTRAINT fk_learning_cli_tokens_user
            FOREIGN KEY (user_id) REFERENCES users(id)
            ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

function ensure_app_migrations(PDO $db): void
{
    $isSqlite = $db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite';

    if ($isSqlite) {
        $db->exec("CREATE TABLE IF NOT EXISTS learning_cli_tokens (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            name TEXT NOT NULL DEFAULT 'CLI',
            token_hash TEXT NOT NULL UNIQUE,
            token_prefix TEXT NOT NULL DEFAULT '',
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            last_used_at TEXT NULL,
            revoked_at TEXT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )");
        $db->exec("CREATE INDEX IF NOT EXISTS idx_learning_cli_tokens_user ON learning_cli_tokens(user_id)");

        $cols = $db->query("PRAGMA table_info(learning_designs)")->fetchAll();
        $colNames = array_column($cols, 'name');
        if (!in_array('share_token', $colNames, true)) {
            $db->exec("ALTER TABLE learning_designs ADD COLUMN share_token TEXT NULL");
            $db->exec("CREATE UNIQUE INDEX IF NOT EXISTS idx_learning_designs_share_token ON learning_designs(share_token) WHERE share_token IS NOT NULL");
        }
        if (!in_array('is_published', $colNames, true)) {
            $db->exec("ALTER TABLE learning_designs ADD COLUMN is_published INTEGER NOT NULL DEFAULT 0");
        }
        return;
    }

    $db->exec("CREATE TABLE IF NOT EXISTS learning_cli_tokens (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED NOT NULL,
        name VARCHAR(120) NOT NULL DEFAULT 'CLI',
        token_hash CHAR(64) NOT NULL UNIQUE,
        token_prefix VARCHAR(16) NOT NULL DEFAULT '',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        last_used_at DATETIME NULL,
        revoked_at DATETIME NULL,
        INDEX idx_learning_cli_tokens_user (user_id),
        CONSTRAINT fk_learning_cli_tokens_user_migration
            FOREIGN KEY (user_id) REFERENCES users(id)
            ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $stmt = $db->prepare("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'learning_designs' AND COLUMN_NAME = 'share_token'");
    $stmt->execute();
    if ((int)$stmt->fetchColumn() === 0) {
        $db->exec("ALTER TABLE learning_designs ADD COLUMN share_token VARCHAR(64) NULL UNIQUE");
    }

    $stmt = $db->prepare("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'learning_designs' AND COLUMN_NAME = 'is_published'");
    $stmt->execute();
    if ((int)$stmt->fetchColumn() === 0) {
        $db->exec("ALTER TABLE learning_designs ADD COLUMN is_published TINYINT(1) NOT NULL DEFAULT 0");
    }
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

function require_cli_token_json(): array
{
    $header = trim((string)($_SERVER['HTTP_AUTHORIZATION'] ?? ''));
    $token = trim((string)($_SERVER['HTTP_X_LEARNING_CLI_TOKEN'] ?? ''));
    if ($header === '' && function_exists('apache_request_headers')) {
        $headers = apache_request_headers();
        foreach ($headers as $key => $value) {
            if (strcasecmp((string)$key, 'Authorization') === 0) {
                $header = trim((string)$value);
            }
            if ($token === '' && strcasecmp((string)$key, 'X-Learning-CLI-Token') === 0) {
                $token = trim((string)$value);
            }
        }
    }
    if ($token === '' && preg_match('/^Bearer\s+(.+)$/i', $header, $matches)) {
        $token = trim((string)$matches[1]);
    }
    if ($token === '') {
        app_json_response(['success' => false, 'error' => 'Jeton CLI requis.'], 401);
    }

    $db = app_db();
    $hash = hash('sha256', $token);
    $stmt = $db->prepare("SELECT t.id AS token_id, u.id, u.username, u.email, u.role, u.status
        FROM learning_cli_tokens t
        JOIN users u ON u.id = t.user_id
        WHERE t.token_hash = ? AND t.revoked_at IS NULL
        LIMIT 1");
    $stmt->execute([$hash]);
    $user = $stmt->fetch();
    if (!$user || (string)($user['status'] ?? '') !== 'active') {
        app_json_response(['success' => false, 'error' => 'Jeton CLI invalide.'], 401);
    }

    $db->prepare("UPDATE learning_cli_tokens SET last_used_at = CURRENT_TIMESTAMP WHERE id = ?")
        ->execute([(int)$user['token_id']]);

    return [
        'id' => (int)$user['id'],
        'username' => (string)$user['username'],
        'email' => (string)$user['email'],
        'role' => (string)$user['role'],
    ];
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

function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function render_site_nav(string $active = ''): void
{
    $user = current_user();
    $isAdmin = (string)($user['role'] ?? '') === 'admin';
    $username = trim((string)($user['username'] ?? $user['email'] ?? ''));
    $homeClass = $active === 'home' ? ' nav-account-btn-active' : '';
    $savesClass = $active === 'saves' ? ' nav-account-btn-active' : '';
    $cliClass = $active === 'cli' ? ' nav-account-btn-active' : '';
    $profileClass = $active === 'profile' ? ' nav-account-btn-active' : '';
    $adminClass = $active === 'admin' ? ' nav-account-btn-active' : '';
    ?>
    <header class="site-nav site-nav-page" role="navigation" aria-label="Navigation principale" data-site-i18n-attr="aria-label" data-site-i18n-en="Main navigation" data-site-i18n-fr="Navigation principale">
        <div class="site-nav-brand">
            <a class="site-nav-brand-link" href="index.html" aria-label="Accueil Learning Designer" data-site-i18n-attr="aria-label" data-site-i18n-en="Learning Designer home" data-site-i18n-fr="Accueil Learning Designer">
                <span class="site-nav-brand-mark" aria-hidden="true"></span>
                <div class="site-nav-brand-copy">
                    <p class="site-nav-title">Learning Designer</p>
                </div>
            </a>
        </div>
        <div class="site-nav-actions">
            <label for="lang-select" class="sr-only" data-site-i18n-en="Interface language" data-site-i18n-fr="Langue de l'interface">Langue de l'interface</label>
            <select id="lang-select" class="nav-lang-select" aria-label="Langue de l'interface" data-site-i18n-attr="aria-label" data-site-i18n-en="Interface language" data-site-i18n-fr="Langue de l'interface">
                <option value="fr">FR</option>
                <option value="en">EN</option>
            </select>
            <button id="theme-toggle-btn" class="theme-toggle-btn" type="button" aria-label="Basculer le thème sombre/clair" title="Thème sombre / clair" data-site-i18n-attr="aria-label,title" data-site-i18n-en="Toggle dark/light theme" data-site-i18n-fr="Basculer le thème sombre/clair">
                <svg class="theme-icon-sun" viewBox="0 0 24 24" aria-hidden="true" width="18" height="18">
                    <path fill="currentColor" d="M12 7a5 5 0 1 0 0 10A5 5 0 0 0 12 7zm0-5a1 1 0 0 1 1 1v1a1 1 0 0 1-2 0V3a1 1 0 0 1 1-1zm0 18a1 1 0 0 1 1 1v1a1 1 0 0 1-2 0v-1a1 1 0 0 1 1-1zM5 12a1 1 0 0 1-1 1H3a1 1 0 0 1 0-2h1a1 1 0 0 1 1 1zm16 0a1 1 0 0 1-1 1h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 1 1zM6.34 7.76a1 1 0 0 1 0-1.42l.7-.7a1 1 0 1 1 1.42 1.42l-.71.71a1 1 0 0 1-1.41-.01zm9.9 9.9a1 1 0 0 1 0-1.42l.7-.7a1 1 0 0 1 1.42 1.42l-.71.71a1 1 0 0 1-1.41-.01zM6.34 17.66a1 1 0 0 1-1.41.01l-.71-.71a1 1 0 0 1 1.42-1.42l.7.7a1 1 0 0 1 0 1.42zM17.66 6.34a1 1 0 0 1-1.41.01l-.71-.71a1 1 0 0 1 1.42-1.42l.7.7a1 1 0 0 1 0 1.42z"/>
                </svg>
                <svg class="theme-icon-moon" viewBox="0 0 24 24" aria-hidden="true" width="18" height="18">
                    <path fill="currentColor" d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9c0-.46-.04-.92-.1-1.36a5.389 5.389 0 0 1-4.4 2.26 5.403 5.403 0 0 1-3.14-9.8c-.44-.06-.9-.1-1.36-.1z"/>
                </svg>
            </button>
            <div class="account-toolbar-cluster">
                <a class="nav-icon-btn<?= $homeClass ?>" href="index.html" title="Editeur" aria-label="Editeur" data-site-i18n-attr="title,aria-label" data-site-i18n-en="Editor" data-site-i18n-fr="Editeur">
                    <i class="fa-solid fa-house" aria-hidden="true"></i>
                </a>
                <a class="nav-icon-btn<?= $cliClass ?>" href="cli.php" title="CLI et IA" aria-label="CLI et IA" data-site-i18n-attr="title,aria-label" data-site-i18n-en="CLI and AI" data-site-i18n-fr="CLI et IA">
                    <i class="fa-solid fa-code" aria-hidden="true"></i>
                </a>
                <?php if ($user): ?>
                    <a class="nav-account-btn<?= $savesClass ?>" href="my-designs.php">
                        <i class="fa-regular fa-folder-open" aria-hidden="true"></i>
                        <span class="nav-account-label">Designs</span>
                    </a>
                    <div class="account-menu-wrap">
                        <button id="account-menu-btn" class="nav-account-btn<?= $profileClass !== '' || $adminClass !== '' ? ' nav-account-btn-active' : '' ?>" type="button" aria-expanded="false" aria-controls="account-menu">
                            <i class="fa-solid fa-user-check" aria-hidden="true"></i>
                            <span class="nav-account-label" data-site-i18n-en="Account" data-site-i18n-fr="Compte">Compte</span>
                        </button>
                        <div id="account-menu" class="account-menu hidden" role="menu" aria-hidden="true">
                            <a class="account-menu-link<?= $profileClass ?>" role="menuitem" href="profile.php" data-site-i18n-en="Profile" data-site-i18n-fr="Profil">Profil</a>
                            <?php if ($isAdmin): ?>
                                <a class="account-menu-link<?= $adminClass ?>" role="menuitem" href="admin.php" data-site-i18n-en="Administration" data-site-i18n-fr="Administration">Administration</a>
                            <?php endif; ?>
                            <a class="account-menu-link" role="menuitem" href="logout.php" data-site-i18n-en="Sign out" data-site-i18n-fr="Déconnexion">Déconnexion</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a class="nav-account-btn<?= $active === 'signup' ? ' nav-account-btn-active' : '' ?>" href="signup.php">
                        <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                        <span class="nav-account-label" data-site-i18n-en="Create account" data-site-i18n-fr="Créer un compte">Créer un compte</span>
                    </a>
                    <a class="nav-account-btn<?= $active === 'login' ? ' nav-account-btn-active' : '' ?>" href="login.php">
                        <i class="fa-regular fa-user" aria-hidden="true"></i>
                        <span class="nav-account-label" data-site-i18n-en="Sign in" data-site-i18n-fr="Connexion">Connexion</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var html = document.documentElement;
        var savedTheme = '';
        try {
            savedTheme = localStorage.getItem('learningDesignerTheme') || '';
        } catch (error) {
            savedTheme = '';
        }
        if (savedTheme === 'dark') {
            html.setAttribute('data-theme', 'dark');
        }

        var themeButton = document.getElementById('theme-toggle-btn');
        if (themeButton) {
            themeButton.addEventListener('click', function () {
                var isDark = html.getAttribute('data-theme') === 'dark';
                if (isDark) {
                    html.removeAttribute('data-theme');
                    try {
                        localStorage.setItem('learningDesignerTheme', 'light');
                    } catch (error) {
                    }
                } else {
                    html.setAttribute('data-theme', 'dark');
                    try {
                        localStorage.setItem('learningDesignerTheme', 'dark');
                    } catch (error) {
                    }
                }
            });
        }

        function applySiteNavLanguage(lang) {
            document.querySelectorAll('[data-site-i18n-en]').forEach(function (el) {
                var value = lang === 'en' ? el.dataset.siteI18nEn : el.dataset.siteI18nFr;
                if (!value) return;
                var attrs = (el.dataset.siteI18nAttr || '').split(',').map(function (attr) {
                    return attr.trim();
                }).filter(Boolean);
                if (attrs.length) {
                    attrs.forEach(function (attr) {
                        el.setAttribute(attr, value);
                    });
                } else {
                    el.textContent = value;
                }
            });
        }

        var langSelect = document.getElementById('lang-select');
        if (langSelect) {
            var savedLang = 'fr';
            try {
                savedLang = localStorage.getItem('learningDesignerLang') || 'fr';
            } catch (error) {
                savedLang = 'fr';
            }
            if (savedLang !== 'fr' && savedLang !== 'en') {
                savedLang = 'fr';
            }
            langSelect.value = savedLang;
            html.setAttribute('lang', savedLang);
            applySiteNavLanguage(savedLang);
            langSelect.addEventListener('change', function () {
                html.setAttribute('lang', langSelect.value);
                applySiteNavLanguage(langSelect.value);
                try {
                    localStorage.setItem('learningDesignerLang', langSelect.value);
                } catch (error) {
                }
            });
        }

        var button = document.getElementById('account-menu-btn');
        var menu = document.getElementById('account-menu');
        if (!button || !menu) {
            return;
        }

        function closeMenu() {
            menu.classList.add('hidden');
            menu.setAttribute('aria-hidden', 'true');
            button.setAttribute('aria-expanded', 'false');
        }

        button.addEventListener('click', function () {
            var opening = menu.classList.contains('hidden');
            if (opening) {
                menu.classList.remove('hidden');
                menu.setAttribute('aria-hidden', 'false');
                button.setAttribute('aria-expanded', 'true');
            } else {
                closeMenu();
            }
        });

        document.addEventListener('click', function (event) {
            if (!menu.contains(event.target) && !button.contains(event.target)) {
                closeMenu();
            }
        });
    });
    </script>
    <?php
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

function render_site_footer(): void
{
    ?>
    <footer class="site-footer">
        <div class="site-footer-copy-stack">
            <span class="site-footer-copy">Learning Designer — Yann Houry &amp; François Jourde — 2026 — <abbr title="Creative Commons Attribution - Partage dans les mêmes conditions">CC BY-SA</abbr></span>
            <span class="site-footer-copy">Inspiré de l'<a class="site-footer-link" href="https://www.ucl.ac.uk/learning-designer/" target="_blank" rel="noopener noreferrer">UCL Learning Designer</a> (UCL Knowledge Lab, UCL Institute of Education, 2013–2026).</span>
        </div>
        <nav class="site-footer-links" aria-label="Liens du pied de page">
            <a class="site-footer-link" href="about.php">À propos</a>
        </nav>
    </footer>
    <?php
}
