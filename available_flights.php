<?php
session_start();
require_once 'config.php';

$pageTitle = "Available Flights";

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

include 'components/header.php';
include 'components/navbar.php';
?>

<!-- Main Content -->

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white">
                    <h2 class="text-center mb-0 py-3">
                        <i class="fas fa-plane-departure me-2"></i>Available Flights
                    </h2>
                </div>
                <div class="card-body p-4">
                    <?php if (!empty($flights)): ?>
                        <div class="table-responsive">
                        <style>
    .table-bordered-custom th,
    .table-bordered-custom td {
        border-right: 1px solid #dee2e6;
    }
    
    .table-bordered-custom th:last-child,
    .table-bordered-custom td:last-child {
        border-right: none;
    }
</style>

<table class="table table-hover table-striped table-bordered-custom">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="fw-bold"><i class="fas fa-plane me-2"></i>Flight Number</th>
                                        <th class="fw-bold"><i class="fas fa-map-marker-alt me-2"></i>Destination</th>
                                        <th class="fw-bold"><i class="fas fa-calendar me-2"></i>Departure Date</th>
                                        <th class="fw-bold"><i class="fas fa-clock me-2"></i>Departure Time</th>
                                        <th class="fw-bold"><i class="fas fa-chair me-2"></i>Available Seats</th>
                                        <th class="fw-bold"><i class="fas fa-star me-2"></i>Class</th>
                                        <th class="fw-bold"><i class="fas fa-ticket-alt me-2"></i>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($flights as $flight): ?>
                                        <tr class="align-middle">
                                            <td><?php echo htmlspecialchars($flight['flight_number']); ?></td>
                                            <td><?php echo htmlspecialchars($flight['destination']); ?></td>
                                            <td><?php echo htmlspecialchars($flight['departure_date']); ?></td>
                                            <td><?php echo htmlspecialchars($flight['departure_time']); ?></td>
                                            <td>
                                                <span >
                                                    <?php echo htmlspecialchars($flight['available_seats']); ?> seats
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?php echo htmlspecialchars($flight['flight_class']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <form action="confirm_flight.php" method="POST">
                                                    <input type="hidden" name="flight_id" value="<?php echo $flight['id']; ?>">
                                                    <input type="hidden" name="seats" value="<?php echo $seats; ?>">
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-book me-1"></i> Book Now
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-light text-center py-3">
                    <a href="dashboard.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Reservation Page
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include 'components/footer.php'; ?>
