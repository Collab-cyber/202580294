<?php
$pageTitle = $pageTitle ?? 'PalaTrip';
$active    = $active ?? '';
$loggedIn  = is_logged_in();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PalaTrip - discover beautiful destinations and activities in Palawan, Philippines.">

    <title><?= e($pageTitle) ?></title>

    <link rel="icon" type="image/svg+xml" href="images/favicon.svg">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <a class="skip-link" href="#main">Skip to content</a>

    <header class="navbar">

        <a class="logo" href="landing.php">
            <span class="logo-mark" aria-hidden="true">P</span>PalaTrip
        </a>

        <button class="nav-toggle" type="button" aria-label="Toggle navigation"
                aria-expanded="false" aria-controls="site-nav">
            <span></span><span></span><span></span>
        </button>

        <nav id="site-nav">
            <?= nav_link('landing.php', 'Explore', 'landing', $active) ?>
            <?= nav_link('index.php', 'Home', 'home', $active) ?>
            <?php if ($loggedIn): ?>
                <?= nav_link('profile.php', 'My Profile', 'profile', $active) ?>
                <form class="nav-logout" action="auth/logout.php" method="post">
                    <?= csrf_field() ?>
                    <button type="submit">Logout</button>
                </form>
            <?php else: ?>
                <?= nav_link('login.php', 'Login', 'login', $active) ?>
                <?= nav_link('register.php', 'Register', 'register', $active, 'nav-btn') ?>
            <?php endif; ?>
        </nav>

    </header>
