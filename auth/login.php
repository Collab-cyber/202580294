<?php
require_once __DIR__ . '/../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    go('login.php');
}

$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    go('login.php', ['error' => 'empty']);
}

try {
    $stmt = $conn->prepare('SELECT id, name, password_hash FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    go('login.php', ['error' => 'server']);
}

if (!$user || !password_verify($password, $user['password_hash'])) {
    // Same message for wrong email or wrong password.
    go('login.php', ['error' => 'invalid']);
}

session_regenerate_id(true);
$_SESSION['user_id'] = (int)$user['id'];
$_SESSION['user_name'] = $user['name']; // shown in the navigation bar

go('profile.php');
