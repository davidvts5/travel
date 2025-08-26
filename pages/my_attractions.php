<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'agency') {
    header("Location: ../browse.php");
    exit;
}

$agencyId = $_SESSION['user_id']; // id agencije iz sesije
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Attractions</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php include '../components/navbar.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <h2>My Attractions</h2>
        <a href="add_attraction.php" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add Attraction
        </a>
    </div>

    <table id="myAttractionsTable" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Description</th>
            <th>Address</th>
            <th>Budget</th>
            <th>City</th>
            <th>Country</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function(){
        const agencyId = <?= json_encode($agencyId) ?>;
        const table = $('#myAttractionsTable').DataTable({
            ajax: {
                url: '../datatables/ajax/getMyAttractions.php',
                data: { agency_id: agencyId },
                dataSrc: 'data'
            },
            columns: [
                { data: "attraction_id", render: (d,t,r,m) => m.row+1 },
                { data: "name" },
                { data: "description" },
                { data: "address" },
                { data: "budget" },
                { data: "city_name" },
                { data: "country_name" },
                { data: "is_active", render: d => d==1 ? "Active" : "Inactive" },
                {
                    data: null,
                    render: row => `
                        <button class="btn btn-sm btn-primary edit-btn" data-id="${row.attraction_id}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${row.attraction_id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `
                }
            ]
        });

        // Delete
        $('#myAttractionsTable').on('click', '.delete-btn', function(){
            if(!confirm("Are you sure you want to delete this attraction?")) return;
            const id = $(this).data('id');

            $.post('../datatables/ajax/deleteAttraction.php', { id }, function(res){
                if(res.success){
                    table.ajax.reload();
                } else {
                    alert(res.error);
                }
            }, 'json');
        });

        // Edit (ako želiš da vodi na posebnu edit stranicu)
        $('#myAttractionsTable').on('click', '.edit-btn', function(){
            const id = $(this).data('id');
            window.location.href = "edit_attraction.php?id=" + id;
        });
    });
</script>
</body>
</html>
