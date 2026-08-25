<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

$error = '';
$verificationRequired = false;
try {
    $db = app_db();
    if (is_admin_seed_needed($db)) {
        header('Location: setup_admin.php');
        exit;
    }

    if (current_user()) {
        header('Location: designer.html');
        exit;
    }
} catch (Throwable $e) {
    $db = null;
    $error = 'Le stockage utilisateur n’a pas pu etre initialise. Verifiez la configuration ou les droits d’ecriture du dossier data/.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_same_origin_post();
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($db === null) {
        $error = 'Le stockage utilisateur n’est pas disponible pour le moment.';
    } elseif ($email === '' || $password === '') {
        $error = 'Merci de renseigner l’email et le mot de passe.';
    } else {
        $stmt = $db->prepare("SELECT id, username, email, password_hash, role, status, email_verified_at FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || $user['status'] !== 'active' || !password_verify($password, (string)$user['password_hash'])) {
            $error = 'Identifiants invalides.';
        } elseif ($user['email_verified_at'] === null || trim((string)$user['email_verified_at']) === '') {
            app_start_session();
            $_SESSION['pending_verification_email'] = (string)$user['email'];
            $verificationRequired = true;
            $error = 'Votre adresse email doit être vérifiée avant la première connexion.';
        } else {
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id' => (int)$user['id'],
                'username' => (string)$user['username'],
                'email' => (string)$user['email'],
                'role' => (string)$user['role'],
            ];
            $touch = $db->prepare("UPDATE users SET last_login_at = CURRENT_TIMESTAMP WHERE id = ?");
            $touch->execute([(int)$user['id']]);
            header('Location: designer.html');
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
    <link rel="icon" href="assets/favicon.svg?v=20260804" type="image/svg+xml" sizes="any">
    <title>Connexion | Learning Designer</title>
    <?php render_theme_boot_script(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="css/interface.css?v=20260823-import-models">
    <link rel="stylesheet" href="css/account-ui.css?v=20260520-4">
    <link rel="stylesheet" href="css/account-pages.css?v=20260825-autofill-sombre">
</head>
<body class="login-page">
<?php render_site_nav('login'); ?>
<main class="account-shell with-nav">
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
        <?php if ($verificationRequired): ?>
            <p class="account-footer"><a href="verify-email.php">Renvoyer l’email de vérification</a></p>
        <?php endif; ?>
        <p class="account-footer"><a href="signup.php">Créer un compte</a></p>
    </section>
</main>
</body>
</html>
