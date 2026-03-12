<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Withdraw Requests | Admin</title>
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <x-admin-navbar /><x-admin-sidebar />
  <div class="content-wrapper">
    <section class="content-header"><div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1><i class="fas fa-money-bill-wave mr-2 text-danger"></i>Withdrawal Requests</h1></div>
        <div class="col-sm-6"><ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Withdraw Requests</li>
        </ol></div>
      </div>
    </div></section>
    <section class="content"><div class="container-fluid">

      <div class="row mb-3">
        <div class="col-lg-3 col-6"><div class="small-box bg-warning"><div class="inner"><h3>{{ $pendingCount }}</h3><p>Pending</p></div><div class="icon"><i class="fas fa-clock"></i></div></div></div>
        <div class="col-lg-3 col-6"><div class="small-box bg-info"><div class="inner"><h3>₹{{ number_format($pendingAmount,0) }}</h3><p>Pending Amount</p></div><div class="icon"><i class="fas fa-rupee-sign"></i></div></div></div>
        <div class="col-lg-3 col-6"><div class="small-box bg-success"><div class="inner"><h3>{{ $approvedCount }}</h3><p>Approved</p></div><div class="icon"><i class="fas fa-check-circle"></i></div></div></div>
        <div class="col-lg-3 col-6"><div class="small-box bg-danger"><div class="inner"><h3>{{ $rejectedCount }}</h3><p>Rejected</p></div><div class="icon"><i class="fas fa-times-circle"></i></div></div></div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-list mr-2"></i>Withdrawal Requests</h3>
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
          <table id="withdrawTable" class="table table-hover table-sm mb-0">
            <thead class="thead-dark">
              <tr><th>#</th><th>User</th><th>Phone</th><th>Amount</th><th>UPI ID</th><th>Date</th><th>Status</th><th>Note</th><th>Action</th></tr>
            </thead>
            <tbody>
              @foreach($withdraws as $w)
              <tr data-status="{{ $w->status }}">
                <td>{{ $loop->iteration }}</td>
                <td><a href="{{ route('admin.user.view',$w->user_id) }}" class="text-primary font-weight-bold">{{ optional($w->user)->name ?? '—' }}</a></td>
                <td><small>{{ optional($w->user)->phone ?? '—' }}</small></td>
                <td><strong class="text-danger">₹{{ number_format($w->amount,2) }}</strong></td>
                <td>
                  <div class="d-flex align-items-center gap-1">
                    <code style="font-size:12px">{{ $w->upi_id }}</code>
                    <button class="btn btn-xs btn-outline-secondary" onclick="copyText('{{ $w->upi_id }}')" title="Copy UPI ID" style="padding:1px 5px;font-size:10px"><i class="fas fa-copy"></i></button>
                  </div>
                </td>
                <td><small>{{ $w->created_at->format('d M y, h:i A') }}</small></td>
                <td>
                  @if($w->status==='pending')<span class="badge badge-warning">Pending</span>
                  @elseif($w->status==='approved')<span class="badge badge-success">Approved</span>
                  @else<span class="badge badge-danger">Rejected</span>@endif
                </td>
                <td><small class="text-muted">{{ $w->admin_note ?? '—' }}</small></td>
                <td>
                  @if($w->status==='pending')
                  <button class="btn btn-success btn-xs btn-approve" data-id="{{ $w->id }}" data-upi="{{ $w->upi_id }}" data-amount="{{ $w->amount }}"><i class="fas fa-check"></i> Pay</button>
                  <button class="btn btn-danger btn-xs btn-reject" data-id="{{ $w->id }}"><i class="fas fa-times"></i></button>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div></section>
  </div>
  <footer class="main-footer"><strong>Matka Admin</strong></footer>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
function copyText(t){ navigator.clipboard.writeText(t).then(()=>Toastify({text:'UPI ID copied!',duration:1500,backgroundColor:'#28a745'}).showToast()); }
$(function(){
  var dt=$('#withdrawTable').DataTable({responsive:true,autoWidth:false,order:[[5,'desc']],columnDefs:[{orderable:false,targets:[8]}]});
  $('[data-filter]').on('click',function(){ $('[data-filter]').removeClass('active'); $(this).addClass('active'); dt.column(6).search($(this).data('filter')==='all'?'':$(this).data('filter')).draw(); });

  $(document).on('click','.btn-approve',function(){
    var id=$(this).data('id'), upi=$(this).data('upi'), amt=$(this).data('amount');
    Swal.fire({title:'Approve Withdrawal?',html:'Pay <strong>₹'+parseFloat(amt).toFixed(2)+'</strong><br>to UPI: <code>'+upi+'</code><br><br><small class="text-muted">Confirm you have sent the payment before clicking Approve</small>',icon:'warning',showCancelButton:true,confirmButtonColor:'#28a745',confirmButtonText:'Yes, Mark as Paid'})
    .then(r=>{if(!r.isConfirmed)return;
      var btn=$(this).prop('disabled',true).html('<i class="fas fa-spinner fa-spin"></i>');
      $.post('{{ url("admin/wallet/withdraw-request") }}/'+id+'/approve')
      .done(d=>{if(d.status)Swal.fire('Approved!',d.message,'success').then(()=>location.reload());})
      .fail(x=>{Swal.fire('Error',x.responseJSON?.message||'Error','error');btn.prop('disabled',false).html('<i class="fas fa-check"></i> Pay');});
    });
  });

  $(document).on('click','.btn-reject',function(){
    var id=$(this).data('id');
    Swal.fire({title:'Reject Withdrawal?',text:'Balance will be restored to user wallet.',input:'text',inputLabel:'Reason (optional)',showCancelButton:true,confirmButtonColor:'#dc3545',confirmButtonText:'Reject & Restore'})
    .then(r=>{if(!r.isConfirmed)return;
      $.post('{{ url("admin/wallet/withdraw-request") }}/'+id+'/reject',{note:r.value||''})
      .done(d=>{if(d.status)Swal.fire('Rejected',d.message,'success').then(()=>location.reload());})
      .fail(x=>{Swal.fire('Error',x.responseJSON?.message||'Error','error');});
    });
  });
});
</script>
</body>
</html>
