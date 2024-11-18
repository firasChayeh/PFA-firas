<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT COUNT(id) AS total_reservations FROM reservations";
$result = $conn->query($sql);
$total_reservations = $result->fetch_assoc()['total_reservations'];

$sql = "SELECT r.id, r.destination, r.departure_date, r.departure_time, r.seats, r.flight_class, u.firstname, u.lastname 
        FROM reservations r 
        JOIN users u ON r.user_id = u.id 
        ORDER BY r.departure_date DESC";

$reservations_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="home.css">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #007BFF;
            color: white;
            padding: 15px;
        }
        .navbar .logo a {
            color: white;
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
        }
        .nav-links {
            list-style-type: none;
            float: right;
        }
        .nav-links li {
            display: inline;
            margin-right: 15px;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }
        .container {
            width: 90%;
            margin: 0 auto;
            padding-top: 20px;
        }
        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .stat-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 30%;
        }
        .stat-card h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .stat-card p {
            font-size: 24px;
            font-weight: bold;
            color: #007BFF;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            margin-bottom: 30px;
        }
        table th, table td {
            padding: 15px;
            border: 1px solid #ccc;
            text-align: left;
        }
        table th {
            background-color: #007BFF;
            color: white;
        }
        table td {
            color: #333;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions .btn {
            padding: 8px 12px;
            text-decoration: none;
            color: white;
            border-radius: 4px;
        }
        .btn-edit {
            background-color: #28a745;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .admin-sidebar {
            background-color: transparent;
            color: white;
            padding: 20px;
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            backdrop-filter: blur(20px);
        }
        .admin-sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .admin-sidebar ul li {
            margin-bottom: 20px;
        }
        .admin-sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }
        .admin-sidebar ul li a i {
            margin-right: 10px;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="admin-sidebar">
        <h2>Admin Panel</h2><br>
        <ul>
            <li><a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="reservation_list.php"><i class="fas fa-list"></i> Manage Reservations</a></li>
            <li><a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
        </ul>
    </div>

    <div class="content">
        <h1>Welcome to the Admin Dashboard</h1>
        <p>Manage the reservations and users efficiently.</p>

        <div class="stats">
            <div class="stat-card">
                <h3>Total Reservations</h3>
                <p><?php echo $total_reservations; ?></p>
            </div>
            <div class="stat-card">
                <h3>Upcoming Flights</h3>
                <p>120</p> 
            </div>
            <div class="stat-card">
                <h3>Pending Approvals</h3>
                <p>35</p> 
            </div>
        </div>

        <h2>Recent Reservations</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Passenger</th>
                    <th>Destination</th>
                    <th>Flight Class</th>
                    <th>Departure Date</th>
                    <th>Number of Seats</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $reservations_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                    <td><?php echo $row['destination']; ?></td>
                    <td><?php echo $row['flight_class']; ?></td>
                    <td><?php echo $row['departure_date']; ?></td>
                    <td><?php echo $row['seats'];?></td>
                    <td class="actions">
                        <a href="admin_edit_reservation.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                        <a href="delete_reservation.php?id=<?php echo $row['id']; ?>" class="btn btn-delete">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
