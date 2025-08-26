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
    <title>Manage Agencies</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php include '../components/navbar.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Manage Agencies</h2>

    <!-- Dugme za kreiranje nove agencije -->
    <button id="createAgencyBtn" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Create New Agency
    </button>

    <!-- Tabela agencija -->
    <table id="agenciesTable" class="table table-striped table-bordered display" style="width:100%">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="createAgencyModal" tabindex="-1" aria-labelledby="createAgencyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="createAgencyForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAgencyModalLabel">Create New Agency</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="agencyName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="agencyName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="agencyEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="agencyEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="agencyPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="agencyPassword" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Create Agency</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        // Inicijalizacija DataTable i čuvanje u varijabli
        const table = $('#agenciesTable').DataTable({
            ajax: {
                url: '../datatables/ajax/getAgencies.php',
                type: 'GET',
                dataSrc: 'data'
            },
            columns: [
                { title: "Id", data: "user_id" },
                { title: "Name", data: "firstname" },
                { title: "Email", data: "email" },
                { title: "Actions", data: null, orderable: false, render: function (data, type, row) {
                        return `<a href="agency_details.php?id=${row.user_id}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>`;
                    }}
            ]
        });

        // Delete dugme
        $('#agenciesTable').on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            if(confirm('Are you sure you want to delete this agency?')) {
                $.post('../datatables/ajax/deleteAgency.php', { agency_id: id }, function(res) {
                    table.ajax.reload(); // reload tabele nakon brisanja
                });
            }
        });
    });

    $(document).ready(function() {
        // Otvori modal
        $('#createAgencyBtn').click(function() {
            $('#createAgencyModal').modal('show');
        });

        // Submit form
        $('#createAgencyForm').submit(function(e) {
            e.preventDefault();
            const formData = {
                name: $('#agencyName').val(),
                email: $('#agencyEmail').val(),
                password: $('#agencyPassword').val()
            };

            $.ajax({
                url: '../datatables/ajax/createAgency.php',
                type: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                success: function(res) {
                    if(res.success) {
                        alert('Agency created successfully!');
                        $('#createAgencyModal').modal('hide');
                        $('#agenciesTable').DataTable().ajax.reload();
                        $('#createAgencyForm')[0].reset();
                    } else {
                        alert('Error: ' + res.message);
                    }
                }
            });
        });
    });

</script>
</body>
</html>
