<?php
session_start();
include("setup.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $service_id = $_POST['service_id'];
    $appointment_date = $_POST['appointment_date'];
    $start_time = $_POST['start_time'];
    
    // Calculate end time based on service duration (assuming you have a way to get this)
    $sql = "SELECT duration FROM services WHERE service_id = $service_id";
    $result = $conn->query($sql);
    $duration = $result->fetch_assoc()['duration'];
    $end_time = date('H:i', strtotime($start_time) + $duration * 60); // Convert duration to minutes

    $sql = "INSERT INTO appointments (user_id, service_id, appointment_date, start_time, end_time, status) 
            VALUES ('$user_id', '$service_id', '$appointment_date', '$start_time', '$end_time', 'pending')";

    if ($conn->query($sql) === TRUE) {
        echo "Booking confirmed!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>