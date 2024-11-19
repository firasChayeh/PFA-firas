<?php
session_start();
include 'config.php';
$pageTitle = "Book Ticket";

include 'components/header.php';
include 'components/navbar.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Ticket Booking Status</h3>
                    
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['ticket_id'])) {
                            $ticket_id = $_POST['ticket_id'];

                            $update_query = "UPDATE tickets SET is_booked = 1, user_id = ? WHERE id = ?";
                            $stmt = $conn->prepare($update_query);
                            $stmt->bind_param('ii', $_SESSION['user_id'], $ticket_id);
                            
                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success text-center">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Ticket booked successfully!
                                    </div>';
                            } else {
                                echo '<div class="alert alert-danger text-center">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        Error booking ticket: ' . $stmt->error . '
                                    </div>';
                            }
                            $stmt->close();
                        } else {
                            echo '<div class="alert alert-warning text-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    No ticket ID provided.
                                </div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger text-center">
                                <i class="fas fa-times-circle me-2"></i>
                                Invalid request method.
                            </div>';
                    }

                    $conn->close();
                    ?>

                    <div class="text-center mt-4">
                        <a href="dashboard.php" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Return to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>
