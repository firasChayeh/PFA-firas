<?php
session_start();

// You can check if the user is logged in and/or the reservation was successful
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Success</title>
    <link rel="stylesheet" href="success.css">
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="#">Aéroport Monastir Habib Bourguiba</a>
        </div>
        <ul class="nav-links">
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="user_reservation.php">Reservation</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </div>

    <div class="container">
        <h2>Reservation Successful!</h2>
        <p>Your flight reservation has been confirmed.</p>
        <p>Thank you for booking with us!</p>
        <p><a href="dashboard.php" class="btn">Go to Dashboard</a></p>
    </div>
</body>
</html>
