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
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/Z1srTF+W+o8+T2Vq+0+z7N0zJwQXG6nTpGO5c5XbYl5fX5Yx5D5V5y5d5D5D5D5D5D5A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <style>
        .right-panel {
            position: fixed;
            top: 0;
            right: -450px;
            width: 450px;
            height: 100vh;
            background: #fff;
            z-index: 99999;
            transition: .4s;
            padding: 20px;
            overflow-y: auto;
            box-shadow: -3px 0 10px rgba(0, 0, 0, 0.3);
        }

        .right-panel.active {
            right: 0;
        }

        .close-panel {
            float: right;
            cursor: pointer;
            font-size: 24px;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <x-admin-navbar />

        <x-admin-sidebar />

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Gamelists</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Gamelists</li>
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
                                <div class="card-header d-flex justify-content-between">
                                    <h3 class="card-title">Game Name List</h3>
                                    <button class="btn btn-primary" onclick="openAddGame()">Add Game</button>


                                    {{-- <a href="{{ route('admin.gamelist.create') }}" class="btn btn-primary">Add Game</a> --}}
                                </div>

                                <div class="card-body">
                                    <table class="table table-bordered table-striped" id="marketTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Game Name</th>
                                                <th>Slot Time</th>
                                                <th>Game Active</th>
                                                <th>Admin Status</th>
                                                <th>Live Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($markets as $market)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>

                                                    <td>{{ $market->name }}</td>

                                                    <td>
                                                        <span class="badge badge-info">
                                                            {{ $market->open_time_format }} -
                                                            {{ $market->close_time_format }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $market->game_status ? 'success' : 'danger' }}">
                                                            {{ $market->game_status ? 'Enabled' : 'Disabled' }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $market->market_status ? 'success' : 'danger' }}">
                                                            {{ $market->market_status ? 'Open' : 'Closed' }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $market->is_live ? 'success' : 'secondary' }}">
                                                            {{ $market->is_live ? 'Live Now' : 'Closed Now' }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <button
                                                            onclick="openEditGame(
    {{ $market->id }},
    '{{ $market->name }}',
    '{{ $market->today_open_time }}',
    '{{ $market->today_close_time }}',
    {{ $market->game_status }},
    {{ $market->market_status }}
  )"
                                                            class="btn btn-info btn-sm">
                                                            Edit
                                                        </button>


                                                        <button onclick="openSchedule({{ $market->id }})"
                                                            class="btn btn-warning btn-sm">
                                                            Market Off Day
                                                        </button>

                                                        <button class="btn btn-warning btn-sm"
                                                            onclick="openGameTypes({{ $market->id }})">
                                                            Game Types
                                                        </button>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div id="addGamePanel" class="right-panel">
                                <span class="close-panel" onclick="closePanels()">&times;</span>
                                <h4>Add Game</h4>

                                <form id="gameForm">
                                    @csrf
                                    <label>Game Name</label>
                                    <input type="text" class="form-control" name="name" required>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label>Open Time</label>
                                            <input type="time" class="form-control" name="open_time" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Close Time</label>
                                            <input type="time" class="form-control" name="close_time" required>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label>Game Active</label>
                                            <select class="form-control" name="game_status">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Market Status</label>
                                            <select class="form-control" name="market_status">
                                                <option value="1">Open</option>
                                                <option value="0">Closed</option>
                                            </select>
                                        </div>
                                    </div>



                                    <button class="btn btn-primary btn-block mt-3">Submit</button>
                                </form>
                            </div>

                            <div id="editGamePanel" class="right-panel">
                                <span class="close-panel" onclick="closePanels()">&times;</span>
                                <h4>Update Game</h4>

                                <form id="updateGame">
                                    @csrf

                                    <input type="hidden" id="edit_game_id" name="id">

                                    <label>Game Name</label>
                                    <input id="edit_name" type="text" class="form-control" name="name" required>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label>Open Time (All Days)</label>
                                            <input id="edit_open_time" type="time" class="form-control"
                                                name="open_time" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Close Time (All Days)</label>
                                            <input id="edit_close_time" type="time" class="form-control"
                                                name="close_time" required>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label>Game Status</label>
                                            <select id="edit_game_status" class="form-control" name="game_status">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Admin Force (Market Status)</label>
                                            <select id="edit_market_status" class="form-control"
                                                name="market_status">
                                                <option value="1">Open</option>
                                                <option value="0">Force Closed</option>
                                            </select>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary btn-block mt-4">Update</button>
                                </form>
                            </div>




                            <div id="schedulePanel" class="right-panel">
                                <span class="close-panel" onclick="closePanels()">&times;</span>
                                <h4>Market Off Day</h4>

                                <form id="scheduleForm" method="POST">
                                    @csrf
                                    <input type="hidden" name="market_id" id="schedule_market_id">

                                    {{-- @foreach ($weekSchedules as $row)
                                        <div class="my-2">
                                            <input type="checkbox" name="is_open[{{ $loop->index }}]"
                                                {{ $row->is_open ? 'checked' : '' }}>
                                            {{ ucfirst($row->weekday) }}

                                            <input type="time" class="form-control mt-1"
                                                name="open_time[{{ $loop->index }}]" value="{{ $row->open_time }}">
                                            <input type="time" class="form-control mt-1"
                                                name="close_time[{{ $loop->index }}]"
                                                value="{{ $row->close_time }}">
                                            <input type="hidden" name="weekday[{{ $loop->index }}]"
                                                value="{{ $row->weekday }}">
                                        </div>
                                    @endforeach --}}

                                    <button class="btn btn-primary btn-block mt-3">Save</button>
                                </form>
                            </div>

                            <div id="gameTypesPanel" class="right-panel">
                                <span class="close-panel" onclick="closePanels()">&times;</span>
                                <h4>Edit Game Types</h4>

                                <form id="gameTypesForm" method="POST">
                                    @csrf
                                    <input type="hidden" name="market_id" id="gameTypes_market_id">

                                    <div id="gameTypesContent"></div>

                                    <button class="btn btn-primary btn-block mt-3">Save</button>
                                </form>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}


    <!-- Page specific script -->
    {{-- font awesome script --}}
    <script>
        function closePanels() {
            document.querySelectorAll('.right-panel').forEach(x => x.classList.remove('active'));
        }

        function openAddGame() {
            closePanels();
            document.getElementById('addGamePanel').classList.add('active');
        }

        function openEditGame(id, name, openTime, closeTime, gameStatus, marketStatus) {
            closePanels();

            $('#edit_game_id').val(id);
            $('#edit_name').val(name);
            $('#edit_open_time').val(openTime);
            $('#edit_close_time').val(closeTime);
            $('#edit_game_status').val(gameStatus);
            $('#edit_market_status').val(marketStatus);

            $('#editGamePanel').addClass('active');
        }



        //        function openSchedule(id) {
        //     document.getElementById('scheduleForm').action = "/admin/games/schedule/" + id;
        //     document.getElementById('schedulePanel').classList.add('active');
        // }

        function openSchedule(id) {
            closePanels();

            $.get('/admin/games/get-schedule/' + id, function(data) {

                let html = '';

                data.forEach((row, i) => {
                    html += `
                <div class="my-2">
                    <input type="checkbox" name="is_open[${i}]" ${row.is_open ? 'checked' : ''}>
                    ${row.weekday.toUpperCase()}

                    <input type="time" class="form-control mt-1"
                           name="open_time[${i}]" value="${row.open_time ?? ''}">
                    <input type="time" class="form-control mt-1"
                           name="close_time[${i}]" value="${row.close_time ?? ''}">

                    <input type="hidden" name="weekday[${i}]" value="${row.weekday}">
                </div>
            `;
                });

                $('#scheduleForm')
                    .attr('action', '/admin/games/schedule/' + id)
                    .html(`
                @csrf
                <input type="hidden" name="market_id" value="${id}">
                ${html}
                <button class="btn btn-primary btn-block mt-3">Save</button>
            `);

                $('#schedulePanel').addClass('active');
            });
        }


        function openGameTypes(marketId) {
    closePanels();

    $.get('/admin/games/game-types/' + marketId, function(res) {

        let html = '';

        res.types.forEach(t => {
            html += `
                <div class="d-flex align-items-center mb-2">
                    <input type="checkbox"
                           name="game_types[]"
                           value="${t.id}"
                           ${t.is_active == 1 ? 'checked' : ''}>
                    <span class="ml-2">${t.name}</span>
                </div>
            `;
        });

        $('#gameTypes_market_id').val(marketId);
        $('#gameTypesForm').attr('action', '/admin/games/game-types/' + marketId);
        $('#gameTypesContent').html(html);

        $('#gameTypesPanel').addClass('active');
    });
}

    </script>




    <script>
        $(function() {
            $("#marketTable").DataTable({
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
        $('#gameForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.games.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    console.log(data);
                    if (data.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        $('#gameForm')[0].reset();

                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        console.log("fv")
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: data.message,
                        });
                    }
                },
                error: function(xhr) {
                    let message = "Something went wrong!";

                    // If backend sent a readable JSON error (like duplicate market)
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: message
                    });
                }
            });
        });


        $('#updateGame').on('submit', function(e) {
            e.preventDefault();

            let id = $('#edit_game_id').val();

            $.ajax({
                url: "/admin/games/" + id + "/update-names",
                type: "POST",
                data: $(this).serialize(),

                success: function(data) {
                    if (data.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Updated",
                            text: data.message,
                            timer: 1200,
                            showConfirmButton: false
                        });

                        setTimeout(() => location.reload(), 1200);
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: data.message,
                        });
                    }
                },

                error: function(xhr) {
                    let msg = "Something went wrong!";
                    if (xhr.responseJSON && xhr.responseJSON.message)
                        msg = xhr.responseJSON.message;

                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: msg
                    });
                }
            });
        });

        $('#scheduleForm').on('submit', function(e) {
            e.preventDefault();

            let url = $(this).attr('action'); // /admin/games/schedule/{id}

            $.ajax({
                url: url,
                type: "POST",
                data: $(this).serialize(),

                success: function(res) {
                    if (res.status === "success") {

                        Swal.fire({
                            icon: "success",
                            title: "Updated",
                            text: res.message,
                            timer: 1300,
                            showConfirmButton: false
                        });

                        setTimeout(() => {
                            location.reload();
                        }, 1300);

                    } else {

                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: res.message
                        });
                    }
                },

                error: function(xhr) {
                    let msg = "Something went wrong!";

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: msg
                    });
                }
            });
        });

        $(document).on('submit', '#gameTypesForm', function(e) {
            e.preventDefault();

            let url = $(this).attr('action');

            $.ajax({
                url: url,
                type: "POST",
                data: $(this).serialize(),

                success: function(res) {
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated',
                            text: res.message,
                            timer: 1200,
                            showConfirmButton: false
                        });

                        setTimeout(() => location.reload(), 1200);
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                },

                error: function(xhr) {
                    let msg = 'Something went wrong';
                    if (xhr.responseJSON?.message) msg = xhr.responseJSON.message;

                    Swal.fire('Error', msg, 'error');
                }
            });
        });
    </script>


</body>

</html>
