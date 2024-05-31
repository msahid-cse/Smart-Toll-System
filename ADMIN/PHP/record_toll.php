<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include the database connection from config.php
    require '../../config.php';

    // Generate a random license number
    $license_number = 'LIC' . rand(1000, 9999);
    $toll_fee = $_POST['toll_fee'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO toll_data (license_number, toll_fee, payment_gateway) VALUES (?, ?, 'Cash')");
    $stmt->bind_param("si", $license_number, $toll_fee);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "license_number" => $license_number]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to record data"]);
    }

    // Close the connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
