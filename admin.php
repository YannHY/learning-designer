<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

$admin = require_admin_page();
$db = app_db();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_same_origin_post();
    $username = sanitize_username((string)($_POST['username'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $role = (string)($_POST['role'] ?? 'designer');
    if (!in_array($role, ['admin', 'designer'], true)) {
        $role = 'designer';
    }

    if ($username === '' || $email === '' || $password === '') {
        $error = 'Nom d’utilisateur, email et mot de passe requis.';
    } elseif (strlen($password) < 8) {
        $error = 'Le mot de passe doit contenir au moins 8 caracteres.';
    } else {
        try {
            $stmt = $db->prepare("INSERT INTO users (username, email, password_hash, role, status) VALUES (?, ?, ?, ?, 'active')");
            $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $role]);
            $message = 'Compte cree avec succes.';
        } catch (PDOException $e) {
            $error = 'Impossible de creer ce compte (email ou nom deja utilise ?).';
        }
    }
}

$usersStmt = $db->query("SELECT
    u.id,
    u.username,
    u.email,
    u.role,
    u.status,
    u.created_at,
    u.last_login_at,
    COUNT(d.id) AS design_count
FROM users u
LEFT JOIN learning_designs d ON d.owner_user_id = u.id
GROUP BY u.id, u.username, u.email, u.role, u.status, u.created_at, u.last_login_at
ORDER BY u.created_at DESC");
$users = $usersStmt->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administration | Learning Designer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="interface.css?v=20260502-2">
    <link rel="stylesheet" href="account-ui.css?v=20260502-2">
    <link rel="stylesheet" href="account-pages.css">
    <style>
        body.admin-page,
        [data-theme="dark"] body.admin-page {
            background: #fff;
        }
    </style>
</head>
<body class="admin-page">
<?php render_site_nav('admin'); ?>
<main class="account-shell with-nav profile-shell">
    <section class="account-card wide">
        <div class="account-topbar">
            <div>
                <p class="account-kicker">Administration</p>
                <h1>Gestion des comptes</h1>
            </div>
        </div>

        <?php if ($message !== ''): ?>
            <p class="account-message success"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <?php if ($error !== ''): ?>
            <p class="account-message error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form method="post" class="account-form panel">
            <h2>Creer un compte</h2>
            <div class="inline-grid">
                <div>
                    <label for="username">Nom d’utilisateur</label>
                    <input id="username" name="username" type="text" required>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" required>
                </div>
                <div>
                    <label for="password">Mot de passe</label>
                    <input id="password" name="password" type="password" minlength="8" required>
                </div>
                <div>
                    <label for="role">Role</label>
                    <select id="role" name="role">
                        <option value="designer">Designer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            <button type="submit">Creer le compte</button>
        </form>

        <section class="panel">
            <h2>Comptes existants</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Productions</th>
                        <th>Statut</th>
                        <th>Cree le</th>
                        <th>Derniere connexion</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?= htmlspecialchars((string)$u['username'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string)$u['email'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string)$u['role'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= (int)$u['design_count'] ?></td>
                            <td><?= htmlspecialchars((string)$u['status'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string)$u['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string)($u['last_login_at'] ?: 'Jamais'), ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </section>
</main>
</body>
</html>
