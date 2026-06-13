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

$stmt = $db->prepare("SELECT id, share_token, is_published, is_listed FROM learning_designs WHERE id = ? AND owner_user_id = ? LIMIT 1");
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
        'is_listed'    => (bool)$row['is_listed'],
        'share_url'    => $url,
        'listing_url'  => app_base_url() . '/share.php',
    ]);
}

if ($action === 'unpublish') {
    $db->prepare("UPDATE learning_designs SET is_published = 0, is_listed = 0, listed_at = NULL WHERE id = ? AND owner_user_id = ?")
       ->execute([$designId, (int)$user['id']]);
    app_json_response(['success' => true, 'is_published' => false, 'is_listed' => false]);
}

// action === 'publish'
$isListed = !empty($input['is_listed']);
$token = (string)($row['share_token'] ?? '');
if ($token === '') {
    $token = bin2hex(random_bytes(24));
    $db->prepare("UPDATE learning_designs SET share_token = ?, is_published = 1, is_listed = ?, listed_at = CASE WHEN ? = 1 THEN CURRENT_TIMESTAMP ELSE NULL END WHERE id = ? AND owner_user_id = ?")
       ->execute([$token, $isListed ? 1 : 0, $isListed ? 1 : 0, $designId, (int)$user['id']]);
} else {
    $db->prepare("UPDATE learning_designs SET is_published = 1, is_listed = ?, listed_at = CASE WHEN ? = 1 AND listed_at IS NULL THEN CURRENT_TIMESTAMP WHEN ? = 1 THEN listed_at ELSE NULL END WHERE id = ? AND owner_user_id = ?")
       ->execute([$isListed ? 1 : 0, $isListed ? 1 : 0, $isListed ? 1 : 0, $designId, (int)$user['id']]);
}

$url = app_base_url() . '/view.php?token=' . urlencode($token);

app_json_response([
    'success' => true,
    'is_published' => true,
    'is_listed' => $isListed,
    'share_url' => $url,
    'listing_url' => app_base_url() . '/share.php',
]);
