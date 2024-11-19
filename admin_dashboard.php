<?php
session_start();
require_once 'config.php';
$pageTitle = "Admin Dashboard";

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch statistics
$sql = "SELECT COUNT(id) AS total_reservations FROM reservations";
$result = $conn->query($sql);
$total_reservations = $result->fetch_assoc()['total_reservations'];

$sql = "SELECT r.id, r.destination, r.departure_date, r.departure_time, r.seats, r.flight_class, u.firstname, u.lastname 
        FROM reservations r 
        JOIN users u ON r.user_id = u.id 
        ORDER BY r.departure_date DESC";
$reservations_result = $conn->query($sql);

include 'components/header.php';
?>

<style>
    .dashboard-container {
        display: flex;
        min-height: 100vh;
        background: #f8f9fa;
    }

    .hamburger-menu {
        display: none;
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 1000;
        background: #0061f2;
        color: white;
        border: none;
        padding: 0.5rem;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .sidebar {
        width: 280px;
        background: linear-gradient(135deg, #0061f2 0%, #00ba88 100%);
        padding: 2rem;
        position: fixed;
        height: 100vh;
        overflow-y: auto;
        z-index: 999;
        transition: transform 0.3s ease;
    }

    .sidebar-brand {
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .nav-item {
        margin-bottom: 0.5rem;
    }

    .nav-link {
        color: rgba(255,255,255,0.8);
        padding: 0.75rem 1rem;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
    }

    .nav-link:hover, .nav-link.active {
        background: rgba(255,255,255,0.1);
        color: white;
        transform: translateX(5px);
    }

    .main-content {
        margin-left: 280px;
        padding: 2rem;
        width: calc(100% - 280px);
        transition: margin-left 0.3s ease, width 0.3s ease;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3748;
    }

    .stat-label {
        color: #718096;
        font-size: 0.875rem;
    }

    .reservations-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table th {
        background: #f8f9fa;
        padding: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
    }

    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
    }

    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin: 0 0.25rem;
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
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        color: white;
    }

    @media (max-width: 768px) {
        .hamburger-menu {
            display: block;
        }

        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
            width: 100%;
            padding: 1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<button class="hamburger-menu" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<?php include 'components/sidebar.php'; ?>

<div class="dashboard-container">
    <main class="main-content">
        <h1 class="mb-4">Welcome to Admin Dashboard</h1>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background: #0061f2;">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo $total_reservations; ?></div>
                <div class="stat-label">Total Reservations</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background: #00ba88;">
                        <i class="fas fa-plane-departure"></i>
                    </div>
                </div>
                <div class="stat-value">120</div>
                <div class="stat-label">Upcoming Flights</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background: #f6ad55;">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="stat-value">35</div>
                <div class="stat-label">Pending Approvals</div>
            </div>
        </div>

        <div class="reservations-table">
            <h2 class="p-4 mb-0">Recent Reservations</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Passenger</th>
                            <th>Destination</th>
                            <th>Class</th>
                            <th>Date</th>
                            <th>Seats</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $reservations_result->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $row['id']; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle me-2"></i>
                                    <?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?>
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-plane-departure me-2"></i>
                                <?php echo htmlspecialchars($row['destination']); ?>
                            </td>
                            <td>
                                <span class="badge bg-primary">
                                    <?php echo htmlspecialchars($row['flight_class']); ?>
                                </span>
                            </td>
                            <td>
                                <i class="fas fa-calendar me-2"></i>
                                <?php echo htmlspecialchars($row['departure_date']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['seats']); ?></td>
                            <td>
                                <a href="admin_edit_reservation.php?id=<?php echo $row['id']; ?>" 
                                   class="btn-action btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete_reservation.php?id=<?php echo $row['id']; ?>" 
                                   class="btn-action btn-delete"
                                   onclick="return confirm('Are you sure you want to delete this reservation?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
}

document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const hamburgerMenu = document.querySelector('.hamburger-menu');
    
    if (window.innerWidth <= 768) {
        if (!sidebar.contains(event.target) && !hamburgerMenu.contains(event.target)) {
            sidebar.classList.remove('active');
        }
    }
});

window.addEventListener('resize', function() {
    const sidebar = document.getElementById('sidebar');
    if (window.innerWidth > 768) {
        sidebar.classList.remove('active');
    }
});
</script>

<?php include 'components/footer.php'; ?>
