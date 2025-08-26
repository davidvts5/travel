<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
header("Location: browse.php");
exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard | JourneyMate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../components/navbar.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Admin Dashboard</h2>


    <!-- Group 1: Agencies & Users -->
    <div class="row g-4 justify-content-center mb-5">
        <div class="col-md-3 col-sm-6">
            <div class="card text-center shadow-sm rounded-4 hover-shadow p-4">
                <i class="bi bi-building fs-1 text-primary"></i>
                <h5 class="mt-3">Manage Agencies</h5>
                <a href="manage_agencies.php" class="stretched-link"></a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-center shadow-sm rounded-4 hover-shadow p-4">
                <i class="bi bi-people fs-1 text-success"></i>
                <h5 class="mt-3">Manage Users</h5>
                <a href="manage_users.php" class="stretched-link"></a>
            </div>
        </div>
    </div>

    <!-- Group 2:  & Attractions -->
    <div class="row g-4 justify-content-center mb-5">
        <div class="col-md-3 col-sm-6">
            <div class="card text-center shadow-sm rounded-4 hover-shadow p-4">
                <i class="bi bi-house-door fs-1 text-warning"></i>
                <h5 class="mt-3">Manage Destinations</h5>
                <a href="destinations.php" class="stretched-link"></a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-center shadow-sm rounded-4 hover-shadow p-4">
                <i class="bi bi-graph-up fs-1 text-info"></i>
                <h5 class="mt-3">Device logs</h5>
                <a href="logs.php" class="stretched-link"></a>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
