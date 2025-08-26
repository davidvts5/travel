<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/db_config.php';
global $conn;
$conn = connectDb();

$role = null;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT role FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $role = $user['role'];
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="browse.php">
            <i class="bi bi-globe-americas"></i> JourneyMate
        </a>

        <!-- Mobile toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="browse.php"><i class="bi bi-search"></i> Browse</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-info-circle"></i> About</a>
                </li>
            </ul>

            <!-- Right side -->
            <ul class="navbar-nav mb-2 mb-lg-0">

                <?php if (isset($_SESSION['user_firstname'])): ?>

                    <?php if ($role == 'admin'): ?>
                        <!-- Admin dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-danger fw-semibold" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-gear"></i> Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item" href="admin_page.php">Dashboard</a></li>
                                <li><a class="dropdown-item" href="destinations.php">Manage Destinations</a></li>
                                <li><a class="dropdown-item" href="manage_agencies.php">Manage Agencies</a></li>
                                <li><a class="dropdown-item" href="manage_users.php">Manage Users</a></li>
                            </ul>
                        </li>

                    <?php elseif ($role == 'agency'): ?>
                        <!-- Agency dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-primary fw-semibold" href="#" id="agencyDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-building"></i> Agency
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="agencyDropdown">
                                <li><a class="dropdown-item" href="agency_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                                <li><a class="dropdown-item" href="add_attraction.php"><i class="bi bi-plus-circle"></i> Add Attraction</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <!-- User dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['user_firstname']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="my_tours.php"><i class="bi bi-map"></i> My Tours</a></li>
                            <li><a class="dropdown-item" href="favorite_pets.php"><i class="bi bi-heart"></i> Favorites</a></li>
                            <li><a class="dropdown-item" href="edit_account.php"><i class="bi bi-pencil"></i> Edit Account</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                        </ul>
                    </li>

                <?php else: ?>
                    <!-- Not logged in -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="guestDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person"></i> Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="guestDropdown">
                            <li><a class="dropdown-item" href="login.php">Sign in</a></li>
                            <li><a class="dropdown-item" href="register.php">Create account</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
