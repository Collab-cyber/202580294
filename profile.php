<?php
require_once 'includes/init.php';

require_login();

$stmt = $conn->prepare('SELECT name, email, created_at FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // The account no longer exists, so end the session and go to login.
    end_session();
    redirect('login.php', ['error' => 'login_required']);
}

// Only this user's trips, newest first.
$tripStmt = $conn->prepare(
    'SELECT id, destination, activity, trip_date FROM trips WHERE user_id = ? ORDER BY trip_date DESC, id DESC'
);
$tripStmt->execute([$_SESSION['user_id']]);
$trips = $tripStmt->fetchAll(PDO::FETCH_ASSOC);

$_SESSION['user_name'] = $user['name'];
$initial = first_letter($user['name']);
$since   = date('F j, Y', strtotime($user['created_at']));

$messages     = auth_messages();
$destinations = palawan_destinations();
$today        = date('Y-m-d');

// Values kept after a failed "Add trip", so the form stays filled in.
$old            = take_old();
$oldDestination = (string)($old['destination'] ?? '');
$oldActivity    = (string)($old['activity'] ?? '');
$oldDate        = (string)($old['trip_date'] ?? '');

$pageTitle = 'PalaTrip | My Profile';
$active    = 'profile';
include 'includes/header.php';
?>

    <main id="main" class="profile-page">

        <section class="profile-section">

            <h1>My Profile</h1>

            <p>View your account information and travel history.</p>

            <div class="profile-info">

                <div class="avatar" aria-hidden="true"><?= e($initial) ?></div>

                <div class="profile-details">

                    <h2>Personal Information</h2>

                    <p>
                        <strong>Name:</strong>
                        <?= e($user['name']) ?>
                    </p>

                    <p>
                        <strong>Email:</strong>
                        <?= e($user['email']) ?>
                    </p>

                    <p>
                        <strong>Member since:</strong>
                        <?= e($since) ?>
                    </p>

                    <form action="auth/logout.php" method="post">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn secondary-btn logout-btn">Logout</button>
                    </form>

                </div>

            </div>

        </section>

        <section class="trip-history" id="trips">

            <h2>History of Trip</h2>

            <p>Your previous Palawan destinations and activities.</p>

            <?php foreach ($messages as [$type, $text]): ?>
                <p class="alert alert-<?= e($type) ?>" role="alert"><?= e($text) ?></p>
            <?php endforeach; ?>

            <form class="trip-form" action="trips/add.php" method="post">

                <?= csrf_field() ?>

                <h3>Add a Trip</h3>

                <div class="trip-form-grid">

                    <div class="field">
                        <label for="destination">Destination</label>
                        <select id="destination" name="destination" required>
                            <option value="">Choose a destination</option>
                            <?php foreach ($destinations as $place): ?>
                                <option value="<?= e($place) ?>"<?= $place === $oldDestination ? ' selected' : '' ?>><?= e($place) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="field">
                        <label for="activity">Activity</label>
                        <input
                            type="text"
                            id="activity"
                            name="activity"
                            placeholder="e.g. Island hopping"
                            value="<?= e($oldActivity) ?>"
                            maxlength="100"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="trip_date">Date</label>
                        <input
                            type="date"
                            id="trip_date"
                            name="trip_date"
                            value="<?= e($oldDate) ?>"
                            max="<?= e($today) ?>"
                            required
                        >
                    </div>

                </div>

                <button type="submit" class="btn primary-btn">Add Trip</button>

            </form>

            <?php if (!$trips): ?>

                <p class="trip-empty">
                    You haven't added any trips yet. Use the form above to save your first Palawan trip.
                </p>

            <?php else: ?>

                <?php foreach ($trips as $trip): ?>
                    <article>

                        <form class="trip-delete" action="trips/delete.php" method="post"
                              onsubmit="return confirm('Remove this trip from your history?');">
                            <?= csrf_field() ?>
                            <input type="hidden" name="trip_id" value="<?= (int)$trip['id'] ?>">
                            <button type="submit" aria-label="Delete <?= e($trip['destination']) ?> trip">Delete</button>
                        </form>

                        <h3><?= e($trip['destination']) ?></h3>

                        <p><?= e($trip['activity']) ?></p>

                        <p class="trip-date"><?= e(date('F j, Y', strtotime($trip['trip_date']))) ?></p>

                    </article>
                <?php endforeach; ?>

            <?php endif; ?>

        </section>

    </main>

<?php include 'includes/footer.php'; ?>
