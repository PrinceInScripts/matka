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
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
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
            <h1>Winning Prediction </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Winning Prediction</li>
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
        <h3 class="card-title">Gali Disawar Winning Prediction</h3>
    </div>

    <div class="card-body">
        <div class="row">

            <div class="col-md-2">
                <label>Date</label>
                <input type="date" id="result_date" class="form-control"
                       value="{{ date('Y-m-d') }}">
            </div>

            <div class="col-md-3">
                <label>Gali Game</label>
                <select id="gali_id" class="form-control select2">
                    <option value="">Select Game</option>
                    @foreach ($games as $game)
                        <option value="{{ $game->id }}">{{ $game->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label>Digit (0–9)</label>
                <select id="digit" class="form-control select2">
                    <option value="">Any</option>
                    @for ($i = 0; $i <= 9; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2">
                <label>Jodi (00–99)</label>
                <input type="text" id="jodi" class="form-control" maxlength="2"
                       placeholder="e.g. 23">
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button id="goBtn" class="btn btn-primary w-100">Go</button>
            </div>

        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Prediction List</h3>
        <div>
            <strong>Total Bid:</strong> ₹ <span id="totalBidAmount">0</span> |
            <strong>Total Win:</strong> ₹ <span id="totalWinningAmount">0</span>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Bid Amount</th>
                    <th>Winning Amount</th>
                    <th>Txn ID</th>
                    <th>Session</th>
                </tr>
            </thead>
            <tbody id="predictionBody">
                <tr>
                    <td colspan="5" class="text-center">No Data</td>
                </tr>
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


 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        $(document).ready(function() {

            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Select option',
                allowClear: false,
                minimumResultsForSearch: 0
            });


        });

        $(document).on('shown.bs.modal', function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                dropdownParent: $('.modal:visible')
            });
        });
    </script>


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
    });x
  });

  // <script>
$('#goBtn').on('click', function () {

    if (!$('#gali_id').val()) {
        Swal.fire('Missing', 'Select Gali game', 'warning');
        return;
    }

    Swal.fire({
        title: 'Fetching...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    $.ajax({
        url: '/admin/gali-disawar/winning-predictions/search',
        type: 'GET',
        data: {
            date: $('#result_date').val(),
            gali_id: $('#gali_id').val(),
            digit: $('#digit').val() || null,
            jodi: $('#jodi').val() || null
        },
        success: function (res) {
            Swal.close();
            renderTable(res.data);
            updateTotals(res.totals);
        },
        error: function () {
            Swal.fire('Error', 'Failed to load data', 'error');
        }
    });
});

function renderTable(rows) {
    let html = '';
    let i = 1;

    if (!rows.length) {
        html = `<tr><td colspan="5" class="text-center">No Data</td></tr>`;
    }

    rows.forEach(row => {
        html += `
            <tr>
                <td>${i++}</td>
                <td>${row.user.name}</td>
                <td>${row.amount}</td>
                <td>${row.winning_amount}</td>
                <td>${row.txn_id}</td>
                <td>${row.session}</td>
            </tr>
        `;
    });

    $('#predictionBody').html(html);
}

function updateTotals(totals) {
    $('#totalBidAmount').text(totals.total_bid);
    $('#totalWinningAmount').text(totals.total_win);
}
</script>
</script>
</body>
</html>
