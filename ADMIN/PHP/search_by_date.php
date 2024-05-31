<?php
require_once '../../config.php';

if (isset($_GET['date'])) {
    $date = $_GET['date'];
    $sql = "SELECT * FROM toll_data WHERE DATE(record_at) = '$date'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<h3>Search Results:</h3>';
        echo '<table class="record-table">';
        echo '<tr><th>Serial</th><th>License Number</th><th>Toll Fee</th><th>Payment Gateway</th><th>Record_at</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['serial'] . '</td>';
            echo '<td>' . $row['license_number'] . '</td>';
            echo '<td>' . $row['toll_fee'] . '</td>';
            echo '<td>' . $row['Payment_Gateway'] . '</td>';
            echo '<td>' . $row['record_at'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No records found for the given date.</p>';
    }
} else {
    echo '<p>Invalid request.</p>';
}
?>
