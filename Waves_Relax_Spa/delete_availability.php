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

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $availability_id = $_GET['id'];

    // Delete the availability entry from the database
    $query = "DELETE FROM availability WHERE availability_id = ? AND therapist_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $availability_id, $therapist_id);

    if ($stmt->execute()) {
        // Availability deleted successfully
        $_SESSION['success'] = "Availability deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete availability.";
    }

    header("Location: therapist_dashboard.php");
    exit();
} else {
    // If no ID is provided, redirect to dashboard
    header("Location: therapist_dashboard.php");
    exit();
}
?>
