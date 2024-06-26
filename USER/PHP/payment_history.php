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
$stmt_user = $conn->prepare("SELECT vehicle_name, payment_gateway, payment_account_number FROM users WHERE license_number = ?");
$stmt_user->bind_param("s", $license_number);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user_data = $result_user->fetch_assoc();

// Close the user statement
$stmt_user->close();

// Fetch payment history from the database
$stmt_payment = $conn->prepare("SELECT Date, Time, toll_fee FROM toll_data WHERE license_number = ?");
$stmt_payment->bind_param("s", $license_number);
$stmt_payment->execute();
$result_payment = $stmt_payment->get_result();

// Initialize an empty array to store payment history
$payment_history = array();
$total_payment = 0;

// Fetch payment data and store it in the array
while ($row = $result_payment->fetch_assoc()) {
    $payment_history[] = $row;
    $total_payment += $row['toll_fee'];
}

// Close the payment statement
$stmt_payment->close();

$conn->close();

// Count the number of payment records
$payment_count = count($payment_history);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <link rel="stylesheet" href="../CSS/payment_history_styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.17/jspdf.plugin.autotable.min.js"></script>
   
    <script>
        function printPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            const table = document.getElementById('payment-table');
            const rows = table.querySelectorAll('tr');
            const tableData = [];

            rows.forEach((row, index) => {
                const rowData = [];
                const cells = row.querySelectorAll('th, td');
                cells.forEach(cell => rowData.push(cell.innerText));
                tableData.push(rowData);
            });

            const licenseNumber = '<?php echo htmlspecialchars($license_number); ?>';
            const vehicleName = '<?php echo htmlspecialchars($user_data["vehicle_name"]); ?>';
            const totalPayment = '<?php echo htmlspecialchars($total_payment); ?>';
            const paymentCount = '<?php echo htmlspecialchars($payment_count); ?>';

            doc.setFontSize(14);
            doc.text('Payment History', 14, 15);
            doc.setFontSize(12);
            doc.text(`License Number: ${licenseNumber}`, 14, 25);
            doc.text(`Vehicle Name: ${vehicleName}`, 14, 30);
            doc.text(`Total Payment: $${totalPayment}`, 14, 35);
            doc.text(`Count: ${paymentCount}`, 14, 40);

            doc.autoTable({
                startY: 45,
                head: [tableData[0]],
                body: tableData.slice(1),
                margin: { top: 10, bottom: 20 },
                didDrawPage: function (data) {
                    doc.setFontSize(10);
                    doc.text(`Generated: ${new Date().toLocaleString()}`, data.settings.margin.left, doc.internal.pageSize.height - 10);
                    doc.text(`Generated By: ${licenseNumber}, Smart Toll System`, data.settings.margin.left, doc.internal.pageSize.height - 5);
                },
                styles: {
                    fontSize: 10,
                },
                theme: 'striped'
            });

            doc.save('payment_history.pdf');
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Payment History</h1>
        <table id="payment-table">
            <caption>License Number: <?php echo htmlspecialchars($license_number); ?></caption>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Toll Fee</th>
                    <th>Payment Gateway</th>
                    <th>Payment Account Number</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payment_history as $payment) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($payment['Date']); ?></td>
                        <td><?php echo htmlspecialchars($payment['Time']); ?></td>
                        <td>$<?php echo htmlspecialchars($payment['toll_fee']); ?></td>
                        <td><?php echo htmlspecialchars($user_data['payment_gateway']); ?></td>
                        <td><?php echo htmlspecialchars($user_data['payment_account_number']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php if (count($payment_history) === 0) { ?>
            <p>No payment history available.</p>
        <?php } ?>
        <button class="back-button" onclick="window.location.href='user_dashboard.php'">Back</button>
        <button class="print-button" onclick="printPDF()">Print as PDF</button>
      
    </div>
    <footer>
        <p class="footer-company-name"><strong>&copy; 2024. Smart Toll System. </strong> All Rights Reserved.</p>
    </footer>
</body>
</html>
