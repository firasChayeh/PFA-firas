<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $flight_class = $conn->real_escape_string($_POST['flight_class']);
    $departure_date = $conn->real_escape_string($_POST['departure_date']);
    $departure_time = $conn->real_escape_string($_POST['departure_time']);
    $destination = $conn->real_escape_string($_POST['destination']);
    $seat_number = $conn->real_escape_string($_POST['seat_number']);

    $sql = "INSERT INTO reservations (user_id, flight_class, departure_date, departure_time, destination, seat_number) 
            VALUES ($user_id, '$flight_class', '$departure_date', '$departure_time', '$destination', '$seat_number')";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Reservation - Airport Ticket System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Create New Reservation</h1>
    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    <form action="" method="POST">
        <input type="text" name="flight_class" placeholder="flight_class" required>
        <input type="date" name="departure_date" required>
        <input type="time" name="departure_time" required>
        <input type="text" name="destination" placeholder="Destination" required>
        <input type="text" name="seat_number" placeholder="Seat Number" required>
        <button type="submit">Create Reservation</button>
    </form>
    <a href="dashboard.php" class="btn">Back to Dashboard</a>
</div>
</body>
</html>
