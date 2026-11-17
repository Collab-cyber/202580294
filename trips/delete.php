<?php
// Removes one trip from the logged-in user's history, then goes back to the profile page.
require_once __DIR__ . '/../includes/init.php';

if (!is_logged_in()) {
    go('login.php', ['error' => 'login_required']);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    go('profile.php');
}

check_csrf('profile.php');

$tripId = (int)($_POST['trip_id'] ?? 0);

try {
    // "AND user_id = ?" makes sure users can only delete their own trips,
    // even if someone changes the trip_id in the form.
    $delete = $conn->prepare('DELETE FROM trips WHERE id = ? AND user_id = ?');
    $delete->execute([$tripId, $_SESSION['user_id']]);
} catch (PDOException $ex) {
    error_log('PalaTrip delete trip error: ' . $ex->getMessage());
    go('profile.php', ['error' => 'server']);
}

go('profile.php', ['trip_deleted' => 1]);
