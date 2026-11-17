<?php
// Saves a new trip for the logged-in user, then goes back to the profile page.
require_once __DIR__ . '/../includes/init.php';

if (!is_logged_in()) {
    go('login.php', ['error' => 'login_required']);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    go('profile.php');
}

check_csrf('profile.php');

$destination = trim($_POST['destination'] ?? '');
$activity    = trim($_POST['activity'] ?? '');
$tripDate    = trim($_POST['trip_date'] ?? '');

// Go back to the profile with an error. The typed values are kept in the
// session (not the URL) so the user doesn't retype everything.
function back_to_profile($code, array $values)
{
    keep_old($values);
    go('profile.php', ['error' => $code]);
}

$values = ['destination' => $destination, 'activity' => $activity, 'trip_date' => $tripDate];

if (!in_array($destination, palawan_destinations(), true)) {
    back_to_profile('trip_destination', $values);
}

if ($activity === '' || str_len($activity) > 100) {
    back_to_profile('trip_activity', $values);
}

// Must be a real date in YYYY-MM-DD format and not later than today.
$date = DateTime::createFromFormat('!Y-m-d', $tripDate);
if (!$date || $date->format('Y-m-d') !== $tripDate || $date > new DateTime('today')) {
    back_to_profile('trip_date', $values);
}

try {
    $insert = $conn->prepare(
        'INSERT INTO trips (user_id, destination, activity, trip_date) VALUES (?, ?, ?, ?)'
    );
    $insert->execute([$_SESSION['user_id'], $destination, $activity, $tripDate]);
} catch (PDOException $ex) {
    error_log('PalaTrip add trip error: ' . $ex->getMessage());
    back_to_profile('server', $values);
}

go('profile.php', ['trip_added' => 1]);
