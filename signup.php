<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

$error = '';
try {
    $db = app_db();
    if (is_admin_seed_needed($db)) {
        header('Location: setup_admin.php');
        exit;
    }

    if (current_user()) {
        header('Location: index.html');
        exit;
    }
} catch (Throwable $e) {
    $db = null;
    $error = 'Le stockage utilisateur n’a pas pu être initialisé. Vérifiez la configuration ou les droits d’écriture du dossier data/.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_same_origin_post();
    $username = sanitize_username((string)($_POST['username'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($db === null) {
        $error = 'Le stockage utilisateur n’est pas disponible pour le moment.';
    } elseif ($username === '' || $email === '' || $password === '') {
        $error = 'Nom d’utilisateur, email et mot de passe requis.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Adresse email invalide.';
    } elseif (strlen($password) < 8) {
        $error = 'Le mot de passe doit contenir au moins 8 caractères.';
    } else {
        try {
            $stmt = $db->prepare("INSERT INTO users (username, email, password_hash, role, status, last_login_at) VALUES (?, ?, ?, 'designer', 'active', CURRENT_TIMESTAMP)");
            $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT)]);

            $userId = (int)$db->lastInsertId();
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id' => $userId,
                'username' => $username,
                'email' => $email,
                'role' => 'designer',
            ];

            header('Location: index.html');
            exit;
        } catch (PDOException $e) {
            $error = 'Impossible de créer ce compte (email ou nom déjà utilisé ?).';
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créer un compte | Learning Designer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="interface.css?v=20260520-2">
    <link rel="stylesheet" href="account-ui.css?v=20260520-4">
    <link rel="stylesheet" href="account-pages.css?v=20260521-width">
</head>
<body class="signup-page">
<?php render_site_nav('signup'); ?>
<main class="account-shell with-nav">
    <section class="account-card">
        <p class="account-kicker">Learning Designer</p>
        <h1>Créer un compte</h1>
        <p class="account-copy">Inscrivez-vous pour sauvegarder vos productions et les retrouver plus tard.</p>
        <form method="post" class="account-form">
            <label for="username">Nom d’utilisateur</label>
            <input id="username" name="username" type="text" required autocomplete="nickname">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" required autocomplete="username">
            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" minlength="8" required autocomplete="new-password">
            <button type="submit">Créer mon compte</button>
        </form>
        <?php if ($error !== ''): ?>
            <p class="account-message error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <p class="account-footer"><a href="login.php">J’ai déjà un compte</a></p>
    </section>
</main>
</body>
</html>
