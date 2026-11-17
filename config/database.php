<?php
$host = "localhost";
$dbname = "palatrip_db";
$username = "root";
$password = "";

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // The real error goes to the PHP error log (C:\xampp\php\logs\php_error_log),
    // not to the visitor, so database details are never shown on the page.
    error_log("PalaTrip database connection failed: " . $e->getMessage());
    http_response_code(500);
    die("Sorry, PalaTrip is not available right now. Please try again later.");
}
