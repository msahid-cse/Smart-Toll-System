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

// Fetch user details from the database
$stmt = $conn->prepare("SELECT * FROM users WHERE license_number = ?");
$stmt->bind_param("s", $license_number);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Close the statement
$stmt->close();

// Initialize message
$message = "";

// Check if PIN is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pin'])) {
    $pin = $_POST['pin'];

    // Verify the hashed PIN
    if (password_verify($pin, $user['password'])) {
        $toll_fee = $user['toll_fee']; // Example toll fee
        $current_balance = $user['current_balance'];

        if ($current_balance < $toll_fee) {
            $message = "Insufficient balance.";
        } else {
            $new_balance = $current_balance - $toll_fee;

            // Update user balance
            $update_sql = $conn->prepare("UPDATE users SET current_balance = ? WHERE license_number = ?");
            $update_sql->bind_param("is", $new_balance, $license_number);
            $update_sql->execute();
            $update_sql->close();

            // Insert toll data
            $insert_sql = $conn->prepare("INSERT INTO toll_data (license_number, toll_fee, Payment_Gateway, record_at, Date, Time) VALUES (?, ?, 'online', current_timestamp(), current_date(), current_time())");
            $insert_sql->bind_param("si", $license_number, $toll_fee);
            $insert_sql->execute();
            $insert_sql->close();

            $message = "Payment successful. Your new balance is $" . $new_balance;

            // Redirect to the main user dashboard after a short delay
            header("refresh:3;url=user_dashboard.php");
        }
    } else {
        $message = "Invalid Password. Please try again.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../CSS/user_dashboard_styles.css">
    
    <script>
        function showPinInput() {
            var pinInput = document.querySelector('.input-pin');
            if (pinInput.style.display === 'none' || pinInput.style.display === '') {
                pinInput.style.display = 'block';
            } else {
                pinInput.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="left-column">
            <h1>Confirm Your Payment</h1>
            <form method="POST">
                <button type="button" onclick="showPinInput()" id="ok-button">OK</button>
                <div class="input-pin" style="display:none;">
                    <input type="password" name="pin" placeholder="Enter The Password" required>
                    <button type="submit" id="confirm-button">Confirm</button>
                </div>
            </form>
            <?php if (isset($message)) { ?>
                <p class="message"><?php echo $message; ?></p>
            <?php } ?>
        </div>
        <div class="right-column">
            <div class="row">
                <h2>User Information</h2>
                <!-- Add more user details as needed -->
                <table style="width: 100%;" class="record-table">
                    <tr>
                        <th style="text-align: left;">Information</th>
                        <th style="text-align: left;">Value</th>
                    </tr>
                    <tr>
                        <td>User License Number</td>
                        <td><?php echo htmlspecialchars($user['license_number']); ?></td>
                    </tr>
                    <tr>
                        <td>Toll Fee</td>
                        <td><?php echo htmlspecialchars($user['toll_fee']); ?></td>
                    </tr>
                    <tr>
                        <td>Vehicle Name</td>
                        <td><?php echo htmlspecialchars($user['vehicle_name']); ?></td>
                    </tr>
                    <tr>
                        <td>Payment Gateway</td>
                        <td><?php echo htmlspecialchars($user['payment_gateway']); ?></td>
                    </tr>
                    <tr>
                        <td>Payment Account Number</td>
                        <td><?php echo htmlspecialchars($user['payment_account_number']); ?></td>
                    </tr>
                    <tr>
                        <td>Current Balance</td>
                        <td><?php echo htmlspecialchars($user['current_balance']); ?></td>
                    </tr>
                </table>
            </div>
            <div class="row button-container">
                <div class="button-group">
                    <button id="back-button" onclick="window.location.href='user_login.php'">Back</button>
                    <a href="update_information.php">Update Information</a>
                    <a href="payment_history.php">Payment History</a>
                    <a href="delete_account.php">Delete Account</a>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p class="footer-company-name"><strong>&copy; 2024. Smart Toll System.</strong> All Rights Reserved.</p>
    </footer>
</body>
</html>
