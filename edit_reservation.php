<?php
session_start();
require_once 'config.php';
$pageTitle = "Edit Reservation";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $flight_class = $conn->real_escape_string($_POST['flight_class']);
    $destination = $conn->real_escape_string($_POST['destination']);
    $seats = $conn->real_escape_string($_POST['seats']);

    $sql = "UPDATE reservations SET 
            flight_class = '$flight_class', 
            destination = '$destination', 
            seats = '$seats' 
            WHERE id = $id AND user_id = $user_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Error updating record: " . $conn->error;
    }
} else {
    $sql = "SELECT * FROM reservations WHERE id = $id AND user_id = $user_id";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $reservation = $result->fetch_assoc();
    } else {
        header("Location: dashboard.php"); 
        exit();
    }
}

include 'components/header.php';
include 'components/navbar.php';
?>

<style>
    .edit-form-container {
        background: linear-gradient(135deg, rgba(0,97,242,0.1) 0%, rgba(0,186,136,0.1) 100%);
        padding: 2rem 0;
        min-height: calc(100vh - 76px);
    }

    .edit-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .edit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }

    .edit-card-header {
        background: linear-gradient(135deg, #0061f2 0%, #00ba88 100%);
        color: white;
        padding: 1.5rem;
        text-align: center;
    }

    .edit-form {
        padding: 2rem;
    }

    .form-control {
        border-radius: 10px;
        padding: 0.8rem;
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
        padding: 1rem 2rem;
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
        color: #dc3545;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        color: #c82333;
        text-decoration: none;
    }
</style>

<div class="edit-form-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="edit-card">
                    <div class="edit-card-header">
                        <h2 class="mb-0"><i class="fas fa-edit me-2"></i>Update Your Reservation</h2>
                    </div>
                    <div class="edit-form">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form action="" method="POST">
                            <div class="mb-4">
                                <label for="flight_class" class="form-label">Flight Class:</label>
                                <select class="form-control" id="flight_class" name="flight_class" required>
                                    <option value="Economy" <?php echo $reservation['flight_class'] == 'Economy' ? 'selected' : ''; ?>>Economy</option>
                                    <option value="Business" <?php echo $reservation['flight_class'] == 'Business' ? 'selected' : ''; ?>>Business</option>
                                    <option value="First Class" <?php echo $reservation['flight_class'] == 'First Class' ? 'selected' : ''; ?>>First Class</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="destination" class="form-label">Destination:</label>
                                <input type="text" class="form-control" id="destination" name="destination" value="<?php echo htmlspecialchars($reservation['destination']); ?>" required>
                            </div>

                            <div class="mb-4">
                                <label for="seats" class="form-label">Number of Seats:</label>
                                <input type="number" class="form-control" id="seats" name="seats" value="<?php echo htmlspecialchars($reservation['seats']); ?>" required>
                            </div>

                            <div class="d-grid gap-3">
                                <button type="submit" class="btn btn-update">
                                    <i class="fas fa-save me-2"></i>Update Reservation
                                </button>
                                <a href="dashboard.php" class="btn btn-back text-center">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
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
