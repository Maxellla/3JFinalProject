<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    $_SESSION['error'] = "You must log in first.";
    header("Location: login.php");
    exit();
}

// Check if the user is a customer
if ($_SESSION['role'] != 'customer') {
    $_SESSION['error'] = "Access denied.";
    header("Location: login.php");
    exit();
}

// Include the database connection
require 'setup.php'; // Ensure this is the correct path

// Initialize variables
$service = "";
$therapist = "";
$appointment_date = "";
$time_slot = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate form data
    $appointment_date = $_POST['appointment_date'];
    $therapist_id = $_POST['therapist_id']; // Therapist selected by the user
    $service_id = $_POST['service_id']; // Selected service (if applicable)

    // Check if therapist_id exists in the users table
    $stmt_check_therapist = $conn->prepare("SELECT user_id FROM users WHERE user_id = ? AND role = 'therapist'");
    $stmt_check_therapist->bind_param("i", $therapist_id);
    $stmt_check_therapist->execute();
    $stmt_check_therapist->store_result();

    if ($stmt_check_therapist->num_rows > 0) {
        // Therapist exists, proceed with booking

        // Check if service_id exists in the services table
        $stmt_check_service = $conn->prepare("SELECT service_id FROM services WHERE service_id = ?");
        $stmt_check_service->bind_param("i", $service_id);
        $stmt_check_service->execute();
        $stmt_check_service->store_result();

        if ($stmt_check_service->num_rows > 0) {
            // Service exists, proceed with booking
            $stmt_check_therapist->bind_result($therapist_id);
            $stmt_check_therapist->fetch();

            // Insert the booking into the appointments table
            $stmt = $conn->prepare("INSERT INTO appointments (user_id, therapist_id, service_id, appointment_date) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiis", $_SESSION['user_id'], $therapist_id, $service_id, $appointment_date);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Your appointment has been booked successfully.";
                header("Location: user_dashboard.php");
                exit();
            } else {
                $_SESSION['error'] = "Failed to book your appointment. Please try again.";
                header("Location: booking.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Selected service not available. Please choose another service.";
            header("Location: booking.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Selected therapist not available. Please choose another therapist.";
        header("Location: booking.php");
        exit();
    }
}

// Fetch list of therapists for the user to choose from
$therapists = [];
$stmt = $conn->prepare("SELECT user_id, full_name FROM users WHERE role = 'therapist'");
$stmt->execute();
$stmt->bind_result($therapist_id, $full_name);

while ($stmt->fetch()) {
    $therapists[] = [
        'user_id' => $therapist_id,
        'name' => $full_name
    ];
}

// Fetch list of services for the user to choose from
$services = [];
$stmt_service = $conn->prepare("SELECT service_id, service_name FROM services");
$stmt_service->execute();
$stmt_service->bind_result($service_id, $service_name);

while ($stmt_service->fetch()) {
    $services[] = [
        'service_id' => $service_id,
        'name' => $service_name
    ];
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - Waves Relax Spa</title>
    <link rel="stylesheet" href="./css/style-booking.css">
    <link rel="stylesheet" href="./css/MediaQuery.css">
    <script src="https://kit.fontawesome.com/7a6c6b42a6.js" crossorigin="anonymous"></script>
</head>
<body>

    <header>
        <a href="#" class="logo">Waves Relax Spa</a>
        <nav>
            <ul>
                <li><a href="./login.php" id="log-in">Log in</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="booking-section">
            <h2>Book Your Appointment</h2>

            <!-- Display success or error messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="success-message">
                    <p><?php echo $_SESSION['success']; ?></p>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-message">
                    <p><?php echo $_SESSION['error']; ?></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Booking Form -->
            <form action="booking.php" method="POST" id="bookingForm">
                <!-- Select Service -->
                <label for="service-select">Service:</label>
                <select id="service-select" name="service_id" required>
                    <option value="" disabled selected>Select a service</option>
                    <?php foreach ($services as $service): ?>
                        <option value="<?php echo $service['service_id']; ?>"><?php echo $service['name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Select Therapist -->
                <label for="therapist-select">Preferred Therapist:</label>
                <select id="therapist-select" name="therapist_id" required>
                    <option value="" disabled selected>Select a therapist</option>
                    <?php foreach ($therapists as $therapist): ?>
                        <option value="<?php echo $therapist['user_id']; ?>"><?php echo $therapist['name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Appointment Date -->
                <label for="appointment-date">Select Date:</label>
                <input type="date" id="appointment-date" name="appointment_date" required>

                <!-- Time Slot -->
                <label for="time-slot">Available Time Slot:</label>
                <select name="time_slot" required>
                    <option value="10:00">8:00</option>
                    <option value="11:00">9:00</option>
                    <option value="12:00">10:00</option>
                    <option value="13:00">11:00</option>
                    <option value="14:00">1:00</option>
                    <option value="15:00">2:00</option>
                </select>

                <button type="submit">Confirm Booking</button>
            </form>
        </section>
    </main>

</body>
</html>
