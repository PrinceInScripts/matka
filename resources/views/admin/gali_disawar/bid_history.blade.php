<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | DataTables</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- font awesome  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/Z1srTF+W+o8+T2Vq+0+z7N0zJwQXG6nTpGO5c5XbYl5fX5Yx5D5V5y5d5D5D5D5D5D5A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .bid-history-card {
            border-radius: 14px;
        }

        .bid-history-card .card-body {
            padding: 24px;
        }

        .bid-history-card .form-label {
            font-weight: 500;
            margin-bottom: 6px;
        }

        .bid-history-card .form-control,
        .bid-history-card .form-select {
            height: 44px;
        }

        .bid-history-card .btn {
            height: 44px;
        }

           .select2-container--bootstrap4 .select2-selection--single {
    height: calc(2.25rem + 2px);
    line-height: 1.5;
    padding: .375rem .75rem;
    border: 1px solid #000;
}

.select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
    height: 100%;
    position: absolute;
    top: 0;
    right: 0.75rem;
    width: 20px;
}

.select2-container--bootstrap4 .select2-selection__arrow b {
    border-color: #495057 transparent transparent transparent;
    border-style: solid;
    border-width: 5px 4px 0 4px;
    height: 0;
    left: 50%;
    margin-left: -4px;
    margin-top: -2px;
    position: absolute;
    top: 50%;
    width: 0;
}
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <x-admin-navbar />
        <!-- /.navbar -->

        <x-admin-sidebar />

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>User Bid </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">User Bid</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- ================= BID HISTORY REPORT ================= -->
                    <div class="row g-3 mt-3">

                        <div class="col-12">
                            <div class="card border-0 shadow-sm bid-history-card">
                                <div class="card-body">

                                    <h6 class="fw-bold mb-3">Bid History Report</h6>

                                    <div class="row align-items-end g-3">


                                        <!-- Date -->
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <label class="form-label">Date</label>
                                            <input type="date" id="filter_date" class="form-control"
                                                value="{{ date('Y-m-d') }}">
                                        </div>

                                        <!-- Game Name -->
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <label class="form-label">Game Name</label>
                                            <select id="filter_game" class="form-control select2">
                                                <option value="">Select Game</option>
                                                @foreach ($games as $game)
                                                    <option value="{{ $game->id }}">
                                                        {{ $game->name }}
                                                        @if ($game->todaySchedule && $game->todaySchedule->open_time && $game->todaySchedule->close_time)
                                                            ({{ \Carbon\Carbon::parse($game->todaySchedule->open_time)->format('h:i A') }}
                                                            -
                                                            {{ \Carbon\Carbon::parse($game->todaySchedule->close_time)->format('h:i A') }})
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Game Type -->
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <label class="form-label">Game Type</label>
                                            <select id="filter_game_type" class="form-control select2">
                                                <option value="">Select Game</option>
                                                @foreach ($gameType as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-lg-2 col-md-6 col-12">
                                            <button id="filterBtn" class="btn btn-primary w-100">
                                                Submit
                                            </button>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">


                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">User List</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="bidTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User</th>
                                                <th>Game</th>
                                                <th>Type</th>
                                                <th>Session</th>
                                                <th>Digits</th>
                                                <th>Points</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bidTableBody">
                                            <!-- rows injected here -->
                                        </tbody>
                                    </table>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../plugins/jszip/jszip.min.js"></script>
    <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    {{-- font awesome script --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- ajax --}}




<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function () {

    $('.select2').select2({
    theme: 'bootstrap4',
    width: '100%',
    placeholder: 'Select option',
    allowClear: false,
    minimumResultsForSearch: 0
});


});

$(document).on('shown.bs.modal', function () {
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%',
        dropdownParent: $('.modal:visible')
    });
});

</script>




    <script>
        $(function() {
            $("#bidTable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#bidTable_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

   <script>
$(document).ready(function () {

    $('#filterBtn').on('click', function () {

        let date = $('#filter_date').val();
        let game = $('#filter_game').val();
        let type = $('#filter_game_type').val();

        $.ajax({
            url: "{{ route('admin.starline.bid_history.filter') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                date: date,
                game_id: game,
                game_type_id: type
            },
            beforeSend: function () {
                Swal.fire({
                    title: 'Loading...',
                    text: 'Fetching bid history',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function (res) {
                Swal.close();

                const tbody = $('#bidTableBody');
                tbody.empty();

                if (!res.status || res.data.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                No data found
                            </td>
                        </tr>
                    `);

                    Swal.fire({
                        icon: 'info',
                        title: 'No Records',
                        text: 'No bid history found'
                    });
                    return;
                }

                res.data.forEach((item, index) => {
                    tbody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.user?.name ?? 'N/A'}</td>
                            <td>${item.market?.name ?? 'N/A'}</td>
                            <td>${item.game_type?.name ?? 'N/A'}</td>
                            <td>${item.session ?? '-'}</td>
                            <td>${item.number ?? '-'}</td>
                            <td>₹ ${parseFloat(item.amount).toFixed(2)}</td>
                            <td>${new Date(item.created_at).toLocaleString()}</td>
                        </tr>
                    `);
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Done',
                    text: res.data.length + ' records found'
                });
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong'
                });
            }
        });
    });

});
</script>


</body>

</html>
