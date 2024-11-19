<?php
session_start();
require_once 'config.php';
$pageTitle = "Confirm Flight";

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

include 'components/header.php';
include 'components/navbar.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-3">
                <div class="card-header bg-gradient text-white p-4" style="background: linear-gradient(45deg, #0062cc, #0096ff);">
                    <h2 class="text-center mb-0 fw-bold">
                    <div class="card-header bg-primary text-white">
                    <h2 class="text-center mb-0">Confirm Your Flight</h2>
</div                   >
                </div>
                
                <div class="card-body p-4">
                >
                    <div class="flight-info bg-light p-4 rounded-3 mb-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                        <i class="fas fa-plane text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Flight Number</small>
                                        <strong class="fs-5"><?php echo htmlspecialchars($flight['flight_number']); ?></strong>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                        <i class="fas fa-map-marker-alt text-success"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Destination</small>
                                        <strong class="fs-5"><?php echo htmlspecialchars($flight['destination']); ?></strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                                        <i class="fas fa-calendar text-warning"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Departure Date</small>
                                        <strong class="fs-5"><?php echo htmlspecialchars($flight['departure_date']); ?></strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box bg-info bg-opacity-10 p-3 rounded-circle me-3">
                                        <i class="fas fa-clock text-info"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Departure Time</small>
                                        <strong class="fs-5"><?php echo htmlspecialchars($flight['departure_time']); ?></strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box bg-danger bg-opacity-10 p-3 rounded-circle me-3">
                                        <i class="fas fa-chair text-danger"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Number of Seats</small>
                                        <strong class="fs-5"><?php echo htmlspecialchars($seats); ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="finalize_booking.php" method="POST">
                        <!-- Hidden inputs remain the same -->
                        <input type="hidden" name="flight_id" value="<?php echo htmlspecialchars($flight_id); ?>">
                        <input type="hidden" name="departure_date" value="<?php echo htmlspecialchars($flight['departure_date']); ?>">
                        <input type="hidden" name="departure_time" value="<?php echo htmlspecialchars($flight['departure_time']); ?>">
                        <input type="hidden" name="seats" value="<?php echo htmlspecialchars($seats); ?>">
                        <input type="hidden" name="flight_class" value="<?php echo htmlspecialchars($flight['flight_class']); ?>">
                        <input type="hidden" name="seat_number" value="<?php echo htmlspecialchars($seat_number); ?>">
                        <input type="hidden" name="destination" value="<?php echo htmlspecialchars($flight['destination']); ?>">

                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold">
                                <i class="fas fa-check-circle me-2"></i>Confirm and Pay
                            </button>
                            <a href="available_flights.php" class="btn btn-light btn-lg py-3">
                                <i class="fas fa-arrow-left me-2"></i>Back to Flights
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>
