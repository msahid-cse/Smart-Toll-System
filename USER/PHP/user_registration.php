<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <link rel="stylesheet" href="../CSS/user_registration_styles.css">

</head>
<body>
    <div class="container">
        <h1>Register New Vehicle</h1>
        <?php
        include('../../config.php');
        $message = "";
        $messageClass = "error"; // Default message class for errors

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vehicleName = $_POST['vehicleName'];
            $licenseNumber = $_POST['licenseNumber'];
            $tollFee = $_POST['tollFee'];
            $password = $_POST['password'];
            $paymentGateway = $_POST['paymentGateway'];
            $paymentAccountNumber = $_POST['paymentAccountNumber'];
            $accountPinNumber = $_POST['accountPinNumber'];
            $currentBalance = $_POST['currentBalance'];

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            //Hash the Account Pin
            $hashed_pin = password_hash($accountPinNumber, PASSWORD_DEFAULT);

            // Prepare and execute SQL statement to insert data into the users table
            $sql_insert = "INSERT INTO users (vehicle_name, license_number, toll_fee, password, payment_gateway, payment_account_number, account_pin_number, current_balance) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ssssssss", $vehicleName, $licenseNumber, $tollFee, $hashed_password, $paymentGateway, $paymentAccountNumber, $hashed_pin, $currentBalance);
            $stmt_insert->execute();

            if ($stmt_insert->affected_rows > 0) {
                $message = "Vehicle registered successfully. Redirecting to login page...";
                $messageClass = "success";
                
                // Redirect to login page after a short delay
                echo "<script>
                        setTimeout(function(){
                            window.location.href = 'user_login.php';
                        }, 3000);
                      </script>";
            } else {
                $message = "Error registering vehicle: " . $conn->error;
                $messageClass = "error";
            }

            $stmt_insert->close();
            $conn->close();
        }
        ?>
        <form id="registrationForm" action="" method="post">
            <div class="form-group">
                <label for="vehicleName">Vehicle Name:</label>
                <select id="vehicleName" name="vehicleName" required>
                    <option value="Motorcycle">Motorcycle</option>
                    <option value="Car-Jeep">Car-Jeep</option>
                    <option value="Pickup">Pickup</option>
                    <option value="Micro-bus">Microbus</option>
                    <option value="Mini-bus">Minibus</option>
                    <option value="Medium-bus">Medium bus</option>
                    <option value="Big-bus">Big bus</option>
                    <option value="Truck-upto-5-tonnes">Truck (upto 5 tonnes)</option>
                    <option value="Truck-5-to-8-tonnes">Truck (5-8 tonnes)</option>
                    <option value="Truck-3-axle">Truck (3 axle)</option>
                    <option value="Trailer-4-axle">Trailer (4 axle)</option>

                </select>
            </div>
            <div class="form-group">
                <label for="licenseNumber">License Number:</label>
                <input type="text" id="licenseNumber" name="licenseNumber" required>
            </div>
            <div class="form-group">
                <label for="tollFee">Toll Fee:</label>
                <select id="tollFee" name="tollFee" required>
                    <option  value="100">Motorcycle - Tk:100</option>
                    <option  value="750">Car/Jeep - Tk:750</option>
                    <option value="1200">Pickup - Tk:1200</option>
                    <option value="1300">Microbus - Tk:1300</option>
                    <option value="1400">Minibus - Tk:1400</option>
                    <option value="2000">Medium bus - Tk:2000</option>
                    <option value="2400">Big bus - Tk:2400</option>
                    <option value="1600">Truck (upto 5 tonnes) - Tk:1600</option>
                    <option value="2100">Truck (5-8 tonnes) - Tk:2100</option>
                    <option value="5500">Truck (3 axle) - Tk:5500</option>
                    <option value="6000"> Trailer (4 axle) - Tk:6000</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Set Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="paymentGateway">Payment Gateway:</label>
                <select id="paymentGateway" name="paymentGateway" required>
                    <option value="Bkash">Bkash</option>
                    <option value="Nagad">Nagad</option>
                    <option value="Rocket">Rocket</option>
                    <option value="SureCash">SureCash</option>
                    <option value="MCash">MCash</option>
                    <option value="Upay">Upay</option>
                </select>
            </div>
            <div class="form-group">
                <label for="paymentAccountNumber">Payment Account Number:</label>
                <input type="number" id="paymentAccountNumber" name="paymentAccountNumber" required>
            </div>
            <div class="form-group">
                <label for="accountPinNumber">Account Pin Number:</label>
                <input type="password" id="accountPinNumber" name="accountPinNumber" pattern="\d*" inputmode="numeric" required>
            </div>
            <div class="form-group">
                <label for="currentBalance">Current Balance:</label>
                <input type="number" id="currentBalance" name="currentBalance" inputmode="numeric" required>
            </div>
            <div class="form-actions">
                <button type="button" class="btn" onclick="window.location.href='user_login.php'">Back</button>
                <button type="submit" class="btn">Submit</button>
            </div>
        </form>
        <p class="message" id="message"><?php echo isset($message) ? $message : ''; ?></p>
    </div>
    <footer>
        <p class="footer-company-name"><strong>© 2024. Smart Toll System</strong> All Rights Reserved.</p>
    </footer>
<script>
// Client-side validation
document.getElementById("registrationForm").addEventListener("submit", function(event) {
    var licenseNumber = document.getElementById("licenseNumber").value;
    var paymentAccountNumber = document.getElementById("paymentAccountNumber").value;
    var accountPinNumber = document.getElementById("accountPinNumber").value;

    // License number should contain only alphanumeric characters
    var alphanumericRegex = /^[a-zA-Z0-9]+$/;
    if (!alphanumericRegex.test(licenseNumber)) {
        alert("License number should contain only alphanumeric characters.");
        event.preventDefault();
        return;
    }

    // Payment account number and account pin number should be numeric
    var numericRegex = /^\d+$/;
    if (!numericRegex.test(paymentAccountNumber) || !numericRegex.test(accountPinNumber)) {
        alert("Payment account number and account pin number should contain only numeric characters.");
        event.preventDefault();
        return;
    }

});
</script>
</body>
</html>
