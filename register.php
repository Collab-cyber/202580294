<?php
require_once 'includes/init.php';

guest_only(); 

$messages  = auth_messages();

$oldName   = (string)($_GET['name'] ?? '');
$oldEmail  = (string)($_GET['email'] ?? '');

$pageTitle = 'PalaTrip | Register';
$active    = 'register';
include 'includes/header.php';
?>

    <main id="main" class="auth-page">

        <section class="form-section">

            <h1>Create an Account</h1>

            <p class="form-lead">Register to start exploring Palawan with PalaTrip.</p>

            <?php foreach ($messages as [$type, $text]): ?>
                <p class="alert alert-<?= e($type) ?>" role="alert"><?= e($text) ?></p>
            <?php endforeach; ?>

            <form action="auth/register.php" method="post">

                <div class="field">
                    <label for="name">
                        Full Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter your full name"
                        value="<?= e($oldName) ?>"
                        maxlength="100"
                        autocomplete="name"
                        required
                    >
                </div>

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
                        maxlength="150"
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
                        placeholder="Create a password (min. 8 characters)"
                        minlength="8"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <div class="field">
                    <label for="confirm-password">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        id="confirm-password"
                        name="confirm-password"
                        placeholder="Confirm your password"
                        minlength="8"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <button type="submit">
                    Register
                </button>

            </form>

            <p class="form-switch">
                Already have an account?
                <a href="login.php">Login here</a>
            </p>

        </section>

    </main>

<?php include 'includes/footer.php'; ?>
