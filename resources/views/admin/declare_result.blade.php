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
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- font awesome  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/Z1srTF+W+o8+T2Vq+0+z7N0zJwQXG6nTpGO5c5XbYl5fX5Yx5D5V5y5d5D5D5D5D5D5A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                            <h1>Declare Result </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Declare Result</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Select Game</h3>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Result Date</label>
                                            <input type="date" id="result_date" class="form-control"
                                                value="{{ date('Y-m-d') }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label>Game Name</label>
                                            <select id="game_id" class="form-control">
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

                                        <div class="col-md-3">
                                            <label>Session</label>
                                            <select id="session" class="form-control">
                                                <option value="">Select Session</option>
                                                <option value="open">Open</option>
                                                <option value="close">Close</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-end">
                                            <button id="goBtn" class="btn btn-primary w-100">Go</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card mt-3 d-none" id="declareSection">
                                <div class="card-header">
                                    <h3 class="card-title">Declare Result</h3>
                                    <span class="badge badge-info ml-2" id="resultStatus"></span>
                                </div>

                                <div class="card-body">
                                    {{-- OPEN --}}
                                    <div class="row mb-3" id="openBlock">
                                        <div class="col-md-4">
                                            <label>Open Panna</label>
                                            <select id="open_panna" class="form-control">
                                                <option value="">Select Panna</option>
                                                @foreach ($pannas as $p)
                                                    <option value="{{ $p }}">{{ $p }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Open Digit</label>
                                            <input type="number" id="open_digit" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="row mb-3" id="closeBlock">
                                        <div class="col-md-4">
                                            <label>Close Panna</label>
                                            <select id="close_panna" class="form-control">
                                                <option value="">Select Panna</option>
                                                @foreach ($pannas as $p)
                                                    <option value="{{ $p }}">{{ $p }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Close Digit</label>
                                            <input type="number" id="close_digit" class="form-control" readonly>
                                        </div>
                                    </div>


                                    {{-- ACTION BUTTONS --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-success" id="saveDraft">Save</button>
                                            <button class="btn btn-warning" id="showWinner">Show Winner</button>
                                            <button class="btn btn-danger" id="declareResult">Declare</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="modal fade" id="winnerModal">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Winner List</h5>
                                            <button type="button" class="close"
                                                data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <p>
                                                <b>Total Bid:</b> <span id="totalBid">0</span> |
                                                <b>Total Win:</b> <span id="totalWin">0</span>
                                            </p>

                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>User</th>
                                                        <th>Amount</th>
                                                        <th>Winning</th>
                                                        <th>Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="winnerTable">
                                                    <tr>
                                                        <td colspan="5" class="text-center">No Data</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <div class="card mt-4">
                                <div class="card-header">
                                    <h3 class="card-title">Game Result History</h3>
                                </div>

                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Game</th>
                                                <th>Date</th>
                                                <th>Open</th>
                                                <th>Close</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($results as $i => $r)
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td>{{ $r->market->name }}</td>
                                                    <td>{{ $r->result_date }}</td>
                                                    <td>{{ $r->open_panna }}-{{ $r->open_digit }}</td>
                                                    <td>{{ $r->close_panna }}-{{ $r->close_digit }}</td>
                                                    <td>
                                                        @if ($r->status === 'draft')
                                                            <button class="btn btn-danger btn-sm deleteResult"
                                                                data-id="{{ $r->id }}">Delete</button>
                                                        @else
                                                            <span class="badge badge-success">Declared</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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


    {{-- ajax --}}



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>


    <script>
        let resultId = null;

        $('#goBtn').on('click', function() {

            // if (!$('#game_id').val() || !$('#session').val()) {
            //     Swal.fire('Missing Data', 'Please select game and session', 'warning');
            //     return;
            // }
            // make sure open panna & digit are cleared
            $('#open_panna').val('').trigger('change');
            $('#close_panna').val('').trigger('change');
            $('#open_digit').val('');
            $('#close_digit').val('');
            $('#resultStatus').text('');
            resultId = null;


            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: '/admin/result/context',
                type: 'POST',
                data: {
                    game_id: $('#game_id').val(),
                    session: $('#session').val(),
                    result_date: $('#result_date').val()
                },
                success: function(res) {
                    Swal.close();
                    $('#declareSection').removeClass('d-none');


                    if (res) {
                        resultId = res.id;

                        $('#open_panna').val(res.open_panna).trigger('change');
                        $('#close_panna').val(res.close_panna).trigger('change');

                        $('#resultStatus').text(res.status.toUpperCase());
                    } else {
                        $('#resultStatus').text('NEW');
                    }

                    // 👇 THIS LINE IS CRITICAL
                    handleSessionUI($('#session').val());

                },
                error: function() {
                    Swal.fire('Error', 'Failed to load game context', 'error');
                }
            });
        });

        function calculateDigit(panna) {
            if (!panna) return '';
            let sum = panna.toString().split('').reduce((a, b) => a + parseInt(b), 0);
            return sum % 10;
        }

        $('#open_panna').on('change', function() {
            let panna = $(this).val();
            $('#open_digit').val(calculateDigit(panna));
        });

        $('#close_panna').on('change', function() {
            let panna = $(this).val();
            $('#close_digit').val(calculateDigit(panna));
        });

        $('#session').on('change', function() {
            let session = $(this).val();
            handleSessionUI(session);
        });

        // on gamename change clear all fields
        $('#game_id').on('change', function() {
            $('#declareSection').addClass('d-none');
            $('#open_panna').val('').trigger('change');
            $('#close_panna').val('').trigger('change');
            $('#open_digit').val('');
            $('#close_digit').val('');
            $('#resultStatus').text('');
            resultId = null;
        });

        function handleSessionUI(session) {

            if (!session) {
                // No session selected → show both
                $('#openBlock').show();
                $('#closeBlock').show();
                return;
            }

            if (session === 'open') {
                $('#openBlock').show();
                $('#closeBlock').hide();

                // clear close values
                $('#close_panna').val('');
                $('#close_digit').val('');
            }

            if (session === 'close') {
                $('#openBlock').hide();
                $('#closeBlock').show();

                // clear open values
                $('#open_panna').val('');
                $('#open_digit').val('');
            }
        }
    </script>
    <script>
        $('#saveDraft').on('click', function() {

            // if (!$('#open_panna').val() || !$('#open_digit').val()) {
            //     Swal.fire('Invalid Input', 'Open panna & digit required', 'warning');
            //     return;
            // }

            Swal.fire({
                title: 'Saving...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: '/admin/result/save-draft',
                type: 'POST',
                data: getPayload(),
                success: function(res) {
                    resultId = res.id;
                    Swal.fire('Saved', 'Result saved as draft', 'success');
                },
                error: function() {
                    Swal.fire('Error', 'Failed to save result', 'error');
                }
            });
        });
    </script>

    <script>
function renderWinners(res) {

    // Update totals
    $('#totalBid').text(res.total_bid ?? 0);
    $('#totalWin').text(res.total_win ?? 0);

    const tbody = $('#winnerTable');
    tbody.empty();

    // No winners case
    if (!res.winners || res.winners.length === 0) {
        tbody.append(`
            <tr>
                <td colspan="5" class="text-center text-muted">No Winners Found</td>
            </tr>
        `);
        return;
    }

    // Render rows
    res.winners.forEach((winner, index) => {
        tbody.append(`
            <tr>
                <td>${index + 1}</td>
                <td>${winner.name ?? 'N/A'}</td>
                <td>₹ ${parseFloat(winner.amount).toFixed(2)}</td>
                <td class="text-success fw-bold">₹ ${parseFloat(winner.winning_amount).toFixed(2)}</td>
                <td>
                    ${winner.game_type}
                    <span class="badge badge-info ml-1">${winner.session.toUpperCase()}</span>
                </td>
            </tr>
        `);
    });
}
</script>

    <script>
        $('#showWinner').on('click', function() {
            console.log(resultId);
        // check if openpanna is empty and 
            if (!resultId) {
                Swal.fire('No Result', 'Please save result first', 'warning');
                return;
            }

            Swal.fire({
                title: 'Calculating winners...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: `/admin/result/winners/${resultId}`,
                type: 'GET',
                success: function(res) {
                    Swal.close();
                    renderWinners(res);
                    $('#winnerModal').modal('show');
                },
                error: function() {
                    Swal.fire('Error', 'Unable to fetch winners', 'error');
                }
            });
        });
    </script>
    <script>
        $('#declareResult').on('click', function() {

            if (!resultId) {
                Swal.fire('No Result', 'Nothing to declare', 'warning');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will credit wallets and lock the result permanently',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, Declare'
            }).then((result) => {

                if (!result.isConfirmed) return;

                Swal.fire({
                    title: 'Declaring...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: '/admin/result/declare',
                    type: 'POST',
                    data: {
                        result_id: resultId
                    },
                    success: function() {
                        Swal.fire('Declared', 'Result declared successfully', 'success')
                            .then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Error', 'Declaration failed', 'error');
                    }
                });
            });
        });
    </script>
    <script>
        function getPayload() {
            return {
                result_id: resultId,
                market_id: $('#game_id').val(),
                session: $('#session').val(),
                result_date: $('#result_date').val(),
                open_panna: $('#open_panna').val(),
                open_digit: $('#open_digit').val(),
                close_panna: $('#close_panna').val(),
                close_digit: $('#close_digit').val()
            };
        }
    </script>


</body>

</html>
