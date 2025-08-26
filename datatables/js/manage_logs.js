$(document).ready(function () {
    $('#logsTable').DataTable({
        ajax: {
            url: '../datatables/ajax/getLogs.php',
            type: 'GET',
            dataSrc: 'data'
        },
        order: [[0, 'desc']], // sort po ID
        columns: [
            { data: "id" },
            { data: "ip" },
            { data: "device_type" },
            { data: "os" },
            { data: "browser" },
            { data: "user_agent" },
            { data: "country" },
            { data: "region" },
            { data: "city" },
            { data: "isp" },
            { data: "created_at" }
        ],
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copy', className: 'btn btn-secondary' },
            { extend: 'csv', className: 'btn btn-success' },
            { extend: 'excel', className: 'btn btn-success' },
            { extend: 'pdf', className: 'btn btn-danger' },
            { extend: 'print', className: 'btn btn-info' }
        ]
    });
});
