<?php
session_start(); // Start the session

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    header("Location: user_dashboard.php"); // Redirect to user dashboard if logged in
    exit();
}

// Include the database connection file
require 'setup.php'; // Make sure this path is correct

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Validate password
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: signup.php");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone_number, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $full_name, $email, $phone_number, $hashed_password, $role);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to login page after successful signup
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
        header("Location: signup.php");
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
    <title>Sign Up - Waves Relax Spa</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/MediaQuery.css">
    <script src="https://kit.fontawesome.com/7a6c6b42a6.js" crossorigin="anonymous"></script>
</head>
<body>

    <header>
        <a href="#" class="logo">Waves Relax Spa</a>
    </header>

    <div class="signup-container">
        <div class="signup-content">
            <h2>Get Started Now</h2>

            <!-- Display error message if any -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-message">
                    <p><?php echo $_SESSION['error']; ?></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form action="signup.php" method="POST" id="signupForm">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="phone_number">Phone Number</label>
                <input type="tel" id="phone_number" name="phone_number" placeholder="Enter your phone number" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>

                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="customer">Customer</option>
                    <option value="therapist">Therapist</option>
                    <option value="admin">Admin</option>
                </select>

                <button type="submit" class="signup-btn">Sign Up</button>
            </form>
            <p>Already have an account? <a href="login.php">Log In</a></p>
        </div>
    </div>

</body>
</html>
