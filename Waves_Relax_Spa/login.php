<?php
session_start(); // Start the session

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    // Check if the user is a customer and if they have an appointment
    if ($_SESSION['role'] == 'customer') {
        // Check if the customer has already booked an appointment
        require 'setup.php'; // Include the database connection

        // Check if the user has a booking (using the user_id from session)
        $stmt = $conn->prepare("SELECT COUNT(*) FROM appointments WHERE user_id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $stmt->bind_result($booking_count);
        $stmt->fetch();
        
        // If the user has no bookings, redirect to booking page
        if ($booking_count == 0) {
            header("Location: booking.php");
            exit();
        } else {
            // If the user already booked, redirect to their dashboard
            header("Location: user_dashboard.php");
            exit();
        }
    }
    // Redirect to appropriate dashboard based on other roles (therapist, admin)
    header("Location: " . $_SESSION['role'] . "_dashboard.php");
    exit();
}

// Include the database connection file
require 'setup.php'; // Make sure this path is correct

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate form data
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: login.php");
        exit();
    }

    // Prepare and execute the query to find the user
    $stmt = $conn->prepare("SELECT password, role, user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $role, $user_id);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables
            $_SESSION['email'] = $email; // Store email in session
            $_SESSION['user_id'] = $user_id; // Store user_id in session
            $_SESSION['role'] = $role; // Store role in session

            // Redirect based on user role
            if ($role == 'customer') {
                // Check if the customer has already booked
                $stmt_check_booking = $conn->prepare("SELECT COUNT(*) FROM appointments WHERE user_id = ?");
                $stmt_check_booking->bind_param("i", $user_id);
                $stmt_check_booking->execute();
                $stmt_check_booking->bind_result($booking_count);
                $stmt_check_booking->fetch();

                if ($booking_count == 0) {
                    // Redirect to booking page if no booking exists
                    header("Location: booking.php");
                    exit();
                } else {
                    // Redirect to the customer dashboard if booking exists
                    header("Location: user_dashboard.php");
                    exit();
                }
            } else {
                // Redirect to other role dashboards
                switch ($role) {
                    case 'therapist':
                        header("Location: therapist_dashboard.php");
                        break;
                    case 'admin':
                        header("Location: admin_dashboard.php");
                        break;
                    default:
                        $_SESSION['error'] = "Invalid role.";
                        header("Location: login.php");
                        exit();
                }
            }
        } else {
            $_SESSION['error'] = "Invalid password.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "No user found with that email.";
        header("Location: login.php");
        exit();
    }

}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - Waves Relax Spa</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/MediaQuery.css">
    <script src="https://kit.fontawesome.com/7a6c6b42a6.js" crossorigin="anonymous"></script>
</head>
<body>

    <header>
        <a href="#" class="logo">Waves Relax Spa</a>
    </header>

    <div class="login-container">
        <div class="login-content">
            <h2>Log In</h2>

            <!-- Display error message if any -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-message">
                    <p><?php echo $_SESSION['error']; ?></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form action="login.php" method="POST" id="loginForm">
                <label for="login_email">Email</label>
                <input type="email" id="login_email" name="email" placeholder="Enter your email" required>

                <label for="login_password">Password</label>
                <input type="password" id="login_password" name="password" placeholder="Enter your password" required>

                <button type="submit" class="login-btn">Log In</button>
            </form>
            <p>Don't have an account? <a href="signup.php">Create an Account</a></p>
        </div>
    </div>

</body>
</html>
