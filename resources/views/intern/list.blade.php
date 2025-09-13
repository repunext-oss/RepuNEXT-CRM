<!DOCTYPE html>
<html lang="en">
<head>
    <title>Repunext - Intern List</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f6f9;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            border: none;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .flatpickr-input {
            background-color: white !important;
        }
        .dataTables_wrapper .dataTables_filter {
            display: none;
        }
        th, td {
            vertical-align: middle;
        }
        @media (max-width: 768px) {
            .card-header .form-control,
            .card-header .input-group {
                width: 100% !important;
            }
            .card-header .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="card">
        <div class="card-header bg-white">
            <h3 class="text-center mb-4">Intern List</h3>
            <div class="row gy-2 gx-2 align-items-center">
                <div class="col-md-3 col-sm-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchBox" class="form-control border-start-0" placeholder="Search...">
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <input type="text" id="minDate" class="form-control" placeholder="From Date">
                </div>
                <div class="col-md-2 col-sm-6">
                    <input type="text" id="maxDate" class="form-control" placeholder="To Date">
                </div>
                <div class="col-md-3 col-sm-6" id="exportButtons"></div>
                <div class="col-md-2 col-sm-12">
                    <a href="{{ route('add.intern') }}" class="btn btn-primary w-100 d-flex justify-content-center align-items-center">
                        <i class="fa fa-plus me-1"></i> Add
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="internTable" class="table table-bordered table-hover nowrap w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name<br>Mobile<br>Slot</th>
                            <th>StartDate/Enddate</th>
                            <th>Course/<br>Type</th>
                            <th>Letter/<br>certificate/<br>Doc</th>
                            <th>City/<br>Area</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interns as $intern)
                        <tr>
                            <td>{{ $intern->id }}</td>
                            <td>{{ $intern->Name }}/<br>{{ $intern->Mobile }}/<br>{{ $intern -> Slot}}</td>
                            <td>{{ $intern->Startdate}}/{{$intern -> Enddate}}</td>
                            <td>{{ $intern->Course }}/<br>{{ $intern->Type }}</td>
                            <td>{{ $intern->Letter }}/<br>{{ $intern->Certificate }}/<br>{{ $intern->Documentation }}</td>
                            <td>{{ $intern->City }}/{{ $intern->Area }}</td>
                            <td>{{ $intern->Amount }}</td>
                            <td>
                                @if($intern->amt == 'paid')
                                    <span class="badge badge-success">Paid</span>
                                @else
                                    <span class="badge badge-danger">Not Paid</span>
                                @endif
                            </td>
                            <td class="text-nowrap">
                                <a href="{{ route('edit.intern', $intern->id) }}" class="btn btn-warning btn-sm me-1" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{ route('view.intern', $intern->id) }}" class="btn btn-info btn-sm me-1" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="deleteConfirmation({{ $intern->id }})" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3 text-end pe-2">
                <h5>Total Amount: ₹<span id="totalAmount">0</span></h5>
                <h6 class="text-success">Paid: ₹<span id="paidAmount">0</span></h6>
                <h6 class="text-danger">Not Paid: ₹<span id="notPaidAmount">0</span></h6>
            </div>

        </div>
    </div>
</div>

<!-- JS Scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    var table = $('#internTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'collection',
                text: 'Export',
                className: 'btn btn-outline-primary',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            }
        ],
        responsive: true
    });

    table.buttons().container().appendTo('#exportButtons');

    $('#searchBox').on('keyup', function() {
        table.search(this.value).draw();
        calculateTotalAmount();
    });

    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var min = $('#minDate').val();
            var max = $('#maxDate').val();
            var dateRange = data[2];
            if (!dateRange) return false;
            var startDateStr = dateRange.split('/')[0].trim();
            var parsedDate = new Date(startDateStr);
            if (parsedDate.toString() === "Invalid Date") return false;
            return (
                (min === '' || new Date(min) <= parsedDate) &&
                (max === '' || new Date(max) >= parsedDate)
            );
        }
    );

    $('#minDate, #maxDate').on('change', function () {
        table.draw();
        calculateTotalAmount();
    });

    table.on('draw', function () {
        calculateTotalAmount();
    });

    flatpickr("#minDate", { dateFormat: "Y-m-d" });
    flatpickr("#maxDate", { dateFormat: "Y-m-d" });

    // Calculate total on page load
    calculateTotalAmount();
});

// Total Amount Calculation from All Data (Not Just Current Page)
function calculateTotalAmount() {
    let total = 0;
    let paidTotal = 0;
    let notPaidTotal = 0;

    const table = $('#internTable').DataTable();
    const data = table.rows({ search: 'applied' }).data();

    data.each(function (row) {
        const amountText = row[6]; // Amount column
        const statusCell = row[7]; // Status column (has HTML span)
        const amount = parseFloat(amountText.replace(/[^0-9.]/g, ''));

        if (!isNaN(amount)) {
            total += amount;

            if (statusCell.includes('badge-success')) {
                paidTotal += amount;
            } else if (statusCell.includes('badge-danger')) {
                notPaidTotal += amount;
            }
        }
    });

    $('#totalAmount').text(total.toFixed(2));
    $('#paidAmount').text(paidTotal.toFixed(2));
    $('#notPaidAmount').text(notPaidTotal.toFixed(2));
}

function deleteConfirmation(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This record will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            let token = "{{ csrf_token() }}";
            let url = `/intern/destroy/${id}`;
            $.ajax({
                type: 'POST',
                url: url,
                data: { _token: token },
                success: function() {
                    Swal.fire('Deleted!', 'Record has been deleted.', 'success');
                    setTimeout(() => { location.reload(); }, 1000);
                },
                error: function() {
                    Swal.fire('Error!', 'Failed to delete. Please try again.', 'error');
                }
            });
        }
    });
}
</script>
</body>
</html>
