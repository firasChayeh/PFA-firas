<?php
session_start();
require_once 'config.php';
$pageTitle = "Reservation List - Admin Panel";

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT r.id, r.destination, r.departure_date, r.departure_time, r.seats, r.flight_class, u.firstname, u.lastname 
        FROM reservations r 
        JOIN users u ON r.user_id = u.id"; 

$result = $conn->query($sql);

include 'components/header.php';
include 'components/navbar.php';
?>

<style>
    .reservation-container {
        background: linear-gradient(135deg, rgba(0,97,242,0.1) 0%, rgba(0,186,136,0.1) 100%);
        min-height: 100vh;
        padding: 3rem 0;
    }

    .reservation-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .reservation-header {
        background: linear-gradient(135deg, #0061f2 0%, #00ba88 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .table-container {
        padding: 1.5rem;
        overflow-x: auto;
    }

    .reservation-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .reservation-table th {
        background: #f8f9fa;
        padding: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .reservation-table td {
        padding: 1rem;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
    }

    .reservation-table tr:hover {
        background-color: #f8f9fa;
    }

    .btn-action {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        margin: 0.25rem;
        transition: all 0.3s ease;
    }

    .btn-edit {
        background: #0061f2;
        color: white;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .status-active {
        background: #d4edda;
        color: #155724;
    }
</style>

<div class="reservation-container">
    <div class="container">
        <div class="reservation-card">
            <div class="reservation-header">
                <h2 class="mb-0">
                    <i class="fas fa-list me-2"></i>Reservation List
                </h2>
            </div>

            <div class="table-container">
                <table class="reservation-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Destination</th>
                            <th>Departure Date</th>
                            <th>Departure Time</th>
                            <th>Seats</th>
                            <th>Class</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td>
                                    <i class="fas fa-user me-2"></i>
                                    <?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?>
                                </td>
                                <td>
                                    <i class="fas fa-plane-departure me-2"></i>
                                    <?php echo htmlspecialchars($row['destination']); ?>
                                </td>
                                <td>
                                    <i class="fas fa-calendar me-2"></i>
                                    <?php echo htmlspecialchars($row['departure_date']); ?>
                                </td>
                                <td>
                                    <i class="fas fa-clock me-2"></i>
                                    <?php echo htmlspecialchars($row['departure_time']); ?>
                                </td>
                                <td>
                                    <i class="fas fa-chair me-2"></i>
                                    <?php echo htmlspecialchars($row['seats']); ?>
                                </td>
                                <td>
                                    <span class="status-badge status-active">
                                        <?php echo htmlspecialchars($row['flight_class']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="admin_edit_reservation.php?id=<?php echo $row['id']; ?>" 
                                       class="btn-action btn-edit">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <a href="delete_reservation.php?id=<?php echo $row['id']; ?>" 
                                       class="btn-action btn-delete"
                                       onclick="return confirm('Are you sure you want to delete this reservation?');">
                                        <i class="fas fa-trash-alt me-1"></i>Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>
