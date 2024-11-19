<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'components/header.php';
include 'components/navbar.php';
?>

<style>
    .success-container {
        background: linear-gradient(135deg, rgba(0,97,242,0.1) 0%, rgba(0,186,136,0.1) 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .success-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        padding: 3rem;
        text-align: center;
        max-width: 600px;
        width: 100%;
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        0% {
            transform: translateY(50px);
            opacity: 0;
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .success-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #0061f2 0%, #00ba88 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(0,97,242,0.4);
        }
        70% {
            transform: scale(1.05);
            box-shadow: 0 0 0 15px rgba(0,97,242,0);
        }
        100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(0,97,242,0);
        }
    }

    .success-icon i {
        color: white;
        font-size: 3rem;
    }

    .success-title {
        color: #2d3748;
        font-size: 2.5rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .success-message {
        color: #718096;
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .btn-dashboard {
        background: linear-gradient(135deg, #0061f2 0%, #00ba88 100%);
        color: white;
        padding: 1rem 2rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .btn-dashboard:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,97,242,0.2);
    }

    .confetti {
        position: fixed;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1000;
    }
</style>

<div class="success-container">
    <div class="success-card">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        <h1 class="success-title">Reservation Successful!</h1>
        <p class="success-message">
            Your flight reservation has been confirmed. We're excited to have you on board!
            <br>
            A confirmation email has been sent to your registered email address.
        </p>
        <a href="dashboard.php" class="btn-dashboard">
            <i class="fas fa-home me-2"></i>Return to Dashboard
        </a>
    </div>
</div>

<script>
    function createConfetti() {
        const confetti = document.createElement('div');
        confetti.className = 'confetti';
        document.body.appendChild(confetti);
        
        for (let i = 0; i < 100; i++) {
            const particle = document.createElement('div');
            particle.style.left = Math.random() * 100 + 'vw';
            particle.style.animationDelay = Math.random() * 2 + 's';
            particle.style.backgroundColor = `hsl(${Math.random() * 360}, 50%, 50%)`;
            confetti.appendChild(particle);
        }
    }

    window.onload = createConfetti;
</script>

<?php include 'components/footer.php'; ?>
