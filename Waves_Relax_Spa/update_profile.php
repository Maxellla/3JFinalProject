<?php
session_start();
require 'setup.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $full_name = $_POST['full_name'];
    $phone_number = $_POST['phone_number'];

    // Update the user information in the database
    $query = "UPDATE users SET full_name = ?, phone_number = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $full_name, $phone_number, $user_id);

    if ($stmt->execute()) {
        // Update successful
        header("Location: user_dashboard.php"); // Redirect to the user dashboard
        exit();
    } else {
        // Handle error
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>