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
// Explicit CLI updates use a fresh revision when the caller did not supply
// one. The compare-and-swap still rejects another write during this request.
$expectedRevision = filter_var($input['expected_revision'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($designId > 0 && !array_key_exists('expected_revision', $input)) {
    $read = $db->prepare("SELECT revision FROM learning_designs WHERE id = ? AND owner_user_id = ?");
    $read->execute([$designId, (int)$user['id']]);
    $expectedRevision = $read->fetchColumn();
}
$result = app_save_design_document($db, (int)$user['id'], $designId,
    $expectedRevision === false ? null : (int)$expectedRevision, $title, $payload, true);
if ($result['success']) {
    $result['share_url'] = app_base_url() . '/view.php?token=' . urlencode((string)$result['share_token']);
}
$status = $result['status'];
unset($result['status'], $result['share_token']);
app_json_response($result, $status);
