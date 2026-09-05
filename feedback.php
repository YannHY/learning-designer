<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/bootstrap.php';

const FEEDBACK_TOKEN_TTL_SECONDS = 1800;
const FEEDBACK_MIN_COMPLETION_SECONDS = 2;
const FEEDBACK_COOLDOWN_SECONDS = 20;
const FEEDBACK_MAX_PER_HOUR = 5;
const FEEDBACK_RETENTION_SECONDS = 63072000;

app_start_session();
header('Cache-Control: no-store, max-age=0');

function issue_feedback_token(): string
{
    $token = bin2hex(random_bytes(24));
    $_SESSION['feedback_token'] = $token;
    $_SESSION['feedback_token_issued_at'] = time();
    return $token;
}

function feedback_visitor_hash(): string
{
    $ip = trim((string)($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
    $agent = mb_substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 300, 'UTF-8');
    $secret = trim((string)(app_env('APP_FEEDBACK_HASH_KEY') ?? ''));
    if ($secret === '') {
        $secret = hash('sha256', __DIR__ . '|' . app_base_url());
    }

    // La date limite la corrélation du visiteur à une seule journée tout en
    // permettant le contrôle de fréquence nécessaire à l'antispam.
    return hash_hmac(
        'sha256',
        $ip . "\n" . $agent . "\n" . session_id(),
        $secret . '|' . gmdate('Y-m-d')
    );
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
    $issuedAt = (int)($_SESSION['feedback_token_issued_at'] ?? 0);
    $token = (string)($_SESSION['feedback_token'] ?? '');
    if ($token === '' || $issuedAt <= 0 || $issuedAt < time() - FEEDBACK_TOKEN_TTL_SECONDS) {
        $token = issue_feedback_token();
    }

    app_json_response(['success' => true, 'token' => $token]);
}

require_same_origin_post(true);
$input = app_json_input();

// Les robots qui remplissent ce champ invisible reçoivent une réponse neutre,
// sans que leur contenu soit enregistré.
if (trim((string)($input['website'] ?? '')) !== '') {
    unset($_SESSION['feedback_token'], $_SESSION['feedback_token_issued_at']);
    app_json_response(['success' => true]);
}

$token = (string)($input['token'] ?? '');
$sessionToken = (string)($_SESSION['feedback_token'] ?? '');
$issuedAt = (int)($_SESSION['feedback_token_issued_at'] ?? 0);
$now = time();

if (
    $token === '' ||
    $sessionToken === '' ||
    !hash_equals($sessionToken, $token) ||
    $issuedAt <= 0 ||
    $issuedAt < $now - FEEDBACK_TOKEN_TTL_SECONDS
) {
    app_json_response(['success' => false, 'error' => 'Le formulaire a expiré. Veuillez réessayer.'], 403);
}

if ($now - $issuedAt < FEEDBACK_MIN_COMPLETION_SECONDS) {
    app_json_response(['success' => false, 'error' => 'Veuillez patienter un instant avant l’envoi.'], 429);
}

$rating = trim((string)($input['rating'] ?? ''));
if (!in_array($rating, ['positive', 'neutral', 'negative'], true)) {
    app_json_response(['success' => false, 'error' => 'Choisissez une appréciation.'], 422);
}

$comment = trim((string)($input['comment'] ?? ''));
if (mb_strlen($comment, 'UTF-8') > 2000) {
    app_json_response(['success' => false, 'error' => 'Le commentaire ne peut pas dépasser 2 000 caractères.'], 422);
}

$pagePath = trim((string)($input['page'] ?? ''));
if ($pagePath === '' || !str_starts_with($pagePath, '/')) {
    $pagePath = '/';
}
$basePath = app_script_base_path();
if ($basePath !== '' && ($pagePath === $basePath || str_starts_with($pagePath, $basePath . '/'))) {
    $pagePath = substr($pagePath, strlen($basePath));
    if ($pagePath === '') {
        $pagePath = '/';
    }
}
$pagePath = mb_substr($pagePath, 0, 500, 'UTF-8');
$locale = strtolower(trim((string)($input['locale'] ?? 'fr')));
$locale = $locale === 'en' ? 'en' : 'fr';
$visitorHash = feedback_visitor_hash();

$db = app_db();
$db->prepare('DELETE FROM app_feedback WHERE created_at_epoch < ?')
    ->execute([$now - FEEDBACK_RETENTION_SECONDS]);
$db->prepare("UPDATE app_feedback SET visitor_hash = '' WHERE visitor_hash <> '' AND created_at_epoch < ?")
    ->execute([$now - 86400]);

$rateStmt = $db->prepare('SELECT COUNT(*) AS recent_count, MAX(created_at_epoch) AS latest_at
    FROM app_feedback
    WHERE visitor_hash = ? AND created_at_epoch >= ?');
$rateStmt->execute([$visitorHash, $now - 3600]);
$rate = $rateStmt->fetch() ?: ['recent_count' => 0, 'latest_at' => null];
$recentCount = (int)($rate['recent_count'] ?? 0);
$latestAt = (int)($rate['latest_at'] ?? 0);

if ($recentCount >= FEEDBACK_MAX_PER_HOUR || ($latestAt > 0 && $latestAt > $now - FEEDBACK_COOLDOWN_SECONDS)) {
    app_json_response(['success' => false, 'error' => 'Merci de patienter avant d’envoyer un nouvel avis.'], 429);
}

$stmt = $db->prepare('INSERT INTO app_feedback
    (rating, comment, page_path, locale, visitor_hash, created_at_epoch)
    VALUES (?, ?, ?, ?, ?, ?)');
$stmt->execute([
    $rating,
    $comment === '' ? null : $comment,
    $pagePath,
    $locale,
    $visitorHash,
    $now,
]);

unset($_SESSION['feedback_token'], $_SESSION['feedback_token_issued_at']);
app_json_response(['success' => true]);
