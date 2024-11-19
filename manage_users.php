<?php
session_start();
require_once 'config.php';
$pageTitle = "Manage Users - Admin Dashboard";

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

include 'components/header.php';
include 'components/navbar.php';
?>

<style>
    .manage-users-container {
        background: linear-gradient(135deg, rgba(0,97,242,0.1) 0%, rgba(0,186,136,0.1) 100%);
        min-height: 100vh;
        padding: 3rem 0;
    }

    .users-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .users-header {
        background: linear-gradient(135deg, #0061f2 0%, #00ba88 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .table-responsive {
        padding: 1.5rem;
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table th {
        background: #f8f9fa;
        padding: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
    }

    .custom-table td {
        padding: 1rem;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
    }

    .custom-table tr:hover {
        background-color: #f8f9fa;
    }

    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-edit {
        background: #0061f2;
        color: white;
        margin-right: 0.5rem;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn-edit:hover, .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .alert {
        margin-bottom: 1.5rem;
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>

<div class="manage-users-container">
    <div class="container">
        <div class="users-card">
            <div class="users-header">
                <h2 class="mb-0">
                    <i class="fas fa-users me-2"></i>Manage Users
                </h2>
            </div>

            <div class="table-responsive">
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i><?php echo $_GET['success']; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td>
                                        <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn-action btn-edit">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <a href="manage_users.php?delete_id=<?php echo $row['id']; ?>" 
                                           onclick="return confirm('Are you sure you want to delete this user?');" 
                                           class="btn-action btn-delete">
                                            <i class="fas fa-trash-alt me-1"></i>Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No users found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="text-center mt-4">
                    <a href="admin_dashboard.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>
