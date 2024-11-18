<?php
session_start();
require_once 'config.php';


if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    
    $sql_delete = "DELETE FROM users WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);
    
    if ($stmt_delete->execute()) {
        
        header("Location: manage_users.php?success=User deleted successfully");
        exit();
    } else {
        $error = "Error deleting user: " . $conn->error;
    }
}


$sql = "SELECT id, firstname, lastname, email FROM users";
$result = $conn->query($sql);

if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Dashboard</title>
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
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </nav><br>
    <br><h2 style="text-align: center;">Manage Users</h2>
    <div class="container">
        

        <?php if (isset($_GET['success'])) { echo "<p class='success'>" . $_GET['success'] . "</p>"; } ?>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>";
                        echo "<a href='edit_user.php?id=" . $row['id'] . "' class='btn-edit'>Edit</a> ";
                        echo "<a href='manage_users.php?delete_id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this user?');\" class='btn-delete'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <br><br>
        
    </div>
    <a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
</body>
</html>
