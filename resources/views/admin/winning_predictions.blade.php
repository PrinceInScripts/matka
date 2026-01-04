<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | DataTables</title>

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
  {{-- font aswesome cdn --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/Z1srTF+W+o8+T2Vq+0+z7N0zJwQXG6nTpGO5c5XbYl5fX5Yx5D5V5y5d5D5D5D5D5D5A==" crossorigin="anonymous" referrerpolicy="no-referrer" />




  {{-- font awesome  --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/Z1srTF+W+o8+T2Vq+0+z7N0zJwQXG6nTpGO5c5XbYl5fX5Yx5D5V5y5d5D5D5D5D5D5A==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
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
            <h1>Winning Predictions </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Winning Predictions</li>
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
                                    <h3 class="card-title">Select Game </h3>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Date</label>
                                            <input type="date" id="result_date" class="form-control"
                                                value="{{ date('Y-m-d') }}">
                                        </div>

                                        <div class="col-md-2">
                                            <label>Game Name</label>
                                            <select id="game_id" class="form-control">
                                                <option value="">Select Game Name</option>
                                                @foreach ($games as $game)
                                                    <option value="{{ $game->id }}">
                                                        {{ $game->name }} ({{ $game->open_time }} -
                                                        {{ $game->close_time }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label>Session Time</label>
                                            <select id="session" class="form-control">
                                                <option value="">Select Session</option>
                                                <option value="open">Open</option>
                                                <option value="close">Close</option>
                                            </select>
                                        </div>

                                         <div class="col-md-2">
                                            <label>Select Open Panna</label>
                                            <select id="open_panna" class="form-control">
                                                <option value="">Select Panna</option>
                                                @foreach ($pannas as $p)
                                                    <option value="{{ $p }}">{{ $p }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                         <div class="col-md-2">
                                            <label>Select Close Panna</label>
                                            <select id="open_panna" class="form-control">
                                                <option value="">Select Panna</option>
                                                @foreach ($pannas as $p)
                                                    <option value="{{ $p }}">{{ $p }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-end">
                                            <button id="goBtn" class="btn btn-primary w-100">Go</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                             <div class="card mt-4">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between flex-column align-items-start w-100">
                                       <h3 class="card-title">Winning Prediction List</h3>
                                    <div class="d-flex" style="gap: 20px;">
                                       <p class="mb-0">
                                        {{-- i tag for bid --}}
                                        <i class="fa-solid fa-trophy"></i>
                                        Total Bid Amount: ₹ <span id="totalBidAmount">0</span>
                                       </p>
                                       <p class="mb-0">
                                        {{-- i tag for bid --}}
                                        <i class="fa-solid fa-trophy"></i>
                                        Total Winning Amount: ₹ <span id="totalWinningAmount">0</span>
                                       </p>
                                        
                                    </div>
                                    </div>
                                   
                                </div>

                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Username</th>
                                                <th>Bid Points</th>
                                                <th>Winning Points</th>
                                                <th>Type</th>
                                                <th>Bid Txn Id</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnXh6jY0ZqJs7fPC3hKG9-3F3bKkKKlVXe6jvG3K2OAVN9OBrp1g0M9Y+7NSdGH6HWZow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- sweetalert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



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
$('#goBtn').on('click', function () {

  if (!$('#game_id').val()) {
    Swal.fire('Missing', 'Select game first', 'warning');
    return;
  }

  Swal.fire({
    title: 'Fetching predictions...',
    allowOutsideClick: false,
    didOpen: () => Swal.showLoading()
  });

  $.ajax({
    url: '/admin/result/winning-predictions/search',
    type: 'get',
    data: {
      date: $('#result_date').val(),
      game_id: $('#game_id').val(),
      session: $('#session').val() || null,
      open_panna: $('#open_panna').val() || null,
      close_panna: $('#close_panna').val() || null
    },
    success: function (res) {
      Swal.close();
      renderPredictionTable(res.data);
      updateTotals(res.totals);
    },
    error: function () {
      Swal.fire('Error', 'Failed to load predictions', 'error');
    }
  });

});
</script>
<script>
$('#session').on('change', function () {

  let session = $(this).val();

  if (!session) {
    $('#open_panna').prop('disabled', true).val('');
    $('#close_panna').prop('disabled', true).val('');
    return;
  }

  if (session === 'open') {
    $('#open_panna').prop('disabled', false);
    $('#close_panna').prop('disabled', true).val('');
  }

  if (session === 'close') {
    $('#close_panna').prop('disabled', false);
    $('#open_panna').prop('disabled', true).val('');
  }
});
</script>
<script>
function renderPredictionTable(rows) {

  let tbody = '';
  let i = 1;

  if (!rows.length) {
    tbody = `<tr><td colspan="7" class="text-center">No Data</td></tr>`;
  }

  rows.forEach(row => {
    tbody += `
      <tr>
        <td>${i++}</td>
        <td>${row.username}</td>
        <td>${row.bid_points}</td>
        <td>${row.winning_points}</td>
        <td>${row.type}</td>
        <td>${row.transaction_id}</td>
        <td>
          <span class="badge badge-${row.session === 'open' ? 'info' : 'warning'}">
            ${row.session.toUpperCase()}
          </span>
        </td>
      </tr>
    `;
  });

  $('table tbody').html(tbody);
}
</script>
<script>
function updateTotals(totals) {
  $('#totalBidAmount').text(totals.total_bid);
  $('#totalWinningAmount').text(totals.total_win);
}
</script>

</body>
</html>
