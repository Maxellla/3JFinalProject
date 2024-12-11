<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Fetch therapist_id from session
$therapist_id = $_SESSION['user_id'];

// Include database connection
require 'setup.php'; // Make sure this path is correct

// Fetch existing availability for therapist
$query = "SELECT * FROM availability WHERE therapist_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $therapist_id);
$stmt->execute();
$result = $stmt->get_result();
$availability = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Therapist Dashboard - Waves Relax Spa</title>
    <link rel="stylesheet" href="./css/style-therapist_dashboard.css">
</head>
<body>
    <header>
        <a href="#" class="logo">Waves Relax Spa</a>
        <nav>
            <ul>
                <li><a href="./logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="availability-section">
            <h2>Your Availability</h2>
            <form id="availability-form" method="POST" action="save_availability.php">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>

                <label for="start_time">Start Time:</label>
                <input type="time" id="start_time" name="start_time" required>

                <label for="end_time">End Time:</label>
                <input type="time" id="end_time" name="end_time" required>

                <button type="submit">Save Availability</button>
            </form>

            <h3>Current Availability</h3>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($availability as $entry): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($entry['date']); ?></td>
                            <td><?php echo htmlspecialchars($entry['start_time']); ?></td>
                            <td><?php echo htmlspecialchars($entry['end_time']); ?></td>
                            <td>
                                <a href="delete_availability.php?id=<?php echo $entry['availability_id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
