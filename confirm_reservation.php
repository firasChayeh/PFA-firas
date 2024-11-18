<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['flight_id']) || !isset($_GET['seats'])) {
    header("Location: dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$flight_id = (int)$_GET['flight_id'];
$seats = (int)$_GET['seats'];


$sql = "SELECT available_seats FROM flights WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $flight_id);
$stmt->execute();
$result = $stmt->get_result();
$flight = $result->fetch_assoc();

if ($flight['available_seats'] >= $seats) {
    $update_sql = "UPDATE flights SET available_seats = available_seats - ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ii", $seats, $flight_id);
    $update_stmt->execute();

    
    $insert_sql = "INSERT INTO reservations (user_id, flight_id, seats_reserved) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("iii", $user_id, $flight_id, $seats);
    $insert_stmt->execute();

    header("Location: dashboard.php?reservation_success=true");
    exit();
} else {
    header("Location: available_flights.php?error=Not enough seats available");
    exit();
}
?>
