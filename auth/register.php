<?php
require_once __DIR__ . '/../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    go('register.php');
}

$name     = trim($_POST['name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm-password'] ?? '';

// Sent back to the form so the user doesn't retype everything.
$keep = ['name' => $name, 'email' => $email];

if ($name === '' || str_len($name) > 100) {
    go('register.php', ['error' => 'name'] + $keep);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
    go('register.php', ['error' => 'email'] + $keep);
}
if (strlen($password) < 8) {
    go('register.php', ['error' => 'short_password'] + $keep);
}
if ($password !== $confirm) {
    go('register.php', ['error' => 'mismatch'] + $keep);
}

try {
    $check = $conn->prepare('SELECT id FROM users WHERE email = ?');
    $check->execute([$email]);

    if ($check->fetch()) {
        go('register.php', ['error' => 'exists'] + $keep);
    }

    $insert = $conn->prepare('INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)');
    $insert->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
} catch (PDOException $ex) {
    // 23000 = duplicate key. Happens if someone registered the same email
    // between our SELECT check and this INSERT.
    if ($ex->getCode() == 23000) {
        go('register.php', ['error' => 'exists'] + $keep);
    }
    go('register.php', ['error' => 'server'] + $keep);
}

go('login.php', ['registered' => 1]);
