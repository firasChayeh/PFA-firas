<?php
session_start();
require_once 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Check if the reservation belongs to the current user
$sql = "SELECT * FROM reservations WHERE id = $id AND user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // If the reservation exists, delete it
    $sql = "DELETE FROM reservations WHERE id = $id AND user_id = $user_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the user dashboard or reservation list after successful deletion
        header("Location: dashboard.php"); // Or wherever you want to send the user
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "No reservation found or you are not authorized to delete this reservation.";
}
?>
