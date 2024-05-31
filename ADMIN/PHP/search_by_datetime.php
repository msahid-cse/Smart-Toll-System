<?php
require_once '../../config.php';

if (isset($_GET['datetime'])) {
    $datetime = $_GET['datetime'];
    $sql = "SELECT * FROM toll_data WHERE record_at = '$datetime'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<h3>Search Results:</h3>';
        echo '<table class="record-table">';
        echo '<tr><th>Serial</th><th>License Number</th><th>Toll Fee</th><th>Payment Gateway</th><th>Record_at</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $toll['serial'] . '</td>';
            echo '<td>' . $toll['license_number'] . '</td>';
            echo '<td>' . $toll['toll_fee'] . '</td>';
            echo '<td>' . $toll['Payment_Gateway'] . '</td>';
            echo '<td>' . $toll['record_at'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No records found for the given date/time.</p>';
    }
} else {
    echo '<p>Invalid request.</p>';
}
?>
