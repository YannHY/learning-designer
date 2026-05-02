<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

$db = app_db();
if (is_admin_seed_needed($db)) {
    header('Location: setup_admin.php');
    exit;
}

if (current_user()) {
    header('Location: interface.html');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_same_origin_post();
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = 'Merci de renseigner l’email et le mot de passe.';
    } else {
        $stmt = $db->prepare("SELECT id, username, email, password_hash, role, status FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || $user['status'] !== 'active' || !password_verify($password, (string)$user['password_hash'])) {
            $error = 'Identifiants invalides.';
        } else {
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id' => (int)$user['id'],
                'username' => (string)$user['username'],
                'email' => (string)$user['email'],
                'role' => (string)$user['role'],
            ];
            $touch = $db->prepare("UPDATE users SET last_login_at = NOW() WHERE id = ?");
            $touch->execute([(int)$user['id']]);
            header('Location: interface.html');
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion | Learning Designer</title>
    <link rel="stylesheet" href="account-pages.css">
</head>
<body>
<main class="account-shell">
    <section class="account-card">
        <p class="account-kicker">Learning Designer</p>
        <h1>Connexion</h1>
        <p class="account-copy">Connectez-vous pour sauvegarder et retrouver vos productions.</p>
        <form method="post" class="account-form">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" required autocomplete="username">
            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" required autocomplete="current-password">
            <button type="submit">Se connecter</button>
        </form>
        <?php if ($error !== ''): ?>
            <p class="account-message error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <p class="account-footer"><a href="interface.html">Retour à l’interface</a></p>
    </section>
</main>
</body>
</html>
