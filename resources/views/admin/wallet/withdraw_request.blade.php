<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Withdraw Requests | Admin</title>
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
          <div class="col-sm-6"><h1>Withdraw Requests</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Withdraw Requests</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">

        <div class="row mb-3">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner"><h3>{{ $pendingCount }}</h3><p>Pending</p></div>
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
            <h3 class="card-title"><i class="fas fa-money-bill-wave mr-2"></i>Withdrawal Requests</h3>
            <div class="card-tools">
              <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-secondary active" data-filter="all">All</button>
                <button class="btn btn-outline-warning" data-filter="pending">Pending</button>
                <button class="btn btn-outline-success" data-filter="approved">Approved</button>
                <button class="btn btn-outline-danger" data-filter="rejected">Rejected</button>
              </div>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table id="withdrawTable" class="table table-hover table-striped table-sm">
              <thead class="bg-dark text-white">
                <tr>
                  <th>#</th>
                  <th>User</th>
                  <th>Phone</th>
                  <th>Amount</th>
                  <th>UPI ID</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Note</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($withdraws as $w)
                <tr data-status="{{ $w->status }}">
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    <a href="{{ route('admin.user.view', $w->user_id) }}" class="text-primary">
                      {{ optional($w->user)->name ?? '—' }}
                    </a>
                  </td>
                  <td>{{ optional($w->user)->phone ?? '—' }}</td>
                  <td><strong class="text-danger">₹{{ number_format($w->amount, 2) }}</strong></td>
                  <td><small>{{ $w->upi_id ?? '—' }}</small></td>
                  <td><small>{{ $w->created_at->format('d M Y, h:i A') }}</small></td>
                  <td>
                    @if($w->status === 'pending')
                      <span class="badge badge-warning">Pending</span>
                    @elseif($w->status === 'approved')
                      <span class="badge badge-success">Paid</span>
                    @else
                      <span class="badge badge-danger">Rejected</span>
                    @endif
                  </td>
                  <td><small>{{ $w->admin_note ?? '—' }}</small></td>
                  <td>
                    @if($w->status === 'pending')
                      <button class="btn btn-success btn-xs btn-approve-wd" data-id="{{ $w->id }}" data-amount="{{ $w->amount }}" data-upi="{{ $w->upi_id }}">
                        <i class="fas fa-check"></i> Pay
                      </button>
                      <button class="btn btn-danger btn-xs btn-reject-wd" data-id="{{ $w->id }}">
                        <i class="fas fa-times"></i>
                      </button>
                    @else
                      <span class="text-muted small">Done</span>
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
  <footer class="main-footer"><strong>Copyright &copy; Matka Admin.</strong> All rights reserved.</footer>
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
  $('#withdrawTable').DataTable({ responsive:true, autoWidth:false, order:[[5,'desc']],
    buttons:['csv','excel','print'], columnDefs:[{orderable:false,targets:[8]}]
  }).buttons().container().appendTo('#withdrawTable_wrapper .col-md-6:eq(0)');

  $('[data-filter]').on('click', function () {
    $('[data-filter]').removeClass('active');
    $(this).addClass('active');
    var f=$(this).data('filter');
    $('#withdrawTable').DataTable().column(6).search(f==='all'?'':f).draw();
  });

  $(document).on('click', '.btn-approve-wd', function () {
    var id=$(this).data('id'), amt=$(this).data('amount'), upi=$(this).data('upi');
    if (!confirm('Mark ₹'+amt+' as PAID to UPI: '+upi+'?\n\nThis releases the frozen balance.')) return;
    $.post('{{ url("admin/wallet/withdraw-request") }}/'+id+'/approve',{})
      .done(function(r){ if(r.status){ showToast(r.message,'success'); setTimeout(()=>location.reload(),1000); }})
      .fail(function(x){ showToast(x.responseJSON?.message||'Error','danger'); });
  });

  $(document).on('click', '.btn-reject-wd', function () {
    var id=$(this).data('id');
    var note=prompt('Reason for rejection (balance will be returned to user):');
    if(note===null) return;
    $.post('{{ url("admin/wallet/withdraw-request") }}/'+id+'/reject',{note:note})
      .done(function(r){ if(r.status){ showToast(r.message,'success'); setTimeout(()=>location.reload(),1000); }})
      .fail(function(x){ showToast(x.responseJSON?.message||'Error','danger'); });
  });

  function showToast(msg, type) {
    var div=$('<div class="alert alert-'+type+' alert-dismissible fade show" style="position:fixed;top:20px;right:20px;z-index:9999;min-width:280px">'+msg+'<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button></div>');
    $('body').append(div); setTimeout(()=>div.alert('close'),3000);
  }
});
</script>
</body>
</html>
