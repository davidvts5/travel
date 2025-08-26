<?php
session_start();

// Provera da li je user ulogovan i da li je agencija
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'agency') {
    header("Location: ../browse.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agency Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php include '../components/navbar.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Agency Dashboard</h2>

    <div class="row">
        <!-- Manage Attractions -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <i class="bi bi-building fs-1 text-primary"></i>
                    <h5 class="card-title mt-3">Manage Attractions</h5>
                    <p class="card-text">Add, edit or delete attractions for your agency.</p>
                    <a href="my_attractions.php" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <i class="bi bi-bar-chart-line fs-1 text-success"></i>
                    <h5 class="card-title mt-3">Statistics</h5>
                    <p class="card-text">View popularity and performance of your attractions.</p>
                    <a href="stats.php" class="btn btn-success">Go</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
