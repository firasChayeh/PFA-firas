<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $flight_id = isset($_POST['flight_id']) ? $_POST['flight_id'] : '';
    if (!$flight_id) {
        echo "Error: Flight ID not found.";
        exit();
    }

    $flight_class = isset($_POST['flight_class']) ? $_POST['flight_class'] : '';
    $departure_date = isset($_POST['departure_date']) ? $_POST['departure_date'] : '';
    $departure_time = isset($_POST['departure_time']) ? $_POST['departure_time'] : '';
    $destination = isset($_POST['destination']) ? $_POST['destination'] : '';
    $seats = isset($_POST['seats']) ? $_POST['seats'] : 1;

    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO reservations (user_id, flight_id, seats, flight_class, departure_date, departure_time, destination)
            VALUES (?, ?, ?, ?, ?, ?,  ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("iiissss", $user_id, $flight_id, $seats, $flight_class, $departure_date, $departure_time,  $destination);

    if ($stmt->execute()) {
        header("Location: reservation_success.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
