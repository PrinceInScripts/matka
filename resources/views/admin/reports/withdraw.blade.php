@php
  use App\Models\Setting;
  $siteName = Setting::get('site_name') ?? 'Matka Play';
  $siteLogo = Setting::get('site_logo');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Withdraw Report | Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <x-admin-navbar /><x-admin-sidebar />
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1>Withdraw Report</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Withdraw Report</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row mb-3">
          <div class="col-md-4">
            <div class="info-box bg-warning"><span class="info-box-icon"><i class="fas fa-clock"></i></span>
              <div class="info-box-content"><span class="info-box-text">Pending Amount</span>
                <span class="info-box-number">₹{{ number_format($pendingTotal,2) }}</span></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="info-box bg-success"><span class="info-box-icon"><i class="fas fa-check"></i></span>
              <div class="info-box-content"><span class="info-box-text">Paid Amount</span>
                <span class="info-box-number">₹{{ number_format($approvedTotal,2) }}</span></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="info-box bg-primary"><span class="info-box-icon"><i class="fas fa-list"></i></span>
              <div class="info-box-content"><span class="info-box-text">Total Requests</span>
                <span class="info-box-number">{{ $withdraws->count() }}</span></div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header"><h3 class="card-title">All Withdrawal Requests</h3></div>
          <div class="card-body table-responsive p-0">
            <table id="wdTable" class="table table-hover table-striped table-sm">
              <thead class="thead-dark">
                <tr><th>#</th><th>User</th><th>Phone</th><th>Amount</th><th>UPI ID</th><th>Status</th><th>Note</th><th>Date</th></tr>
              </thead>
              <tbody>
                @foreach($withdraws as $w)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ optional($w->user)->name ?? '—' }}</td>
                  <td>{{ optional($w->user)->phone ?? '—' }}</td>
                  <td><strong>₹{{ number_format($w->amount,2) }}</strong></td>
                  <td><small>{{ $w->upi_id ?? '—' }}</small></td>
                  <td>
                    <span class="badge badge-{{ $w->status==='approved'?'success':($w->status==='rejected'?'danger':'warning') }}">
                      {{ ucfirst($w->status) }}
                    </span>
                  </td>
                  <td><small>{{ $w->admin_note ?? '—' }}</small></td>
                  <td><small>{{ $w->created_at->format('d M Y, h:i A') }}</small></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  </div>
  <footer class="main-footer"><strong>Matka Admin</strong></footer>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
<script src="../../dist/js/adminlte.min.js"></script>
<script>
$(function(){ $('#wdTable').DataTable({responsive:true,autoWidth:false,order:[[7,'desc']],buttons:['csv','excel','print']}).buttons().container().appendTo('#wdTable_wrapper .col-md-6:eq(0)'); });
</script>
</body>
</html>
