<?php
include('../../config.php');

$message = "";
$messageClass = "error"; // Default message class for errors

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists
    $sql_check = "SELECT * FROM admin_user_pass WHERE username = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        $message = "Username already in use, try again.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $sql_insert = "INSERT INTO admin_user_pass (username, password) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ss", $username, $hashed_password);
        $stmt_insert->execute();

        if ($stmt_insert->affected_rows > 0) {
            $message = "Admin created successfully. Redirecting to login page...";
            $messageClass = "success"; // Change message class to success
            echo "<script>
                    setTimeout(function(){
                        window.location.href = 'admin_login.php';
                    }, 3000);
                  </script>";
        } else {
            $message = "Error creating admin user: " . $conn->error;
        }

        $stmt_insert->close();
    }

    $stmt_check->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Admin User</title>
    <link rel="stylesheet" href="../CSS/create_new_admin_styles.css">
</head>
<body>
    <div class="container">
        <?php if (!empty($message)): ?>
            <p class="message <?php echo $messageClass; ?>"><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <div class="form-actions">
                <a href="admin_login.php" class="back-button">Back</a>
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
    <footer>
        <p class="footer-company-name"><strong>&copy; 2024. Smart Toll System</strong> All Rights Reserved.</p>
    </footer>
</body>
</html>
