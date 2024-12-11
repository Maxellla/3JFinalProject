<?php
session_start();
require 'setup.php'; // Your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    // Insert service into database
    $stmt = $conn->prepare("INSERT INTO services (service_name, description, price, duration) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $service_name, $description, $price, $duration);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Service added successfully!";
    } else {
        $_SESSION['error'] = "Failed to add service. Please try again.";
    }

    header("Location: admin_dashboard.php");
    exit();
}

$conn->close();
?>
