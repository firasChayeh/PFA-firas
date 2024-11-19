<style>
    .navbar {
        box-shadow: 0 2px 4px rgba(0,0,0,.1);
        background: linear-gradient(135deg, #0061f2 0%, #00ba88 100%);
    }

    .navbar-brand {
        font-weight: 600;
        font-size: 1.2rem;
        color: white !important;
    }

    .nav-link {
        font-weight: 500;
        padding: 0.5rem 1rem !important;
        transition: all 0.3s ease;
        color: white !important;
    }

    .nav-link:hover {
        transform: translateY(-2px);
        color: #f0f0f0 !important;
    }

    .navbar-toggler {
        border-color: rgba(255,255,255,0.5);
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.7%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
</style>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <i class="fas fa-plane-departure me-2"></i>
            Aéroport Monastir Habib Bourguiba
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_reservation.php">
                        <i class="fas fa-ticket-alt me-1"></i> Reservation
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt me-1"></i> Log Out
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
