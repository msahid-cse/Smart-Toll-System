<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="../CSS/user_login_styles.css">
 
</head>
<body>
    <div class="container">
        <h1>User Login</h1>
        <!-- User login form -->
        <form action="" method="POST">
            <div class="form-group">
                <label for="license_number">license_number</label>
                <input type="text" id="license_number" name="license_number" required>
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
        <!-- PHP code for user login -->
        <?php
            session_start(); // Start the session at the beginning

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                include('../../config.php'); // Make sure your config.php includes $conn for the database connection

                $license_number = $_POST['license_number'];
                $password = $_POST['password'];
                
                // Set session variables
                $_SESSION['user_license_number'] = $license_number;

                // Your authentication logic here
                // Example: Check license_number and password against your database
                
                // // Prepare and bind
                // $stmt = $conn->prepare("SELECT * FROM users WHERE license_number = ?");
                // $stmt->bind_param("s", $license_number);

                // // Execute statement
                // $stmt->execute();

                // // Get the result
                // $result = $stmt->get_result();

                // if ($result->num_rows > 0) {
                //     $row = $result->fetch_assoc();
                //     // Verify password
                //     if (password_verify($password, $row['password'])) {
                //         // Set session variables
                //         $_SESSION['user_logged_in'] = true;
                        
                //         // Redirect to admin control panel
                //         header("Location: user_dashboard.php");
                //         exit();
                //     } else {
                //         echo '<p class="form-group">Invalid password.</p>';
                //     }
                // } else {
                //     echo '<p class="form-group">Invalid license_number.</p>';
                // }
                // Prepare and bind
                $stmt = $conn->prepare("SELECT * FROM users WHERE license_number = ?");
                $stmt->bind_param("s", $license_number);

                // Execute statement
                $stmt->execute();

                // Get the result
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    // Verify password
                    if (password_verify($password, $row['password'])) {
                        // Set session variables
                        $_SESSION['user_logged_in'] = true;
                        
                        // Redirect to admin control panel
                      header("Location: user_dashboard.php");
                      // header("welcome.html");
                        exit();
                    } else {
                        echo '<p class="form-group">Invalid password.</p>';
                    }
                } else {
                    echo '<p class="form-group">Invalid license_number.</p>';
                }                
                // Close connection
                $stmt->close();
                $conn->close();
            }
        ?>
        <!-- Link to user registration -->
        <p>Don't have an account? <a href="user_registration.php">Register here</a></p>
    </div>
    <footer>
        <p class="footer-company-name"><strong>&copy; 2024. Smart Toll System.</strong> All Rights Reserved.</p>
    </footer>
</body>
</html>
