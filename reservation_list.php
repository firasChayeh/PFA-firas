<?php
session_start();
require_once 'config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== 'admin') {
    header("Location: login.php");
    exit();
}


$sql = "SELECT r.id, r.destination, r.departure_date, r.departure_time, r.seats, r.flight_class, u.firstname, u.lastname 
        FROM reservations r 
        JOIN users u ON r.user_id = u.id"; 

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation List</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#">Admin Panel</a>
            </div>
            <ul class="nav-links">
                <li><a href="admin_dashboard.php">Home</a></li>
                <li><a href="reservation_list.php">Reservations</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </nav>

    <div class="content">
        <h1>Reservation List</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>User Name</th>
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
                    <td><?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?></td>
                    <td><?php echo htmlspecialchars($row['destination']); ?></td>
                    <td><?php echo htmlspecialchars($row['departure_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['departure_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['seats']); ?></td>
                    <td><?php echo htmlspecialchars($row['flight_class']); ?></td>
                    <td>
                        
                        <a href="admin_edit_reservation.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                        <a href="delete_reservation.php?id=<?php echo $row['id']; ?>" class="btn" 
                           onclick="return confirm('Are you sure you want to delete this reservation?');">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
