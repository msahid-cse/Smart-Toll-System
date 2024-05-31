<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../CSS/admin_login_styles.css">
</head>
<body>
    <div class="container">
        <h1>Admin Login</h1>
        <!-- Admin login form -->
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="button-group">
                <a href="../../welcome.html" class="back-button">Back</a>
                <button type="submit">Login</button>
            </div>
        </form>
        <?php
            session_start(); // Start the session at the beginning

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                include('../../config.php'); // Make sure your config.php includes $conn for the database connection

                $username = $_POST['username'];
                $password = $_POST['password'];
                
                // Set session variables
                $_SESSION['admin_username'] = $username;

                // Check for special username and password
                if ($username == 'createnewadmin' && $password == 'createnewpassword') {
                    header("Location: create_new_admin.php");
                    exit();
                }

                // Prepare and bind
                $stmt = $conn->prepare("SELECT * FROM admin_user_pass WHERE username = ?");
                $stmt->bind_param("s", $username);

                // Execute statement
                $stmt->execute();

                // Get the result
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    // Verify password
                    if (password_verify($password, $row['password'])) {
                        // Set session variables
                        $_SESSION['admin_logged_in'] = true;
                        
                        // Redirect to admin control panel
                        header("Location: admin_control_panel.php");
                        exit();
                    } else {
                        echo '<p class="form-group">Invalid password.</p>';
                    }
                } else {
                    echo '<p class="form-group">Invalid username.</p>';
                }

                // Close connection
                $stmt->close();
                $conn->close();
            }
        ?>
    </div>
    <footer>
        <p class="footer-company-name"><strong>&copy; 2024. Smart Toll System.</strong> All Rights Reserved.</p>
    </footer>
</body>
</html>
