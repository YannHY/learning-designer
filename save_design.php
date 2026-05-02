<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

require_same_origin_post(true);
$user = require_login_json();
$db = app_db();
$input = app_json_input();
$document = $input['document'] ?? null;

if (!is_array($document) || !isset($document['sessions']) || !is_array($document['sessions'])) {
    app_json_response(['success' => false, 'error' => 'Document invalide.'], 422);
}

$designId = isset($input['design_id']) ? (int)$input['design_id'] : 0;
$expectedUpdatedAt = trim((string)($input['expected_updated_at'] ?? ''));
$title = trim((string)($input['title'] ?? app_design_title_from_document($document)));
if ($title === '') {
    $title = app_design_title_from_document($document);
}
$title = mb_substr($title, 0, 255, 'UTF-8');

$payload = json_encode($document, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if (!is_string($payload)) {
    app_json_response(['success' => false, 'error' => 'Impossible de serialiser le document.'], 500);
}

if ($designId > 0) {
    $check = $db->prepare("SELECT id, updated_at FROM learning_designs WHERE id = ? AND owner_user_id = ? LIMIT 1");
    $check->execute([$designId, (int)$user['id']]);
    $existing = $check->fetch();
    if ($existing) {
        $currentUpdatedAt = (string)($existing['updated_at'] ?? '');
        if ($expectedUpdatedAt !== '' && $currentUpdatedAt !== '' && $expectedUpdatedAt !== $currentUpdatedAt) {
            app_json_response([
                'success' => false,
                'error' => 'Conflit de sauvegarde : cette production a été modifiée dans une autre fenêtre.',
                'conflict' => true,
                'design' => [
                    'id' => $designId,
                    'updatedAt' => $currentUpdatedAt,
                ],
            ], 409);
        }
        $stmt = $db->prepare("UPDATE learning_designs SET title = ?, document_json = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND owner_user_id = ?");
        $stmt->execute([$title, $payload, $designId, (int)$user['id']]);
    } else {
        $designId = 0;
    }
}

if ($designId === 0) {
    $stmt = $db->prepare("INSERT INTO learning_designs (owner_user_id, title, document_json) VALUES (?, ?, ?)");
    $stmt->execute([(int)$user['id'], $title, $payload]);
    $designId = (int)$db->lastInsertId();
}

$read = $db->prepare("SELECT id, title, updated_at FROM learning_designs WHERE id = ? AND owner_user_id = ? LIMIT 1");
$read->execute([$designId, (int)$user['id']]);
$design = $read->fetch();

app_json_response([
    'success' => true,
    'design' => [
        'id' => (int)$design['id'],
        'title' => (string)$design['title'],
        'updatedAt' => (string)$design['updated_at'],
    ],
]);
