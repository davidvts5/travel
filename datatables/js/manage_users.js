$(document).ready(function () {
    const table = $('#usersTable').DataTable({
        ajax: {
            url: '../datatables/ajax/getUsers.php',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { title: "Id" },
            { title: "Firstname" },
            { title: "Lastname" },
            { title: "Email" },
            { title: "Role" },
            {
                title: "Action",
                orderable: false,
                render: function(data, type, row) {
                    if(row[5] === 'banned'){
                        return `<button class="btn btn-success unban-btn" data-id="${row[0]}">Unban</button>`;
                    } else {
                        return `<button class="btn btn-danger ban-btn" data-id="${row[0]}">Ban</button>`;
                    }
                }
            }
        ],
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: { columns: [0, 1, 2, 3, 4] },
                text: '<i class="bi bi-clipboard"></i> Copy',
                className: 'btn btn-primary'
            },
            {
                extend: 'excelHtml5',
                exportOptions: { columns: ':visible' },
                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                className: 'btn btn-success'
            },
            {
                extend: 'pdfHtml5',
                exportOptions: { columns: [0, 1, 2, 3, 4], orientation: 'landscape', pageSize: 'LEGAL' },
                text: '<i class="bi bi-file-pdf"></i> PDF',
                className: 'btn btn-danger'
            }
        ]
    });

    // Ban dugme
    $('#usersTable').on('click', '.ban-btn', function() {
        const userId = $(this).data('id');
        $.post('../datatables/ajax/banUser.php', { user_id: userId, action: 'ban' }, function() {
            table.ajax.reload(null, false);
        });
    });

    // Unban dugme
    $('#usersTable').on('click', '.unban-btn', function() {
        const userId = $(this).data('id');
        $.post('../datatables/ajax/banUser.php', { user_id: userId, action: 'unban' }, function() {
            table.ajax.reload(null, false);
        });
    });
});
