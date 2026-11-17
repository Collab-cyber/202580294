<?php
// Returns the logged-in user's info as JSON. 401 if nobody is logged in.
require_once __DIR__ . '/../includes/init.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['loggedIn' => false]);
    exit;
}

$stmt = $conn->prepare('SELECT name, email FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) { // account was deleted
    session_destroy();
    http_response_code(401);
    echo json_encode(['loggedIn' => false]);
    exit;
}

echo json_encode(['loggedIn' => true, 'name' => $user['name'], 'email' => $user['email']]);
