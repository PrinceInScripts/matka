@php
  use App\Models\Setting;
  $siteName = Setting::get('site_name') ?? 'Matka Play';
  $siteLogo = Setting::get('site_logo');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Transfer Point Report | Admin</title>
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
        <div class="col-sm-6"><h1>Transfer Point Report</h1></div>
        <div class="col-sm-6"><ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Transfer Point</li>
        </ol></div>
      </div>
    </div></section>
    <section class="content"><div class="container-fluid">
<div class="row mb-3"><div class="col-md-4"><div class="info-box bg-info">
          <span class="info-box-icon"><i class="fas fa-exchange-alt"></i></span>
          <div class="info-box-content"><span class="info-box-text">Total Transfers</span>
          <span class="info-box-number">{{ $totalTransfers }}</span></div></div></div><div class="col-md-4"><div class="info-box bg-success">
          <span class="info-box-icon"><i class="fas fa-rupee-sign"></i></span>
          <div class="info-box-content"><span class="info-box-text">Total Amount</span>
          <span class="info-box-number">₹{{ number_format($totalAmount,0) }}</span></div></div></div><div class="col-md-4"><div class="info-box bg-warning">
          <span class="info-box-icon"><i class="fas fa-clock"></i></span>
          <div class="info-box-content"><span class="info-box-text">This Month</span>
          <span class="info-box-number">{{ $monthTransfers }}</span></div></div></div></div><div class="card"><div class="card-body table-responsive p-0">
      <table id="tpTable" class="table table-hover table-striped table-sm">
        <thead class="thead-dark"><tr><th>#</th><th>Sender</th><th>Phone</th><th>Receiver</th><th>Phone</th><th>Amount</th><th>Note</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
@forelse($transfers as $t)
<tr>
  <td>{{ $loop->iteration }}</td>
  <td>{{ optional($t->sender)->name ?? '—' }}</td>
  <td>{{ optional($t->sender)->phone ?? '—' }}</td>
  <td>{{ optional($t->receiver)->name ?? '—' }}</td>
  <td>{{ optional($t->receiver)->phone ?? '—' }}</td>
  <td><strong>₹{{ number_format($t->amount,2) }}</strong></td>
  <td>{{ $t->note ?? '—' }}</td>
  <td><span class="badge badge-{{ $t->status==='completed'?'success':($t->status==='failed'?'danger':'warning') }}">{{ ucfirst($t->status) }}</span></td>
  <td><small>{{ $t->created_at->format('d M Y H:i') }}</small></td>
</tr>
@empty
<tr><td colspan="9" class="text-center py-4 text-muted">No transfer records found.</td></tr>
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
  var dt=$('#tpTable').DataTable({responsive:true,autoWidth:false,order:[[8,'desc']],buttons:['csv','excel','print']});
  dt.buttons().container().appendTo('#tpTable_wrapper .col-md-6:eq(0)');
});
</script>
</body></html>