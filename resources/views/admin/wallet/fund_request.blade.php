<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Fund Requests | Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <x-admin-navbar />
  <x-admin-sidebar />
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1>Fund / Deposit Requests</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Fund Requests</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">

        <!-- Summary Cards -->
        <div class="row mb-3">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner"><h3>{{ $pendingCount }}</h3><p>Pending Requests</p></div>
              <div class="icon"><i class="fas fa-clock"></i></div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner"><h3>₹{{ number_format($pendingAmount,0) }}</h3><p>Pending Amount</p></div>
              <div class="icon"><i class="fas fa-rupee-sign"></i></div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner"><h3>{{ $approvedCount }}</h3><p>Approved</p></div>
              <div class="icon"><i class="fas fa-check-circle"></i></div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner"><h3>{{ $rejectedCount }}</h3><p>Rejected</p></div>
              <div class="icon"><i class="fas fa-times-circle"></i></div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-wallet mr-2"></i>Deposit Requests</h3>
            <div class="card-tools">
              <div class="btn-group btn-group-sm" role="group">
                <button class="btn btn-outline-secondary active" data-filter="all">All</button>
                <button class="btn btn-outline-warning" data-filter="pending">Pending</button>
                <button class="btn btn-outline-success" data-filter="approved">Approved</button>
                <button class="btn btn-outline-danger" data-filter="rejected">Rejected</button>
              </div>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table id="depositTable" class="table table-hover table-striped table-sm">
              <thead class="bg-dark text-white">
                <tr>
                  <th>#</th>
                  <th>User</th>
                  <th>Phone</th>
                  <th>Amount</th>
                  <th>Mode</th>
                  <th>Txn ID</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($deposits as $d)
                <tr data-status="{{ $d->status }}">
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    <a href="{{ route('admin.user.view', $d->user_id) }}" class="text-primary">
                      {{ optional($d->user)->name ?? '—' }}
                    </a>
                  </td>
                  <td>{{ optional($d->user)->phone ?? '—' }}</td>
                  <td><strong class="text-success">₹{{ number_format($d->amount, 2) }}</strong></td>
                  <td><span class="badge badge-secondary">{{ strtoupper($d->payment_mode ?? 'UPI') }}</span></td>
                  <td><small>{{ $d->transaction_id ?? '—' }}</small></td>
                  <td><small>{{ $d->created_at->format('d M Y, h:i A') }}</small></td>
                  <td>
                    @if($d->status === 'pending')
                      <span class="badge badge-warning">Pending</span>
                    @elseif($d->status === 'approved')
                      <span class="badge badge-success">Approved</span>
                    @else
                      <span class="badge badge-danger">Rejected</span>
                    @endif
                  </td>
                  <td>
                    @if($d->status === 'pending')
                      <button class="btn btn-success btn-xs btn-approve" data-id="{{ $d->id }}" title="Approve">
                        <i class="fas fa-check"></i> Approve
                      </button>
                      <button class="btn btn-danger btn-xs btn-reject" data-id="{{ $d->id }}" title="Reject">
                        <i class="fas fa-times"></i>
                      </button>
                    @else
                      <small class="text-muted">{{ $d->admin_note ?? '—' }}</small>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  </div>

  <footer class="main-footer">
    <strong>Copyright &copy; Matka Admin.</strong> All rights reserved.
  </footer>
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
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(function () {
  var table = $('#depositTable').DataTable({
    responsive: true, autoWidth: false, order: [[6,'desc']],
    buttons: ['csv','excel','print'],
    columnDefs: [{ orderable: false, targets: [8] }]
  }).buttons().container().appendTo('#depositTable_wrapper .col-md-6:eq(0)');

  // Tab filter
  $('[data-filter]').on('click', function () {
    $('[data-filter]').removeClass('active');
    $(this).addClass('active');
    var f = $(this).data('filter');
    var dt = $('#depositTable').DataTable();
    dt.column(7).search(f === 'all' ? '' : f).draw();
  });

  // Approve
  $(document).on('click', '.btn-approve', function () {
    var id = $(this).data('id');
    if (!confirm('Approve this deposit? Amount will be credited to user wallet.')) return;
    var btn = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
    $.post('{{ url("admin/wallet/fund-request") }}/' + id + '/approve', {})
      .done(function (r) { if (r.status) { showToast(r.message, 'success'); setTimeout(()=>location.reload(), 1000); } })
      .fail(function (x) { showToast(x.responseJSON?.message || 'Error', 'danger'); btn.prop('disabled',false).html('<i class="fas fa-check"></i> Approve'); });
  });

  // Reject
  $(document).on('click', '.btn-reject', function () {
    var id = $(this).data('id');
    var note = prompt('Reason for rejection (optional):');
    if (note === null) return;
    $.post('{{ url("admin/wallet/fund-request") }}/' + id + '/reject', { note: note })
      .done(function (r) { if (r.status) { showToast(r.message, 'success'); setTimeout(()=>location.reload(), 1000); } })
      .fail(function (x) { showToast(x.responseJSON?.message || 'Error', 'danger'); });
  });

  function showToast(msg, type) {
    var div = $('<div class="alert alert-'+type+' alert-dismissible fade show" style="position:fixed;top:20px;right:20px;z-index:9999;min-width:280px">' + msg + '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button></div>');
    $('body').append(div); setTimeout(()=>div.alert('close'), 3000);
  }
});
</script>
</body>
</html>
