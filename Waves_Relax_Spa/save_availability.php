<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch therapist_id from session
$therapist_id = $_SESSION['user_id'];

// Include database connection
require 'setup.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate the input data
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Insert the new availability into the database
    $query = "INSERT INTO availability (therapist_id, date, start_time, end_time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isss", $therapist_id, $date, $start_time, $end_time);

    if ($stmt->execute()) {
        // Availability saved successfully
        $_SESSION['success'] = "Availability saved successfully!";
        header("Location: therapist_dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to save availability.";
        header("Location: therapist_dashboard.php");
        exit();
    }
}
?>
