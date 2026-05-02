<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

$error = '';
try {
    $db = app_db();
    if (!is_admin_seed_needed($db)) {
        header('Location: login.php');
        exit;
    }
} catch (Throwable $e) {
    $db = null;
    $error = 'Le stockage utilisateur n’a pas pu etre initialise. Verifiez la configuration ou les droits d’ecriture du dossier data/.';
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
        $error = 'Le mot de passe doit contenir au moins 8 caracteres.';
    } else {
        try {
            $stmt = $db->prepare("INSERT INTO users (username, email, password_hash, role, status) VALUES (?, ?, ?, 'admin', 'active')");
            $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT)]);
            header('Location: login.php');
            exit;
        } catch (PDOException $e) {
            $error = 'Impossible de creer ce compte (email ou nom deja utilise ?).';
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Premier compte admin | Learning Designer</title>
    <link rel="stylesheet" href="account-pages.css">
</head>
<body>
<main class="account-shell">
    <section class="account-card">
        <p class="account-kicker">Configuration initiale</p>
        <h1>Creer le premier compte admin</h1>
        <p class="account-copy">Cette page n’apparait que tant qu’aucun administrateur n’existe dans la base.</p>
        <form method="post" class="account-form">
            <label for="username">Nom d’utilisateur</label>
            <input id="username" name="username" type="text" required>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" required>
            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" minlength="8" required>
            <button type="submit">Creer l’administrateur</button>
        </form>
        <?php if ($error !== ''): ?>
            <p class="account-message error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
