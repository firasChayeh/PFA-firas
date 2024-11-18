<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT destination, departure_date, departure_time, flight_class 
        FROM reservations 
        WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); 
$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $departure_date = $conn->real_escape_string($_POST['date']);
    $departure_time = $conn->real_escape_string($_POST['time']);
    $destination = $conn->real_escape_string($_POST['destination']);
    $flight_class = $conn->real_escape_string($_POST['flight_class']);

   
    $insert_sql = "INSERT INTO reservations (user_id, flight_class, departure_date, departure_time, destination) 
                   VALUES (?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("issssi", $user_id, $flight_class, $departure_date, $departure_time, $destination);

    if ($insert_stmt->execute()) {
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
    <title>Reservation System</title>
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
        <h1>Welcome to the Airline Reservation System</h1>
        <p>Book your flights easily and quickly.</p>

        <?php if (isset($error)): ?>
            <div class="error-message" style="color: red;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="reservation-form">
    <h2>Make a Reservation</h2>
    <form action="available_flights.php" method="POST"> 
        <label for="destination">Destination:</label>
        <input type="text" id="destination" name="destination" required>

        <label for="seats">Number of Seats:</label>
        <input type="number" id="seats" name="seats" min="1" required>

        <label for="flight-class">Flight Class:</label>
        <select id="flight-class" name="flight_class" required>
            <option value="Economy">Economy</option>
            <option value="Business">Business</option>
            <option value="First Class">First Class</option>
        </select>

        <br><br>
        <button type="submit">Book Now</button>
    </form>
</div>


        <div class="destination-gallery">
            <h2>Popular Destinations</h2>
            <div class="gallery">
                <div class="gallery-item" onclick="setDestination(' France')">
                    <img src="p13.jpg" alt="Paris">
                    <p>France</p>
                </div>
                <div class="gallery-item" onclick="setDestination(' USA')">
                    <img src="nyc.jpg" alt="New York">
                    <p> USA</p>
                </div>
                <div class="gallery-item" onclick="setDestination('Dubai')">
                    <img src="dubai.jpg" alt="Dubai">
                    <p>Dubai </p>
                </div>
                <div class="gallery-item" onclick="setDestination('Tokyo')">
                    <img src="tokyo.jpg" alt="Tokyo">
                    <p>Tokyo</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setDestination(destination) {
            document.getElementById('destination').value = destination;
        }
    </script>
</body>
</html>
