<?php
session_start();
include 'config.php'; // Use config.php for the connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ticket_id'])) {
        $ticket_id = $_POST['ticket_id'];

        // Prepare and execute the update query
        $update_query = "UPDATE tickets SET is_booked = 1, user_id = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param('ii', $_SESSION['user_id'], $ticket_id); 
        if ($stmt->execute()) {
            echo "Ticket booked successfully!";
        } else {
            echo "Error booking ticket: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "No ticket ID provided.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close(); // Close the connection
?>
