<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>User Queries | Admin</title>
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
        <div class="col-sm-6"><h1>User Query Management</h1></div>
        <div class="col-sm-6"><ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">User Queries</li>
        </ol></div>
      </div>
    </div></section>
    <section class="content"><div class="container-fluid">

<div class="row mb-3">
  <div class="col-md-3"><div class="info-box bg-warning"><span class="info-box-icon"><i class="fas fa-envelope-open-text"></i></span>
    <div class="info-box-content"><span class="info-box-text">Open</span><span class="info-box-number">{{ $openCount }}</span></div></div></div>
  <div class="col-md-3"><div class="info-box bg-info"><span class="info-box-icon"><i class="fas fa-spinner"></i></span>
    <div class="info-box-content"><span class="info-box-text">In Progress</span><span class="info-box-number">{{ $inProgressCount }}</span></div></div></div>
  <div class="col-md-3"><div class="info-box bg-success"><span class="info-box-icon"><i class="fas fa-check-double"></i></span>
    <div class="info-box-content"><span class="info-box-text">Resolved</span><span class="info-box-number">{{ $resolvedCount }}</span></div></div></div>
  <div class="col-md-3"><div class="info-box bg-secondary"><span class="info-box-icon"><i class="fas fa-ban"></i></span>
    <div class="info-box-content"><span class="info-box-text">Closed</span><span class="info-box-number">{{ $closedCount }}</span></div></div></div>
</div>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title"><i class="fas fa-headset mr-2"></i>User Queries / Support Tickets</h3>
    <div class="btn-group btn-group-sm">
      <button class="btn btn-outline-secondary active" data-filter="">All</button>
      <button class="btn btn-outline-warning" data-filter="open">Open</button>
      <button class="btn btn-outline-info" data-filter="in_progress">In Progress</button>
      <button class="btn btn-outline-success" data-filter="resolved">Resolved</button>
    </div>
  </div>
  <div class="card-body table-responsive p-0">
    <table id="queryTable" class="table table-hover table-striped table-sm">
      <thead class="thead-dark">
        <tr><th>#</th><th>User</th><th>Phone</th><th>Subject</th><th>Priority</th><th>Status</th><th>Date</th><th>Action</th></tr>
      </thead>
      <tbody>
        @forelse($queries as $q)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ optional($q->user)->name ?? '—' }}</td>
          <td>{{ optional($q->user)->phone ?? '—' }}</td>
          <td>{{ Str::limit($q->subject, 40) }}</td>
          <td><span class="badge badge-{{ $q->priority==='urgent'?'danger':($q->priority==='high'?'warning':($q->priority==='medium'?'info':'secondary')) }}">{{ ucfirst($q->priority) }}</span></td>
          <td><span class="badge badge-{{ $q->status==='resolved'?'success':($q->status==='open'?'warning':($q->status==='in_progress'?'info':'secondary')) }}">{{ ucfirst(str_replace('_',' ',$q->status)) }}</span></td>
          <td><small>{{ $q->created_at->format('d M Y') }}</small></td>
          <td>
            <button class="btn btn-xs btn-primary btn-view-query" data-id="{{ $q->id }}"
              data-subject="{{ $q->subject }}" data-message="{{ $q->message }}"
              data-user="{{ optional($q->user)->name }}" data-reply="{{ $q->admin_reply }}"
              data-status="{{ $q->status }}">
              <i class="fas fa-eye"></i> View
            </button>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center py-4 text-muted">
          <i class="fas fa-headset fa-2x mb-2 d-block"></i>No queries yet. Run the SQL to create the user_queries table.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Reply Modal -->
<div class="modal fade" id="queryModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="fas fa-headset mr-2"></i>Query Details & Reply</h5>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-6"><strong>User:</strong> <span id="mqUser"></span></div>
          <div class="col-6"><strong>Subject:</strong> <span id="mqSubject"></span></div>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">User Message:</label>
          <div class="p-3 bg-light rounded" id="mqMessage"></div>
        </div>
        <div class="form-group" id="prevReplyDiv">
          <label class="font-weight-bold">Previous Reply:</label>
          <div class="p-3 bg-success text-white rounded" id="mqPrevReply"></div>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Your Reply <span class="text-danger">*</span></label>
          <textarea id="mqReply" class="form-control" rows="4" placeholder="Type your reply..."></textarea>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Update Status</label>
          <select id="mqStatus" class="form-control">
            <option value="open">Open</option>
            <option value="in_progress">In Progress</option>
            <option value="resolved">Resolved</option>
            <option value="closed">Closed</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="btnSendReply" class="btn btn-primary"><i class="fas fa-paper-plane mr-1"></i>Send Reply & Update</button>
      </div>
    </div>
  </div>
</div>
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
$.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
$(function(){
  var dt=$('#queryTable').DataTable({responsive:true,autoWidth:false,order:[[6,'desc']],
    buttons:['csv','excel','print'],columnDefs:[{orderable:false,targets:[7]}]});
  dt.buttons().container().appendTo('#queryTable_wrapper .col-md-6:eq(0)');

  $('[data-filter]').on('click',function(){
    $('[data-filter]').removeClass('active');$(this).addClass('active');
    dt.column(5).search($(this).data('filter')).draw();
  });

  var currentId=null;
  $(document).on('click','.btn-view-query',function(){
    var d=$(this).data();
    currentId=d.id;
    $('#mqUser').text(d.user||'—');
    $('#mqSubject').text(d.subject||'—');
    $('#mqMessage').text(d.message||'—');
    if(d.reply){ $('#mqPrevReply').text(d.reply); $('#prevReplyDiv').show(); }
    else { $('#prevReplyDiv').hide(); }
    $('#mqStatus').val(d.status||'open');
    $('#mqReply').val('');
    $('#queryModal').modal('show');
  });

  $('#btnSendReply').on('click',function(){
    var reply=$('#mqReply').val().trim();
    if(!reply){alert('Please write a reply');return;}
    var btn=$(this).prop('disabled',true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Sending...');
    $.post('{{ route("admin.queries.reply") }}',{id:currentId,admin_reply:reply,status:$('#mqStatus').val()})
    .done(function(r){
      if(r.status){$('#queryModal').modal('hide');location.reload();}
      else{alert(r.message||'Error');}
    })
    .fail(function(){alert('Server error');})
    .always(function(){btn.prop('disabled',false).html('<i class="fas fa-paper-plane mr-1"></i>Send Reply & Update');});
  });
});
</script>
</body></html>