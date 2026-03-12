<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Starline Result History | Admin</title>
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <x-admin-navbar /><x-admin-sidebar />
  <div class="content-wrapper">
    <section class="content-header"><div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1>Starline Result History</h1></div>
        <div class="col-sm-6"><ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Starline › Result History</li>
        </ol></div>
      </div>
    </div></section>
    <section class="content"><div class="container-fluid">
<div class="row mb-3"><div class="col-md-4"><div class="info-box bg-success">
          <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
          <div class="info-box-content"><span class="info-box-text">Declared</span>
          <span class="info-box-number">{{ $declared }}</span></div></div></div><div class="col-md-4"><div class="info-box bg-warning">
          <span class="info-box-icon"><i class="fas fa-clock"></i></span>
          <div class="info-box-content"><span class="info-box-text">Draft</span>
          <span class="info-box-number">{{ $draft }}</span></div></div></div><div class="col-md-4"><div class="info-box bg-info">
          <span class="info-box-icon"><i class="fas fa-calendar"></i></span>
          <div class="info-box-content"><span class="info-box-text">This Month</span>
          <span class="info-box-number">{{ $thisMonth }}</span></div></div></div></div><div class="card"><div class="card-body table-responsive p-0">
      <table id="slRhTable" class="table table-hover table-striped table-sm">
        <thead class="thead-dark"><tr><th>#</th><th>Game</th><th>Result Digit</th><th>Panna</th><th>Status</th><th>Draw Date</th><th>Declared At</th></tr></thead>
        <tbody>@forelse($results as $r)
<tr>
  <td>{{ $loop->iteration }}</td>
  <td>{{ optional($r->starline)->name ?? '—' }}</td>
  <td><strong>{{ $r->result_digit }}</strong></td>
  <td>{{ $r->result_pana ?? '—' }}</td>
  <td><span class="badge badge-{{ $r->status==='declared'?'success':($r->status==='draft'?'warning':'secondary') }}">{{ ucfirst($r->status) }}</span></td>
  <td><small>{{ $r->draw_date }}</small></td>
  <td><small>{{ $r->declared_at ? \Carbon\Carbon::parse($r->declared_at)->format('d M Y H:i') : '—' }}</small></td>
</tr>
@empty
<tr><td colspan="7" class="text-center py-3 text-muted">No results declared yet.</td></tr>
@endforelse</tbody>
      </table></div></div>
    </div></section>
  </div>
  <footer class="main-footer"><strong>Matka Admin &copy; {{ date('Y') }}</strong></footer>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<script>
$(function(){
  var dt=$('#slRhTable').DataTable({responsive:true,autoWidth:false,order:[[5,'desc']],buttons:['csv','excel','print']});
  dt.buttons().container().appendTo('#slRhTable_wrapper .col-md-6:eq(0)');
});
</script>
</body></html>