<?php
session_start();
require 'setup.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Get user email from session
$user_email = $_SESSION['email'];

// Fetch user details
$stmt = $conn->prepare("SELECT full_name, phone_number, user_id FROM users WHERE email = ?");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$stmt->bind_result($full_name, $phone_number, $user_id); // Make sure user_id is the correct column name
$stmt->fetch();
$stmt->close();

// Fetch upcoming appointments
$stmt = $conn->prepare("SELECT appointment_date, start_time, end_time FROM appointments WHERE user_id = ? AND appointment_date >= CURDATE() ORDER BY appointment_date, start_time");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($appointment_date, $start_time, $end_time);

$upcoming_appointments = [];
while ($stmt->fetch()) {
    $upcoming_appointments[] = [
        'date' => $appointment_date,
        'start_time' => $start_time,
        'end_time' => $end_time
    ];
}
$stmt->close();

// Fetch past appointments
$stmt = $conn->prepare("SELECT appointment_date, start_time, end_time FROM appointments WHERE user_id = ? AND appointment_date < CURDATE() ORDER BY appointment_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($past_appointment_date, $past_start_time, $past_end_time);

$past_appointments = [];
while ($stmt->fetch()) {
    $past_appointments[] = [
        'date' => $past_appointment_date,
        'start_time' => $past_start_time,
        'end_time' => $past_end_time
    ];
}
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style-user_dashboard.css">
    <title>User Dashboard</title>
</head>
<body>
    <header>
        <div class="logo">User  Dashboard</div>
        <nav>
            <ul>
                <li><a href="#upcoming-appointments">Upcoming Appointments</a></li>
                <li><a href="#past-appointments">Past Appointments</a></li>
                <li><a href="#account-settings">Account Settings</a></li>
                <li><a href="logout.php">Logout</a></li> <!-- Logout link -->
            </ul>
        </nav>
    </header>

    <div class="container">
        <section id="upcoming-appointments">
            <h2>Upcoming Appointments</h2>
            <div class="appointment-list">
                <?php if (empty($upcoming_appointments)): ?>
                    <p>No upcoming appointments.</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($upcoming_appointments as $appointment): ?>
                            <li><?php echo htmlspecialchars($appointment['date']) . ' from ' . htmlspecialchars($appointment['start_time']) . ' to ' . htmlspecialchars($appointment['end_time']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </section>

        <section id="past-appointments">
            <h2>Past Appointments</h2>
            <div class="appointment-list">
                <?php if (empty($past_appointments)): ?>
                    <p>No past appointments.</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($past_appointments as $appointment): ?>
                            <li><?php echo htmlspecialchars($appointment['date']) . ' from ' . htmlspecialchars($appointment['start_time']) . ' to ' . htmlspecialchars($appointment['end_time']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </section>

        <section id="account-settings">
            <h2>Account Settings</h2>
            <div class="profile-settings">
                <h3>Edit Profile</h3>
                <form id="profile-form" method="POST" action="update_profile.php">
                    <input type="text" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user_email); ?>" required readonly>
                    <input type="tel" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" required>
                    <button type="submit">Update Profile</button>
                </form>
            </div>
            <div class="change-password">
                <h3>Change Password</h3>
                <form id="password-form" method="POST" action="change_password.php">
                    <input type="password" name="current_password" placeholder="Current Password" required>
                    <input type="password" name="new_password" placeholder="New Password" required>
                    <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
                    <button type="submit">Change Password</button>
                </form>
            </div>
        </section>
    </div>

    <!-- Reschedule Modal -->
    <div id="reschedule-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Reschedule Appointment</h2>
            <form id="reschedule-form">
                <input type="date" id="new-date" required>
                <input type="time" id="new-time" required>
                <button type="submit">Reschedule</button>
            </form>
        </div>
    </div>

    <script src="script-user-dashboard.js"></script>
</body>
</html>