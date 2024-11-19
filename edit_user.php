<?php
session_start();
require_once 'config.php';
$pageTitle = "Edit User - Admin Dashboard";

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if (!$user) {
        header("Location: manage_users.php?error=User not found");
        exit();
    }
} else {
    header("Location: manage_users.php?error=Invalid user ID");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $user['password'];

    $update_sql = "UPDATE users SET firstname = ?, lastname = ?, email = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssi", $firstname, $lastname, $email, $password, $user_id);

    if ($stmt->execute()) {
        header("Location: manage_users.php?success=User updated successfully");
        exit();
    } else {
        $error = "Error updating user: " . $conn->error;
    }
}

include 'components/header.php';
include 'components/navbar.php';
?>

<style>
    .edit-user-container {
        background: linear-gradient(135deg, rgba(0,97,242,0.1) 0%, rgba(0,186,136,0.1) 100%);
        min-height: 100vh;
        padding: 3rem 0;
    }

    .edit-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .edit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }

    .edit-header {
        background: linear-gradient(135deg, #0061f2 0%, #00ba88 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .edit-form {
        padding: 2rem;
    }

    .form-floating {
        margin-bottom: 1.5rem;
    }

    .form-control {
        border-radius: 10px;
        padding: 1rem;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #0061f2;
        box-shadow: 0 0 0 0.2rem rgba(0,97,242,0.25);
    }

    .btn-update {
        background: linear-gradient(135deg, #0061f2 0%, #00ba88 100%);
        color: white;
        border: none;
        padding: 1rem;
        border-radius: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,97,242,0.3);
    }

    .btn-back {
        color: #6c757d;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        color: #0061f2;
        text-decoration: none;
    }

    .password-hint {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }
</style>

<div class="edit-user-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="edit-card">
                    <div class="edit-header">
                        <h2 class="mb-0">
                            <i class="fas fa-user-edit me-2"></i>Edit User Information
                        </h2>
                    </div>
                    
                    <div class="edit-form">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form action="" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="firstname" name="firstname" 
                                       value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
                                <label for="firstname">First Name</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="lastname" name="lastname" 
                                       value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                                <label for="lastname">Last Name</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                <label for="email">Email Address</label>
                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="password" name="password">
                                <label for="password">Password</label>
                                <div class="password-hint">Leave blank if you don't want to change the password</div>
                            </div>

                            <div class="d-grid gap-3">
                                <button type="submit" class="btn btn-update">
                                    <i class="fas fa-save me-2"></i>Update User
                                </button>
                                <a href="manage_users.php" class="btn btn-back text-center">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Manage Users
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>
