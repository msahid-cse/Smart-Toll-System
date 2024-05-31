<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: user_login.php");
    exit();
}

// Include the database configuration file
include('../../config.php');

// Get the user's license number from the session
$license_number = $_SESSION['user_license_number'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if delete confirmation is received
    if (isset($_POST['confirm_delete'])) {
        // Delete the user's account from the database
        $delete_sql = $conn->prepare("DELETE FROM users WHERE license_number = ?");
        $delete_sql->bind_param("s", $license_number);
        
        if ($delete_sql->execute()) {
            // Account deleted successfully, logout user and redirect to login page
            session_unset();
            session_destroy();
            header("Location: user_login.php");
            exit();
        } else {
            $message = "Error deleting account. Please try again.";
        }

        $delete_sql->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" href="../CSS/delete_account_styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../../Image/welcome_page_background3.avif');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.3);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(60, 64, 67, 0.3), 0 4px 8px rgba(60, 64, 67, 0.15);
            text-align: center;
        }
        h1 {
            margin-top: 0;
            color: #333;
        }
        p {
            color: #333;
        }
        .message {
            color: red;
            font-weight: bold;
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            background-color: #248671;
            color: #fff;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: red;
        }
        button[type="button"] {
            background-color: #248671;
        }
        button[type="button"]:hover {
            background-color: green;
        }
        footer {
            position: absolute;
            bottom: 0;
            text-align: center;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px 0;
        }
        .footer-company-name {
            margin: 0;
            padding: 0;
            font-size: 1em;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delete Account</h1>
        <p>Are you sure you want to delete your account?</p>
        <form method="POST">
            <button type="submit" name="confirm_delete">Delete Account</button>
            <button type="button" onclick="window.location.href='user_dashboard.php'">Cancel</button>
        </form>
        <?php if (isset($message)) { ?>
            <p class="message"><?php echo $message; ?></p>
        <?php } ?>
    </div>
    <footer>
        <p class="footer-company-name"><strong>&copy; 2024. Smart Toll System.</strong> All Rights Reserved.</p>
    </footer>
</body>
</html>
