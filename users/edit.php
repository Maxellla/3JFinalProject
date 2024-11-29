<?php
include("../setup.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE user_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $full_name = $row['full_name'];
        $email = $row['email'];
        $phone_number = $row['phone_number'];
        $role = $row['role'];
    } else {
        echo "No user found with ID: $id";
        exit;
    }
} 
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $role = $_POST['role'];

    if (!empty($full_name) && !empty($email) && !empty($phone_number) && !empty($role)) {
        $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, phone_number=?, role=? WHERE user_id=?");
        $stmt->bind_param("ssssi", $full_name, $email, $phone_number, $role, $id);

        if ($stmt->execute()) {
            $message = "User updated successfully";
            $message_type = "success";
        } else {
            $message = "Error editing record: " . $conn->error;
            $message_type = "error";
        }
    } else {
        $message = "Please fill in all fields.";
        $message_type = "error";
    }
} else {
    echo "Invalid request. No ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
            position: relative;
        }

        .form-container {
            background-color: rgba(247, 226, 215, 0.9);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            height: 80%;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        h1 {
            text-align: center;
            color: #9e8c6b;
            font-size: 26px;
            margin-bottom: 10px;
            margin-top: 0px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
            display: block;
        }

        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
            background-color: #fafafa;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #e57a7a;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
             margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #d35c5c;
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

        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
            text-align: center;
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            z-index: 10;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
    <script>
        function hideMessage() {
            setTimeout(function() {
                const messageElement = document.querySelector('.message');
                if (messageElement) {
                    messageElement.style.display = 'none';
                }
            }, 3000);
        }

        window.onload = function() {
            const messageElement = document.querySelector('.message');
            if (messageElement) {
                hideMessage();
            }
        };
    </script>
</head>
<body>
    <div class="form-container">
        <h1>Edit User</h1>

        <?php if (isset($message)): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="edit.php">
            <!-- Pass the user ID via a hidden input -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" required><br>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="customer" <?php echo ($role == 'customer' ? 'selected' : ''); ?>>Customer</option>
                <option value="therapist" <?php echo ($role == 'therapist' ? 'selected' : ''); ?>>Therapist</option>
                <option value="admin" <?php echo ($role == 'admin' ? 'selected' : ''); ?>>Admin</option>
            </select><br>

            <input type="submit" value="Update User">
        </form>

        <br>
        <a href="index.php">Back to Users List</a>
    </div>
</body>
</html>
