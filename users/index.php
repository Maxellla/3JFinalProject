<?php 
include("../setup.php"); 

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('../images/background.jpg');
            background-size: cover;
            background-position: center center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            color: #333;
        }

        .container {
            background-color: rgba(247, 226, 215, 0.9);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            color: #9e8c6b;
            font-size: 26px;
            margin-bottom: 10px;
            margin-top: 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #3498db;
            color: white;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            color: #e57a7a;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Users List</h1>

        <table class="table">
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["full_name"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["phone_number"] . "</td>";
                    echo "<td>" . $row["role"] . "</td>";
                    echo "<td><a href='edit.php?id=" . $row["user_id"] . "'>Edit</a> | <a href='delete.php?id=" . $row["user_id"] . "'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No users found</td></tr>";
            }
            ?>
        </table>
        <br><a href="add.php">Add New User</a>
    </div>
</body>
</html>
