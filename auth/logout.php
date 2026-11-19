<?php
require_once __DIR__ . '/../includes/init.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    go(is_logged_in() ? 'profile.php' : 'login.php');
}

check_csrf('profile.php');

end_session();

go('login.php', ['loggedout' => 1]);
