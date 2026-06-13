<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    app_json_response(['success' => false, 'error' => 'Methode non autorisee.'], 405);
}

$user = require_cli_token_json();
$db = app_db();
$input = app_json_input();
$document = $input['document'] ?? null;

if (!is_array($document) || !isset($document['sessions']) || !is_array($document['sessions'])) {
    app_json_response(['success' => false, 'error' => 'Document invalide.'], 422);
}

$title = trim((string)($input['title'] ?? app_design_title_from_document($document)));
if ($title === '') {
    $title = app_design_title_from_document($document);
}
$title = mb_substr($title, 0, 255, 'UTF-8');

$payload = json_encode($document, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if (!is_string($payload)) {
    app_json_response(['success' => false, 'error' => 'Impossible de serialiser le document.'], 500);
}

$designId = isset($input['design_id']) ? (int)$input['design_id'] : 0;
if ($designId > 0) {
    $check = $db->prepare("SELECT id, share_token FROM learning_designs WHERE id = ? AND owner_user_id = ? LIMIT 1");
    $check->execute([$designId, (int)$user['id']]);
    $existing = $check->fetch();
    if ($existing) {
        $token = (string)($existing['share_token'] ?? '');
        if ($token === '') {
            $token = bin2hex(random_bytes(24));
        }
        $stmt = $db->prepare("UPDATE learning_designs SET title = ?, document_json = ?, share_token = ?, is_published = 1, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND owner_user_id = ?");
        $stmt->execute([$title, $payload, $token, $designId, (int)$user['id']]);
    } else {
        $designId = 0;
    }
}

if ($designId === 0) {
    $token = bin2hex(random_bytes(24));
    $stmt = $db->prepare("INSERT INTO learning_designs (owner_user_id, title, document_json, share_token, is_published) VALUES (?, ?, ?, ?, 1)");
    $stmt->execute([(int)$user['id'], $title, $payload, $token]);
    $designId = (int)$db->lastInsertId();
}

$read = $db->prepare("SELECT id, title, share_token, updated_at FROM learning_designs WHERE id = ? AND owner_user_id = ? LIMIT 1");
$read->execute([$designId, (int)$user['id']]);
$design = $read->fetch();
if (!$design) {
    app_json_response(['success' => false, 'error' => 'Publication introuvable.'], 500);
}

$shareUrl = app_base_url() . '/view.php?token=' . urlencode((string)$design['share_token']);

app_json_response([
    'success' => true,
    'design' => [
        'id' => (int)$design['id'],
        'title' => (string)$design['title'],
        'updatedAt' => (string)$design['updated_at'],
    ],
    'share_url' => $shareUrl,
]);
