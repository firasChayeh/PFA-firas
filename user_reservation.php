<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT id, destination, departure_date, departure_time,  flight_class ,seats
        FROM reservations 
        WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); 
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Reservations</title>
    <link rel="stylesheet" href="home.css">
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
    <div class="content">
        <h1>Your Reservations</h1>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Destination</th>
                    <th>Departure Date</th>
                    <th>Departure Time</th>
                    <th>Number of Seats</th>
                    <th>Flight Class</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['destination']); ?></td>
                        <td><?php echo htmlspecialchars($row['departure_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['departure_time']); ?></td>
                        <td><?php echo htmlspecialchars($row['seats']); ?></td>
                        <td><?php echo htmlspecialchars($row['flight_class']); ?></td>
                        <td>
                            <a href="edit_reservation.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a href="delete_reservation_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this reservation?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No reservations found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
