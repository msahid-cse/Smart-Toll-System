<?php
require_once '../../config.php';

function fetchOnlineUsers($conn) {
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $users = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    return $users;
}

$users = fetchOnlineUsers($conn);

if (!empty($users)) {
    echo '<table class="record-table">';
    echo '<caption>Online User Record</caption>';
    echo '<tr><th>ID</th><th>Vehicle Name</th><th>License Number</th><th>Toll Fee</th><th>Password</th><th>Payment Gateway</th><th>Payment Account Number</th></tr>';
    foreach ($users as $user) {
        echo '<tr>';
        echo '<td>' . $user['id'] . '</td>';
        echo '<td>' . $user['vehicle_name'] . '</td>';
        echo '<td>' . $user['license_number'] . '</td>';
        echo '<td>' . $user['toll_fee'] . '</td>';
        echo '<td>' . $user['password'] . '</td>';
        echo '<td>' . $user['payment_gateway'] . '</td>';
        echo '<td>' . $user['payment_account_number'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>No online users found.</p>';
}
?>
