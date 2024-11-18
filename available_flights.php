<?php
session_start();
require_once 'config.php';

if (isset($_POST['destination'], $_POST['seats'], $_POST['flight_class'])) {
    $destination = $conn->real_escape_string($_POST['destination']);
    $seats = (int) $_POST['seats'];
    $flight_class = $conn->real_escape_string($_POST['flight_class']);

    $sql = "SELECT * FROM flights 
            WHERE destination = ? 
            AND available_seats >= ? 
            AND flight_class = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $destination, $seats, $flight_class);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $flights = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $flights = [];
        $message = "No flights available for the selected destination and class.";
    }
} else {
    header("Location: reservation.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Flights</title>
    <link rel="stylesheet" href="tickets.css"> 
</head>
<body>
<div>
        <nav class="navbar">
        <div class="logo">
                <a href="#">Aéroport Monastir Habib Bourguiba</a>
            </div>
            <ul class="nav-links">
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="user_reservation.php">Reservation</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
        </nav>

</div>
    <center style="margin-top: 15%;" >
         <div class="container">
        <h2>Available Flights</h2>

        <?php if (!empty($flights)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Flight Number</th>
                        <th>Destination</th>
                        <th>Departure Date</th>
                        <th>Departure Time</th>
                        <th>Available Seats</th>
                        <th>Class</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($flights as $flight): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($flight['flight_number']); ?></td>
                            <td><?php echo htmlspecialchars($flight['destination']); ?></td>
                            <td><?php echo htmlspecialchars($flight['departure_date']); ?></td>
                            <td><?php echo htmlspecialchars($flight['departure_time']); ?></td>
                            <td><?php echo htmlspecialchars($flight['available_seats']); ?></td>
                            <td><?php echo htmlspecialchars($flight['flight_class']); ?></td>
                            <td>
                            <form action="confirm_flight.php" method="POST">
                                <input type="hidden" name="flight_id" value="<?php echo $flight['id']; ?>">
                                <input type="hidden" name="seats" value="<?php echo $seats; ?>">
                                <button type="submit" class="btn">Book This Flight</button>
                            </form>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <div class="back-link">
            <a href="dashboard.php">Go Back to Reservation Page</a>
        </div>
        
    </div>
    </center>
    
</body>
</html>
