<?php
declare(strict_types=1);
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/lib/bootstrap.php';

$user = current_user();
if (!$user) {
    http_response_code(401);
    echo json_encode(["success" => false, "error" => "Non connecté"]);
    exit;
}

echo json_encode([
    "success" => true,
    "user" => [
        "id" => (int)$user['id'],
        "username" => (string)($user['username'] ?? ''),
        "email" => (string)$user['email'],
        "role" => (string)$user['role']
    ]
]);
