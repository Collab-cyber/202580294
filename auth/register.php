<?php
require_once __DIR__ . '/../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    go('register.php');
}

check_csrf('register.php');

$name     = trim($_POST['name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm-password'] ?? '';


function back_to_register($code, $name, $email)
{
    keep_old(['name' => $name, 'email' => $email]);
    go('register.php', ['error' => $code]);
}

if ($name === '' || str_len($name) > 100) {
    back_to_register('name', $name, $email);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
    back_to_register('email', $name, $email);
}
if (strlen($password) < 8) {
    back_to_register('short_password', $name, $email);
}
if ($password !== $confirm) {
    back_to_register('mismatch', $name, $email);
}

try {
    $check = $conn->prepare('SELECT id FROM users WHERE email = ?');
    $check->execute([$email]);

    if ($check->fetch()) {
        back_to_register('exists', $name, $email);
    }

    $insert = $conn->prepare('INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)');
    $insert->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
} catch (PDOException $ex) {
    // 23000 = duplicate key. Happens if someone registered the same email
    // between our SELECT check and this INSERT.
    if ($ex->getCode() == 23000) {
        back_to_register('exists', $name, $email);
    }
    error_log('PalaTrip register error: ' . $ex->getMessage());
    back_to_register('server', $name, $email);
}

go('login.php', ['registered' => 1]);
