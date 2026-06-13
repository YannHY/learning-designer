<?php
declare(strict_types=1);
require_once __DIR__ . '/lib/bootstrap.php';

$user = require_login_json();
$db = app_db();

$stmt = $db->prepare("SELECT id, title, updated_at, created_at FROM learning_designs WHERE owner_user_id = ? ORDER BY updated_at DESC");
$stmt->execute([(int)$user['id']]);
$items = [];
foreach ($stmt->fetchAll() as $row) {
    $items[] = [
        'id' => (int)$row['id'],
        'title' => (string)$row['title'],
        'updatedAt' => (string)$row['updated_at'],
        'createdAt' => (string)$row['created_at'],
    ];
}

app_json_response(['success' => true, 'items' => $items]);
