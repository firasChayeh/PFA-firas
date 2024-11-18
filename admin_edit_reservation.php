<?php
session_start();
require_once 'config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$is_admin = $_SESSION['user_id'] === 'admin'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $flight_class = $conn->real_escape_string($_POST['flight_class']);
    $departure_date = $conn->real_escape_string($_POST['departure_date']);
    $departure_time = $conn->real_escape_string($_POST['departure_time']);
    $destination = $conn->real_escape_string($_POST['destination']);
    $seats = $conn->real_escape_string($_POST['seats']);

   
    $sql = "UPDATE reservations SET 
            flight_class = '$flight_class', 
            departure_date = '$departure_date', 
            departure_time = '$departure_time', 
            destination = '$destination', 
            seats = '$seats' 
            WHERE id = $id";

    
    if (!$is_admin) {
        $sql .= " AND user_id = $user_id";
    }

    if ($conn->query($sql) === TRUE) {
        
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Error updating record: " . $conn->error;
    }
} else {
    
    $sql = "SELECT * FROM reservations WHERE id = $id";

    
    if (!$is_admin) {
        $sql .= " AND user_id = $user_id";
    }

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $reservation = $result->fetch_assoc();
    } else {
        
        header("Location: dashboard.php"); 
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation - Airport Ticket System</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#">Aéroport Monastir Habib Bourguiba</a>
            </div>
            <ul class="nav-links">
                <li><a href="admin_dashboard.php">Home</a></li>
                <li><a href="reservation_list.php">Reservations</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <div class="reservation-form">
            <h2>Update Your Reservation</h2>
            <form action="" method="POST">
                <label for="flight_class">Flight Class:</label>
                <input type="text" id="flight_class" name="flight_class" placeholder="Flight Class" value="<?php echo htmlspecialchars($reservation['flight_class']); ?>" required>

                <label for="destination">Destination:</label>
                <input type="text" id="destination" name="destination" placeholder="Destination" value="<?php echo htmlspecialchars($reservation['destination']); ?>" required>

                <label for="seats">Number of Seats:</label>
                <input type="text" id="seats" name="seats" placeholder="Number of seats" value="<?php echo htmlspecialchars($reservation['seats']); ?>" required>

                <br><br>
                <button type="submit">Update Reservation</button><br><br>
                <a href="admin_dashboard.php"  style="color: red;">Back to Dashboard</a>
            </form>
        </div>
        
    </div>
</body>
</html>
