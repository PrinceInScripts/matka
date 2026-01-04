<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | DataTables</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  {{-- font awesome  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/Z1srTF+W+o8+T2Vq+0+z7N0zJwQXG6nTpGO5c5XbYl5fX5Yx5D5V5y5d5D5D5D5D5D5A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <input type="date" id="result_date" class="form-control" value="{{ date('Y-m-d') }}">
      </div>

      <div class="col-md-4">
        <label>Game Name</label>
        <select id="game_id" class="form-control">
          <option value="">Select Game</option>
          @foreach($games as $game)
            <option value="{{ $game->id }}">
              {{ $game->name }} ({{ $game->open_time }} - {{ $game->close_time }})
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
    <div class="row mb-3">
      <div class="col-md-4">
        <label>Open Panna</label>
        <select id="open_panna" class="form-control">
          <option value="">Select Panna</option>
          @foreach($pannas as $p)
            <option value="{{ $p }}">{{ $p }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-4">
        <label>Open Digit</label>
        <input type="number" id="open_digit" class="form-control">
      </div>
    </div>

    {{-- CLOSE --}}
    <div class="row mb-3">
      <div class="col-md-4">
        <label>Close Panna</label>
        <select id="close_panna" class="form-control">
          <option value="">Select Panna</option>
          @foreach($pannas as $p)
            <option value="{{ $p }}">{{ $p }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-4">
        <label>Close Digit</label>
        <input type="number" id="close_digit" class="form-control">
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
        <button type="button" class="close" data-dismiss="modal">&times;</button>
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
              <th>Bid Points</th>
              <th>Winning</th>
              <th>Type</th>
            </tr>
          </thead>
          <tbody id="winnerTable">
            <tr><td colspan="5" class="text-center">No Data</td></tr>
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
        @foreach($results as $i => $r)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ $r->game->name }}</td>
          <td>{{ $r->result_date }}</td>
          <td>{{ $r->open_panna }}-{{ $r->open_digit }}</td>
          <td>{{ $r->close_panna }}-{{ $r->close_digit }}</td>
          <td>
            @if($r->status === 'draft')
              <button class="btn btn-danger btn-sm deleteResult" data-id="{{ $r->id }}">Delete</button>
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
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
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
{{-- font awesome script--}}



<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
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
let resultId = null;

$('#goBtn').click(function () {
  axios.post('/admin/result/context', {
    game_id: $('#game_id').val(),
    session: $('#session').val(),
    result_date: $('#result_date').val()
  }).then(res => {
    $('#declareSection').removeClass('d-none');

    if(res.data){
      resultId = res.data.id;
      $('#open_panna').val(res.data.open_panna);
      $('#open_digit').val(res.data.open_digit);
      $('#close_panna').val(res.data.close_panna);
      $('#close_digit').val(res.data.close_digit);
      $('#resultStatus').text(res.data.status);
    }
  });
});

$('#saveDraft').click(function () {
  axios.post('/admin/result/save', getPayload());
});

$('#showWinner').click(function () {
  axios.get(`/admin/result/winners/${resultId}`)
       .then(res => {
          renderWinners(res.data);
          $('#winnerModal').modal('show');
       });
});

$('#declareResult').click(function () {
  if(!confirm('This cannot be undone. Continue?')) return;
  axios.post('/admin/result/declare', { result_id: resultId })
       .then(() => location.reload());
});

function getPayload(){
  return {
    result_id: resultId,
    open_panna: $('#open_panna').val(),
    open_digit: $('#open_digit').val(),
    close_panna: $('#close_panna').val(),
    close_digit: $('#close_digit').val()
  }
}
</script>

</body>
</html>
