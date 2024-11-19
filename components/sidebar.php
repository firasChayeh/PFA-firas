<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <i class="fas fa-plane"></i>
            Admin Dashboard
        </div>
       
    </div>
    <nav>
        <div class="nav-item">
            <a href="admin_dashboard.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
        </div>
        <div class="nav-item">
            <a href="reservation_list.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'reservation_list.php' ? 'active' : ''; ?>">
                <i class="fas fa-list"></i>
                Reservations
            </a>
        </div>
        <div class="nav-item">
            <a href="manage_users.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage_users.php' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i>
                Users
            </a>
        </div>
        <div class="nav-item">
            <a href="logout.php" class="nav-link">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </div>
    </nav>
</div>
