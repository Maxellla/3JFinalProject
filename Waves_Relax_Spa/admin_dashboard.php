<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - Waves Relax Spa</title>

    <!-- Adding CSS -->
    <link rel="stylesheet" href="./css/style-admin_dashboard.css">
    <link rel="stylesheet" href="./css/MediaQuery.css">
</head>

<body>
    <header>
        <div class="logo">Admin Dashboard</div>
        <nav>
            <ul>
                <li><a href="#manage-bookings">Manage Bookings</a></li>
                <li><a href="#manage-services">Manage Services</a></li>
                <li><a href="#therapist-schedule">Therapist Schedule</a></li>
                <li><a href="#payments-reports">Payments & Reports</a></li>
            </ul>
        </nav>
        <!-- Log Out Button -->
        <div class="logout">
            <a href="logout.php">Log Out</a> <!-- Assuming logout.php handles the log-out process -->
        </div>
    </header>

    <div class="container">
        <section id="manage-bookings">
            <h2>Manage Bookings</h2>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Customer Name</th>
                        <th>Service</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Booking details will be populated here -->
                </tbody>
            </table>
        </section>

        <section id="manage-services">
            <h2>Manage Services</h2>
            <div class="service-list">
                <h3>Service List</h3>
                <ul>
                    <!-- List of services will be populated here -->
                </ul>
            </div>
            <div class="add-service">
                <h3>Add New Service</h3>
                <form>
                    <input type="text" placeholder="Service Name" required>
                    <textarea placeholder="Description" required></textarea>
                    <input type="number" placeholder="Price" required>
                    <input type="text" placeholder="Duration" required>
                    <button type="submit">Add Service</button>
                </form>
            </div>
        </section>

        <section id="therapist-schedule">
            <h2>Therapist Schedule Management</h2>
            <div class="availability-calendar">
                <h3>Availability Calendar</h3>
                <!-- Calendar component will be integrated here -->
            </div>
            <div class="add-availability">
                <h3>Add Availability</h3>
                <form>
                    <input type="text" placeholder="Therapist Name" required>
                    <input type="date" required>
                    <input type="time" required>
                    <input type="time" required>
                    <button type="submit">Add Availability</button>
                </form>
            </div>
        </section>

        <section id="payments-reports">
            <h2>Payment and Reports</h2>
            <div class="payments-table">
                <h3>Payments Table</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Payment details will be populated here -->
                    </tbody>
                </table>
            </div>
            <div class="reports-section">
                <h3>Reports</h3>
                <!-- Data visualizations will be integrated here -->
            </div>
        </section>
    </div>

    <script src="script-admin-dashboard.js"></script>
</body>

</html>
