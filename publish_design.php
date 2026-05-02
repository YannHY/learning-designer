<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

require_same_origin_post(true);
$user = require_login_json();
$db = app_db();
$input = app_json_input();

$action   = trim((string)($input['action'] ?? ''));
$designId = isset($input['design_id']) ? (int)$input['design_id'] : 0;

if (!in_array($action, ['publish', 'unpublish', 'status'], true)) {
    app_json_response(['success' => false, 'error' => 'Action invalide.'], 422);
}

if ($designId <= 0) {
    app_json_response(['success' => false, 'error' => 'Identifiant invalide.'], 422);
}

$stmt = $db->prepare("SELECT id, share_token, is_published FROM learning_designs WHERE id = ? AND owner_user_id = ? LIMIT 1");
$stmt->execute([$designId, (int)$user['id']]);
$row = $stmt->fetch();
if (!$row) {
    app_json_response(['success' => false, 'error' => 'Production introuvable.'], 404);
}

if ($action === 'status') {
    $url = ($row['is_published'] && $row['share_token'])
        ? app_base_url() . '/view.php?token=' . urlencode((string)$row['share_token'])
        : null;
    app_json_response([
        'success'      => true,
        'is_published' => (bool)$row['is_published'],
        'share_url'    => $url,
    ]);
}

if ($action === 'unpublish') {
    $db->prepare("UPDATE learning_designs SET is_published = 0 WHERE id = ? AND owner_user_id = ?")
       ->execute([$designId, (int)$user['id']]);
    app_json_response(['success' => true, 'is_published' => false]);
}

// action === 'publish'
$token = (string)($row['share_token'] ?? '');
if ($token === '') {
    $token = bin2hex(random_bytes(24));
    $db->prepare("UPDATE learning_designs SET share_token = ?, is_published = 1 WHERE id = ? AND owner_user_id = ?")
       ->execute([$token, $designId, (int)$user['id']]);
} else {
    $db->prepare("UPDATE learning_designs SET is_published = 1 WHERE id = ? AND owner_user_id = ?")
       ->execute([$designId, (int)$user['id']]);
}

$scheme  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host    = (string)($_SERVER['HTTP_HOST'] ?? '');
$dir     = rtrim(str_replace('\\', '/', dirname((string)($_SERVER['SCRIPT_NAME'] ?? ''))), '/');
$url     = $scheme . '://' . $host . $dir . '/view.php?token=' . urlencode($token);

app_json_response(['success' => true, 'is_published' => true, 'share_url' => $url]);
