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
    {{-- font awesome  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/Z1srTF+W+o8+T2Vq+0+z7N0zJwQXG6nTpGO5c5XbYl5fX5Yx5D5V5y5d5D5D5D5D5D5A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    box-shadow: -3px 0 10px rgba(0,0,0,0.3);
}
.right-panel.active { right: 0; }
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
                            <h1>DataTables</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">DataTables</li>
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
                                                <th>Today Open</th>
                                                <th>Today Close</th>
                                                <th>Active</th>
                                                <th>Market Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($markets as $market)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $market->name }}</td>
                                                    <td>{{ $market->open_time_format }}</td>
                                                    <td>{{ $market->close_time_format }}</td>
                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $market->game_status ? 'success' : 'danger' }}">
                                                            {{ $market->game_status ? 'Yes' : 'No' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-{{ $market->status_color }}">
                                                            {{ $market->status_text }}
                                                        </span>
                                                    </td>
                                                      <td>
                            <button onclick="openEditGame({{ $market->id }}, '{{ $market->name }}', '{{ $market->name_hindi ?? '' }}')" class="btn btn-info btn-sm">Edit</button>

                            <button onclick="openSchedule({{ $market->id }})" class="btn btn-primary btn-sm">Market Off Day</button>
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

    <form action="{{ route('admin.game.store') }}" method="POST">
        @csrf
        <label>Game Name</label>
        <input type="text" class="form-control" name="name" required>

        <label class="mt-2">Game Name Hindi</label>
        <input type="text" class="form-control" name="name_hindi">

        <button class="btn btn-primary btn-block mt-3">Submit</button>
    </form>
</div>

<div id="editGamePanel" class="right-panel">
    <span class="close-panel" onclick="closePanels()">&times;</span>
    <h4>Edit Game</h4>

    <form id="editGameForm" method="POST">
        @csrf
        <label>Game Name</label>
        <input id="edit_name" type="text" class="form-control" name="name" required>

        <label class="mt-2">Game Name Hindi</label>
        <input id="edit_name_hindi" type="text" class="form-control" name="name_hindi">

        <button class="btn btn-primary btn-block mt-3">Update</button>
    </form>
</div>

<div id="schedulePanel" class="right-panel">
    <span class="close-panel" onclick="closePanels()">&times;</span>
    <h4>Market Off Day</h4>

    <form id="scheduleForm" method="POST">
        @csrf
        <input type="hidden" name="market_id" id="schedule_market_id">

        @foreach($weekSchedules as $row)
        <div class="my-2">
            <input type="checkbox" name="is_open[{{ $loop->index }}]" {{ $row->is_open ? 'checked':'' }}>
            {{ ucfirst($row->weekday) }}

            <input type="time" class="form-control mt-1" name="open_time[{{ $loop->index }}]" value="{{ $row->open_time }}">
            <input type="time" class="form-control mt-1" name="close_time[{{ $loop->index }}]" value="{{ $row->close_time }}">
            <input type="hidden" name="weekday[{{ $loop->index }}]" value="{{ $row->weekday }}">
        </div>
        @endforeach

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

function openEditGame(id,name,hindi) {
    closePanels();
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_name_hindi').value = hindi;
    document.getElementById('editGameForm').action = "/admin/game/" + id + "/update";
    document.getElementById('editGamePanel').classList.add('active');
}

function openSchedule(id) {
    closePanels();
    document.getElementById('scheduleForm').action = "/admin/schedule/" + id;
    document.getElementById('schedulePanel').classList.add('active');
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
</body>

</html>
