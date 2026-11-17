<?php
require_once 'includes/init.php';

guest_only(); 

$messages  = auth_messages();
$old       = take_old();
$oldEmail  = (string)($old['email'] ?? '');
$pageTitle = 'PalaTrip | Login';
$active    = 'login';
include 'includes/header.php';
?>

    <main id="main" class="auth-page">

        <section class="form-section">

            <h1>
                Welcome Back
            </h1>

            <p class="form-lead">
                Login to your PalaTrip account.
            </p>

            <?php foreach ($messages as [$type, $text]): ?>
                <p class="alert alert-<?= e($type) ?>" role="alert"><?= e($text) ?></p>
            <?php endforeach; ?>

            <form action="auth/login.php" method="post">

                <?= csrf_field() ?>

                <div class="field">

                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        value="<?= e($oldEmail) ?>"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="field">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button type="submit">
                    Login
                </button>

            </form>

            <p class="form-switch">
                Don't have an account?
                <a href="register.php">Register here</a>
            </p>

        </section>

    </main>

<?php include 'includes/footer.php'; ?>
