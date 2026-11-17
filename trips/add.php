<?php
// Saves a new trip for the logged-in user, then goes back to the profile page.
require_once __DIR__ . '/../includes/init.php';

if (!is_logged_in()) {
    go('login.php', ['error' => 'login_required']);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    go('profile.php');
}

$destination = trim($_POST['destination'] ?? '');
$activity    = trim($_POST['activity'] ?? '');
$tripDate    = trim($_POST['trip_date'] ?? '');

// Sent back to the form so the user doesn't retype everything.
$keep = ['destination' => $destination, 'activity' => $activity, 'trip_date' => $tripDate];

if (!in_array($destination, palawan_destinations(), true)) {
    go('profile.php', ['error' => 'trip_destination'] + $keep);
}

if ($activity === '' || str_len($activity) > 100) {
    go('profile.php', ['error' => 'trip_activity'] + $keep);
}

// Must be a real date in YYYY-MM-DD format and not later than today.
$date = DateTime::createFromFormat('!Y-m-d', $tripDate);
if (!$date || $date->format('Y-m-d') !== $tripDate || $date > new DateTime('today')) {
    go('profile.php', ['error' => 'trip_date'] + $keep);
}

try {
    $insert = $conn->prepare(
        'INSERT INTO trips (user_id, destination, activity, trip_date) VALUES (?, ?, ?, ?)'
    );
    $insert->execute([$_SESSION['user_id'], $destination, $activity, $tripDate]);
} catch (PDOException $ex) {
    go('profile.php', ['error' => 'server'] + $keep);
}

go('profile.php', ['trip_added' => 1]);
