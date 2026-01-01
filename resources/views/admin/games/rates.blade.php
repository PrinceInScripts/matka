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
            <h1>Game Rates </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Game Rates</li>
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
                <h3 class="card-title"></h3>
              </div>
              <div class="card-body">
               <form id="gameRatesForm">
    @csrf

    <div class="row">
        <div class="col-md-6">
            <label>Single Digit Value 1</label>
            <input name="single_digit_1" class="form-control" value="{{ $rates->single_digit_1 ?? '' }}">
        </div>

        <div class="col-md-6">
            <label>Single Digit Value 2</label>
            <input name="single_digit_2" class="form-control" value="{{ $rates->single_digit_2 ?? '' }}">
        </div>

        <div class="col-md-6">
            <label>Jodi Digit Value 1</label>
            <input name="jodi_digit_1" class="form-control" value="{{ $rates->jodi_digit_1 ?? '' }}">
        </div>

        <div class="col-md-6">
            <label>Jodi Digit Value 2</label>
            <input name="jodi_digit_2" class="form-control" value="{{ $rates->jodi_digit_2 ?? '' }}">
        </div>

        <div class="col-md-6">
            <label>Single Pana Value 1</label>
            <input name="single_pana_1" class="form-control" value="{{ $rates->single_pana_1 ?? '' }}">
        </div>

        <div class="col-md-6">
            <label>Single Pana Value 2</label>
            <input name="single_pana_2" class="form-control" value="{{ $rates->single_pana_2 ?? '' }}">
        </div>

        <div class="col-md-6">
            <label>Double Pana Value 1</label>
            <input name="double_pana_1" class="form-control" value="{{ $rates->double_pana_1 ?? '' }}">
        </div>

        <div class="col-md-6">
            <label>Double Pana Value 2</label>
            <input name="double_pana_2" class="form-control" value="{{ $rates->double_pana_2 ?? '' }}">
        </div>

        <div class="col-md-6">
            <label>Triple Pana Value 1</label>
            <input name="triple_pana_1" class="form-control" value="{{ $rates->triple_pana_1 ?? '' }}">
        </div>

        <div class="col-md-6">
            <label>Triple Pana Value 2</label>
            <input name="triple_pana_2" class="form-control" value="{{ $rates->triple_pana_2 ?? '' }}">
        </div>

        <div class="col-md-6">
            <label>Half Sangam Value 1</label>
            <input name="half_sangam_1" class="form-control" value="{{ $rates->half_sangam_1 ?? '' }}">
        </div>

        <div class="col-md-6">
            <label>Half Sangam Value 2</label>
            <input name="half_sangam_2" class="form-control" value="{{ $rates->half_sangam_2 ?? '' }}">
        </div>

        <div class="col-md-6">
            <label>Full Sangam Value 1</label>
            <input name="full_sangam_1" class="form-control" value="{{ $rates->full_sangam_1 ?? '' }}">
        </div>

        <div class="col-md-6">
            <label>Full Sangam Value 2</label>
            <input name="full_sangam_2" class="form-control" value="{{ $rates->full_sangam_2 ?? '' }}">
        </div>
    </div>

    <button class="btn btn-primary mt-3">Submit</button>
</form>

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
{{-- swel fire --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Page specific script -->
{{-- font awesome script--}}

<script>
    $('#gameRatesForm').on('submit', function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('admin.games.rates.update') }}",
            method: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Game rates updated successfully!',
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating game rates.',
                });
            }
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
    });
  });
</script>
</body>
</html>
