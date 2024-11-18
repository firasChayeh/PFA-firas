<?php
session_start();
require_once 'config.php';

if (!isset($_POST['flight_id'])) {
    header("Location: available_flights.php");
    exit();
}

$flight_id = $_POST['flight_id'];
$seats = $_POST['seats'];

$sql = "SELECT * FROM flights WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $flight_id);
$stmt->execute();
$result = $stmt->get_result();
$flight = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Flight</title>
    <link rel="stylesheet" href="confirm.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="#">Aéroport Monastir Habib Bourguiba</a>
        </div>
        <ul class="nav-links">
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="user_reservation.php">Reservation</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Confirm Your Flight</h2>
        <div class="confirm-details">
            <p><strong>Flight Number:</strong> <?php echo htmlspecialchars($flight['flight_number']); ?></p>
            <p><strong>Destination:</strong> <?php echo htmlspecialchars($flight['destination']); ?></p>
            <p><strong>Departure Date:</strong> <?php echo htmlspecialchars($flight['departure_date']); ?></p>
            <p><strong>Departure Time:</strong> <?php echo htmlspecialchars($flight['departure_time']); ?></p>
            <p><strong>Seats:</strong> <?php echo htmlspecialchars($seats); ?></p>
        </div>

        <form action="finalize_booking.php" method="POST">
            <input type="hidden" name="flight_id" value="<?php echo htmlspecialchars($flight_id); ?>">
            <input type="hidden" name="departure_date" value="<?php echo htmlspecialchars($flight['departure_date']); ?>">
            <input type="hidden" name="departure_time" value="<?php echo htmlspecialchars($flight['departure_time']); ?>">
            <input type="hidden" name="seats" value="<?php echo htmlspecialchars($seats); ?>">
            <input type="hidden" name="flight_class" value="<?php echo htmlspecialchars($flight['flight_class']); ?>">
            <input type="hidden" name="seat_number" value="<?php echo htmlspecialchars($seat_number); ?>">
            <input type="hidden" name="destination" value="<?php echo htmlspecialchars($flight['destination']); ?>">

            <button type="submit" class="btn-confirm">Confirm Booking</button>
        </form>


        
        <div class="back-link">
            <a href="available_flights.php">Go Back to Available Flights</a>
        </div>
    </div>
</body>
</html>
