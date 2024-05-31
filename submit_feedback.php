<?php
// Include the database configuration file
include 'config.php';

// Get feedback from POST request
$feedback = $_POST['feedback'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO suggestion (feedback) VALUES (?)");
$stmt->bind_param("s", $feedback);

// Execute the statement
if ($stmt->execute()) {


    echo 'Feedback submitted successfully!';
} else {
    echo 'Error: ' . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
