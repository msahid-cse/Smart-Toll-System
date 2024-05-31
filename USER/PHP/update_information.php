<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: user_login.php");
    exit();
}

// Include the database configuration file
include('../../config.php');

// Initialize variables
$message = '';

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

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form data
    $update_payment_gateway = isset($_POST['payment_gateway']) ? $_POST['payment_gateway'] : '';
    $update_password = isset($_POST['password']) ? $_POST['password'] : '';
    $update_payment_account_number = isset($_POST['payment_account_number']) ? $_POST['payment_account_number'] : '';
    $update_account_pin_number = isset($_POST['account_pin_number']) ? $_POST['account_pin_number'] : '';

    // Update user information in the database
    $update_sql = $conn->prepare("UPDATE users SET payment_gateway = ?, payment_account_number = ?, account_pin_number = ? WHERE license_number = ?");
    $update_sql->bind_param("ssss", $update_payment_gateway, $update_payment_account_number, $update_account_pin_number, $license_number);

    // Check if password is provided to update
    if (!empty($update_password)) {
        $hashed_password = password_hash($update_password, PASSWORD_DEFAULT);
        $update_sql = $conn->prepare("UPDATE users SET payment_gateway = ?, password = ?, payment_account_number = ?, account_pin_number = ? WHERE license_number = ?");
        $update_sql->bind_param("sssss", $update_payment_gateway, $hashed_password, $update_payment_account_number, $update_account_pin_number, $license_number);
    }

    if ($update_sql->execute()) {
        $message = "Information updated successfully. Redirecting to User Dashboard page.....";
        echo "<script>
        setTimeout(function(){
            window.location.href = 'user_dashboard.php';
        }, 3000);
      </script>";
    } else {
        $message = "Error updating information.";
    }

    $update_sql->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Information</title>
    <link rel="stylesheet" href="../CSS/update_information_styles.css">
   
</head>
<body>
    <div class="container">
        <h1>Update Information</h1>
        <?php if (!empty($message)) { ?>
            <p class="message"><?php echo $message; ?></p>
        <?php } ?>
        <form method="POST">
            <label for="payment_gateway">Payment Gateway:</label>
            <select id="payment_gateway" name="payment_gateway">
                <option value="PayPal" <?php if ($user['payment_gateway'] === "PayPal") echo "selected"; ?>>PayPal</option>
                <option value="Stripe" <?php if ($user['payment_gateway'] === "Stripe") echo "selected"; ?>>Stripe</option>
                <option value="Square" <?php if ($user['payment_gateway'] === "Square") echo "selected"; ?>>Square</option>
                <!-- Add more payment gateways as needed -->
            </select>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="">
            
            <label for="payment_account_number">Payment Account Number:</label>
            <input type="text" id="payment_account_number" name="payment_account_number" value="<?php echo htmlspecialchars($user['payment_account_number']); ?>">
            
            <label for="account_pin_number">Account PIN Number:</label>
            <input type="password" id="account_pin_number" name="account_pin_number" value="">
            
            <button class="back-button" onclick="window.location.href='user_dashboard.php'">Back</button>
            <button type="submit">Update</button>
        </form>
    </div>
    <footer>
        <p class="footer-company-name"><strong>&copy; 2024. Smart Toll System. </strong> All Rights Reserved.</p>
    </footer>
</body>
</html>
