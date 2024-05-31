<?php
session_start();
require_once '../../config.php';

$license_number = $_GET['license_number'];

$sql = "SELECT * FROM toll_data WHERE license_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $license_number);
$stmt->execute();
$result = $stmt->get_result();

echo '<table class="record-table">';
echo '<tr><th>Serial</th><th>License Number</th><th>Toll Fee</th><th>Payment Gateway</th><th>Date/Time</th></tr>';
while ($row = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$row['serial']}</td>
    <td>{$row['license_number']}</td>
    <td>{$row['toll_fee']}</td>
    <td>{$row['Payment_Gateway']}</td>
    <td>{$row['record_at']}</td>
    </tr>";
}
echo '</table>';

$stmt->close();
$conn->close();
?>
