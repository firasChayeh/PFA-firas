<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$pageTitle = "Your Reservations";

$sql = "SELECT id, destination, departure_date, departure_time, flight_class, seats
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
    .card-header {
    padding: 2.5rem 3rem;
    border: none;
    z-index: 1;
}

.header-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
    transform: skewY(-3deg);
    transform-origin: top left;
    z-index: -1;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.header-content {
    position: relative;
    z-index: 2;
}

.header-icon {
    font-size: 2rem;
    color: rgba(255,255,255,0.9);
    animation: pulse 2s infinite;
}

.header-text {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

</style>
<div class="container py-5">
    <div class="card shadow-lg">
    <div class="card-header position-relative overflow-hidden">
    <div class="header-bg"></div>
    <div class="header-content">
        <h2 class="mb-0 d-flex align-items-center">
            <i class="fas fa-ticket-alt me-3 header-icon"></i>
            <span class="header-text">Your Reservations</span>
        </h2>
    </div>
</div>
        <div class="card-body p-4">
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th scope="col"><i class="fas fa-hashtag me-2"></i>ID</th>
                                <th scope="col"><i class="fas fa-plane-departure me-2"></i>Destination</th>
                                <th scope="col"><i class="fas fa-calendar me-2"></i>Departure Date</th>
                                <th scope="col"><i class="fas fa-clock me-2"></i>Departure Time</th>
                                <th scope="col"><i class="fas fa-chair me-2"></i>Seats</th>
                                <th scope="col"><i class="fas fa-layer-group me-2"></i>Class</th>
                                <th scope="col"><i class="fas fa-cogs me-2"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['destination']); ?></td>
                                    <td><?php echo htmlspecialchars($row['departure_date']); ?></td>
                                    <td><?php echo htmlspecialchars($row['departure_time']); ?></td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo htmlspecialchars($row['seats']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            <?php echo htmlspecialchars($row['flight_class']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="edit_reservation.php?id=<?php echo $row['id']; ?>" 
                                           class="btn btn-primary btn-sm me-2">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <a href="delete_reservation_user.php?id=<?php echo $row['id']; ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Are you sure you want to delete this reservation?');">
                                            <i class="fas fa-trash-alt me-1"></i>Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i>No reservations found.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
    overflow: hidden;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.875rem;
    letter-spacing: 0.5px;
}

.btn {
    border-radius: 5px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.badge {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 500;
}
</style>

<?php include 'components/footer.php'; ?>
