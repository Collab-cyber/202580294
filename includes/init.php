<?php
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

require_once __DIR__ . '/../config/database.php';


function go($page, array $params = [])
{
    $url = '../' . $page . ($params ? '?' . http_build_query($params) : '');
    header('Location: ' . $url);
    exit;
}

function str_len($value)
{
    return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
}


// Clears the session and its cookie (used by logout and when an account no longer exists).
function end_session()
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}

// ---------- CSRF protection ----------
// Every form includes a secret token from the session. A fake form on
// another website can't know it, so its request gets rejected.

function csrf_token()
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field()
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

// Used by the auth/ and trips/ handlers. Sends the user back if the token is wrong.
function check_csrf($backTo)
{
    $sent = (string)($_POST['csrf'] ?? '');
    if (empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $sent)) {
        go($backTo, ['error' => 'csrf']);
    }
}

// ---------- Old form values ----------
// After a failed submit, the typed values are kept in the session (not the URL)
// so the form can be filled in again. They are read once, then removed.

function keep_old(array $values)
{
    $_SESSION['old'] = $values;
}

function take_old()
{
    $old = $_SESSION['old'] ?? [];
    unset($_SESSION['old']);
    return $old;
}


// First letter of a name, uppercased. Safe for letters like Ñ or É.
function first_letter($value)
{
    $value = trim((string)$value);
    if ($value === '') {
        return '?';
    }
    if (function_exists('mb_substr')) {
        return mb_strtoupper(mb_substr($value, 0, 1, 'UTF-8'), 'UTF-8');
    }
    return preg_match('/^./u', $value, $m) ? strtoupper($m[0]) : '?';
}

// Destinations a user can pick when adding a trip (same list as js/destinations.js).
function palawan_destinations()
{
    return [
        'El Nido', 'Coron', 'Puerto Princesa', 'Port Barton', 'Nacpan Beach',
        'Honda Bay', 'Kayangan Lake', 'Twin Lagoon', 'Calauit Safari Park',
        'Tubbataha Reefs', 'Balabac', 'Apulit Island', 'Taytay (Fort Santa Isabel)',
        'Ugong Rock', 'Tabon Caves', 'Cuyo Islands',
    ];
}


function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function is_logged_in()
{
    return !empty($_SESSION['user_id']);
}


function redirect($page, array $params = [])
{
    header('Location: ' . $page . ($params ? '?' . http_build_query($params) : ''));
    exit;
}


function require_login()
{
    if (!is_logged_in()) {
        redirect('login.php', ['error' => 'login_required']);
    }
    
    header('Cache-Control: no-store, no-cache, must-revalidate');
}


function guest_only()
{
    if (is_logged_in()) {
        redirect('profile.php');
    }
}


function auth_messages()
{
    $errors = [
        'name'           => 'Please enter your full name.',
        'email'          => 'Please enter a valid email address.',
        'short_password' => 'Password must be at least 8 characters.',
        'mismatch'       => 'Passwords do not match.',
        'exists'         => 'That email is already registered.',
        'empty'          => 'Please enter your email and password.',
        'invalid'        => 'Incorrect email or password.',
        'login_required' => 'Please login to view that page.',
        'server'         => 'Something went wrong. Please try again later.',
        'csrf'           => 'Your session expired. Please try again.',
        'trip_destination' => 'Please choose a destination from the list.',
        'trip_activity'    => 'Please enter an activity (up to 100 characters).',
        'trip_date'        => 'Please enter a valid trip date that is not in the future.',
    ];

    $out = [];
    if (isset($_GET['error'])) {
        $code = (string)$_GET['error'];
        $out[] = ['error', $errors[$code] ?? $errors['server']];
    }
    if (!empty($_GET['registered'])) {
        $out[] = ['success', 'Registration successful! You can now login.'];
    }
    if (!empty($_GET['trip_added'])) {
        $out[] = ['success', 'Trip added to your history!'];
    }
    if (!empty($_GET['loggedout'])) {
        $out[] = ['success', 'You have been logged out.'];
    }
    return $out;
}


function nav_link($href, $label, $key, $active, $extra = '')
{
    $class = trim($extra . ($key === $active ? ' active' : ''));
    return '<a href="' . e($href) . '"' . ($class !== '' ? ' class="' . e($class) . '"' : '') . '>'
        . e($label) . '</a>';
}
