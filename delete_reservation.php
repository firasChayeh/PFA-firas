<?php
session_start();
require_once 'config.php';

// Ensure the user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Check if 'id' is set in the URL and is a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Use prepared statement to prevent SQL injection
    $sql = "DELETE FROM reservations WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    // Bind the parameter and execute the query
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect after successful deletion
        header("Location: reservation_list.php");
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
} else {
    // If no valid id is provided
    echo "Invalid reservation ID.";
}
?>
