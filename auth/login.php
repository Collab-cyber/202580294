<?php
require_once __DIR__ . '/../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    go('login.php');
}

check_csrf('login.php');

$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';


function back_to_login($code, $email)
{
    keep_old(['email' => $email]);
    go('login.php', ['error' => $code]);
}

if ($email === '' || $password === '') {
    back_to_login('empty', $email);
}

try {
    $stmt = $conn->prepare('SELECT id, name, password_hash FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    error_log('PalaTrip login error: ' . $ex->getMessage());
    back_to_login('server', $email);
}

if (!$user || !password_verify($password, $user['password_hash'])) {
    
    back_to_login('invalid', $email);
}

session_regenerate_id(true);
$_SESSION['user_id'] = (int)$user['id'];
$_SESSION['user_name'] = $user['name']; 

go('profile.php');
