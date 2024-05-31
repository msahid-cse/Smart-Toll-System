<?php
require_once '../../config.php';

function fetchTollRecords($conn) {
    $sql = "SELECT * FROM toll_data";
    $result = $conn->query($sql);
    $tolls = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tolls[] = $row;
        }
    }

    return $tolls;
}

$tolls = fetchTollRecords($conn);

if (!empty($tolls)) {
    echo '<table class="record-table">';
    echo '<caption>Collected Toll Records</caption>';
    echo '<tr><th>Serial</th><th>License Number</th><th>Toll Fee</th><th>Payment Gateway</th><th>Record_at</th></tr>';
    foreach ($tolls as $toll) {
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
    echo '<p>No toll records found.</p>';
}
?>
