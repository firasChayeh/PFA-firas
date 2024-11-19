<?php
session_start();
require_once 'config.php';
$pageTitle = "Dashboard - Airline Reservation";

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

include 'components/header.php';
include 'components/navbar.php';
?>

<style>
    .destination-card {
        transition: all 0.3s ease;
        cursor: pointer;
        overflow: hidden;
        border-radius: 15px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .destination-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }

    .destination-card img {
        height: 250px;
        width: 100%;
        object-fit: cover;
        transition: all 0.5s ease;
    }

    .destination-card:hover img {
        transform: scale(1.1);
    }

    .welcome-section {
        background: linear-gradient(135deg, #0061f2 0%, #00ba88 100%);
        padding: 3rem 0;
        margin-bottom: 3rem;
        color: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .booking-card {
        border: none;
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .booking-card .card-header {
        background: linear-gradient(135deg, #0061f2 0%, #00ba88 100%);
        border-radius: 15px 15px 0 0;
        padding: 1.5rem;
        color: white;
    }

    .form-control, .form-select {
        border-radius: 10px;
        padding: 0.8rem;
        border: 2px solid #e0e0e0;
        margin-bottom: 1rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0061f2;
        box-shadow: 0 0 0 0.2rem rgba(0,97,242,0.25);
    }

    .btn-book {
        background: linear-gradient(135deg, #0061f2 0%, #00ba88 100%);
        border: none;
        padding: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: white;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-book:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .destination-title {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 1rem;
        margin: 0;
        font-weight: 600;
        text-align: center;
    }
</style>

<div class="welcome-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold">Welcome to the Airline Reservation System</h1>
                <p class="lead">Experience luxury and comfort in every journey</p>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="booking-card card">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="fas fa-ticket-alt me-2"></i>Make a Reservation</h2>
                </div>
                <div class="card-body">
                    <form action="available_flights.php" method="POST">
                        <div class="mb-3">
                            <label for="destination" class="form-label">Destination:</label>
                            <input type="text" class="form-control" id="destination" name="destination" required>
                        </div>

                        <div class="mb-3">
                            <label for="seats" class="form-label">Number of Seats:</label>
                            <input type="number" class="form-control" id="seats" name="seats" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label for="flight-class" class="form-label">Flight Class:</label>
                            <select class="form-select" id="flight-class" name="flight_class" required>
                                <option value="Economy">Economy</option>
                                <option value="Business">Business</option>
                                <option value="First Class">First Class</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-book w-100">
                            <i class="fas fa-plane-departure me-2"></i>Book Now
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h2 class="h5 mb-0"><i class="fas fa-globe me-2"></i>Popular Destinations</h2>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="destination-card" onclick="setDestination('France')">
                                <div class="position-relative">
                                    <img src="p13.jpg" alt="Paris">
                                    <p class="destination-title">France</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="destination-card" onclick="setDestination('USA')">
                                <div class="position-relative">
                                    <img src="nyc.jpg" alt="New York">
                                    <p class="destination-title">USA</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="destination-card" onclick="setDestination('Dubai')">
                                <div class="position-relative">
                                    <img src="dubai.jpg" alt="Dubai">
                                    <p class="destination-title">Dubai</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="destination-card" onclick="setDestination('Tokyo')">
                                <div class="position-relative">
                                    <img src="tokyo.jpg" alt="Tokyo">
                                    <p class="destination-title">Tokyo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function setDestination(destination) {
        document.getElementById('destination').value = destination;
    }
</script>

<?php include 'components/footer.php'; ?>
