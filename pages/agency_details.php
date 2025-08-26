<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: browse.php");
    exit;
}
$agencyId = $_GET['id'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agency Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php include '../components/navbar.php'; ?>

<div class="container mt-5">
    <h2>Agency Details</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title" id="agencyName">Agency Name</h4>
            <p class="card-text"><strong>Email:</strong> <span id="agencyEmail"></span></p>
            <p class="card-text"><strong>Status:</strong> <span id="agencyStatus"></span></p>
            <button id="banAgencyBtn" class="btn"></button>
            <button id="toggleAttractionsBtn" class="btn"></button>
        </div>
    </div>

    <h4>Attractions</h4>
    <table id="agencyAttractionsTable" class="table table-striped table-bordered display" style="width:100%">
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        const agencyId = <?= json_encode($agencyId) ?>;

        // Učitaj podatke o agenciji
        $.getJSON('../datatables/ajax/getAgency.php', { agency_id: agencyId }, function(res) {
            if (!res.success) { alert(res.error); return; }

            $('#agencyName').text(res.data.firstname + ' ' + res.data.lastname);
            $('#agencyEmail').text(res.data.email);
            $('#agencyStatus').text(res.data.banned ? 'Banned' : 'Active');

            updateBanBtn(res.data.banned);
            updateAttractionsBtn(res.data.attractions_enabled);
        });

        function updateBanBtn(isBanned){
            if(isBanned){
                $('#banAgencyBtn').removeClass().addClass('btn btn-success')
                    .html('<i class="bi bi-check-circle"></i> Unban Agency');
            } else {
                $('#banAgencyBtn').removeClass().addClass('btn btn-danger')
                    .html('<i class="bi bi-slash-circle"></i> Ban Agency');
            }
        }

        function updateAttractionsBtn(enabled){
            if(enabled){
                $('#toggleAttractionsBtn').removeClass().addClass('btn btn-warning')
                    .html('<i class="bi bi-eye-slash"></i> Disable All Attractions');
            } else {
                $('#toggleAttractionsBtn').removeClass().addClass('btn btn-success')
                    .html('<i class="bi bi-eye"></i> Enable All Attractions');
            }
        }

        // DataTable
        const table = $('#agencyAttractionsTable').DataTable({
            ajax: {
                url: '../datatables/ajax/getAgencyAttractions.php',
                type: 'GET',
                data: { agency_id: agencyId },
                dataSrc: function (json) {
                    return json.data;
                }
            },
            columns: [
                { data: "attraction_id", render: (data, type, row, meta) => meta.row + 1 },
                { data: "name" },
                { data: "description" },
                {
                    data: null,
                    orderable: false,
                    render: function(row) {
                        let isActive = Number(row.is_active);

                        let actionBtn = isActive === 1
                            ? `<button class="btn btn-sm btn-danger action-btn" data-id="${row.attraction_id}">Deactivate</button>`
                            : `<button class="btn btn-sm btn-success action-btn" data-id="${row.attraction_id}">Activate</button>`;

                        return actionBtn;
                    }
                }
            ]
        });

        // Toggle ALL attractions
        $('#toggleAttractionsBtn').click(function(){
            $.post('../datatables/ajax/toggleAttractions.php', { agency_id: agencyId }, function(res){
                if (!res.success){ alert(res.error); return; }

                updateAttractionsBtn(res.status==='enabled');
                table.ajax.reload();
            }, 'json');
        });

        // Ban/Unban
        $('#banAgencyBtn').click(function(){
            let action = ($('#agencyStatus').text()==='Active')?'ban':'unban';
            $.post('../datatables/ajax/banUser.php', { user_id: agencyId, action: action }, function(res){
                if (!res.success){ alert(res.error); return; }

                if(action==='ban'){
                    $('#agencyStatus').text('Banned');
                    updateBanBtn(true);
                } else {
                    $('#agencyStatus').text('Active');
                    updateBanBtn(false);
                }
            }, 'json');
        });

        // Toggle attraction (soft delete/activate)
        $('#agencyAttractionsTable tbody').on('click','.action-btn', function(){
            const id = $(this).data('id');

            $.post('../datatables/ajax/toggleAttraction.php', { attraction_id: id }, function(res){
                if(res.success) {
                    table.ajax.reload(null, false); // refresh bez vraćanja na prvu stranicu
                } else {
                    alert(res.error);
                }
            }, 'json');
        });

    });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
