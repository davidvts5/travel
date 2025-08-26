<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: browse.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Device Logs</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- DataTables + Bootstrap -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
</head>
<body>
<?php include '../components/navbar.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Device Logs</h2>
    <table id="logsTable" class="table table-striped table-bordered display" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>IP</th>
            <th>Device Type</th>
            <th>OS</th>
            <th>Browser</th>
            <th>User Agent</th>
            <th>Country</th>
            <th>Region</th>
            <th>City</th>
            <th>ISP</th>
            <th>Created At</th>
        </tr>
        </thead>
    </table>
</div>

<!-- jQuery + Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<!-- Custom JS -->
<script src="../datatables/js/manage_logs.js"></script>
</body>
</html>
