<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Announcements | Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
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
          <div class="col-sm-6"><h1>Manage Announcements</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Announcements</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- Left: Create Form -->
          <div class="col-md-4">
            <div class="card card-primary card-outline">
              <div class="card-header"><h3 class="card-title"><i class="fas fa-plus mr-2"></i>New Announcement</h3></div>
              <div class="card-body">
                <div class="form-group">
                  <label>Title <span class="text-danger">*</span></label>
                  <input type="text" id="newTitle" class="form-control" placeholder="Announcement title" maxlength="255">
                </div>
                <div class="form-group">
                  <label>Message <span class="text-danger">*</span></label>
                  <textarea id="newMessage" class="form-control" rows="4" placeholder="Announcement message..." maxlength="2000"></textarea>
                </div>
                <div class="form-group">
                  <label>Start Date (optional)</label>
                  <input type="datetime-local" id="newStart" class="form-control">
                </div>
                <div class="form-group">
                  <label>End Date (optional)</label>
                  <input type="datetime-local" id="newEnd" class="form-control">
                </div>
                <div class="form-check mb-3">
                  <input class="form-check-input" type="checkbox" id="newActive" checked>
                  <label class="form-check-label" for="newActive">Active immediately</label>
                </div>
                <div id="createMsg" class="alert d-none"></div>
              </div>
              <div class="card-footer">
                <button id="btnCreate" class="btn btn-primary btn-block">
                  <i class="fas fa-save mr-1"></i>Create Announcement
                </button>
              </div>
            </div>
          </div>

          <!-- Right: Announcements List -->
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-bullhorn mr-2"></i>All Announcements</h3>
              </div>
              <div class="card-body p-0" id="annList">
                @forelse($announcements as $ann)
                <div class="card m-3 ann-card" id="ann-{{ $ann->id }}">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>{{ $ann->title }}</strong>
                    <div>
                      <button class="btn btn-sm {{ $ann->is_active ? 'btn-success' : 'btn-secondary' }} btn-toggle"
                        data-id="{{ $ann->id }}">
                        <i class="fas {{ $ann->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} mr-1"></i>
                        {{ $ann->is_active ? 'Active' : 'Inactive' }}
                      </button>
                      <button class="btn btn-sm btn-warning btn-edit ml-1"
                        data-id="{{ $ann->id }}" data-title="{{ $ann->title }}" data-message="{{ $ann->message }}">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger btn-delete ml-1" data-id="{{ $ann->id }}">
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <p class="mb-1">{{ $ann->message }}</p>
                    <small class="text-muted">
                      Created: {{ $ann->created_at->format('d M Y, h:i A') }}
                      @if($ann->start_time) | From: {{ \Carbon\Carbon::parse($ann->start_time)->format('d M Y') }} @endif
                      @if($ann->end_time) — To: {{ \Carbon\Carbon::parse($ann->end_time)->format('d M Y') }} @endif
                    </small>
                  </div>
                </div>
                @empty
                <div class="p-4 text-center text-muted">No announcements yet. Create one on the left.</div>
                @endforelse
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <footer class="main-footer"><strong>Copyright &copy; Matka Admin.</strong></footer>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Edit Announcement</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editId">
        <div class="form-group">
          <label>Title</label>
          <input type="text" id="editTitle" class="form-control">
        </div>
        <div class="form-group">
          <label>Message</label>
          <textarea id="editMessage" class="form-control" rows="4"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button id="btnUpdate" class="btn btn-primary">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(function () {
  // Create
  $('#btnCreate').on('click', function () {
    var title = $('#newTitle').val().trim(), message = $('#newMessage').val().trim();
    if (!title || !message) { showCreateMsg('Title and message are required.','danger'); return; }
    $.post('{{ route("admin.notice.store") }}', {
      title:title, message:message, is_active:$('#newActive').is(':checked')?1:0,
      start_time:$('#newStart').val(), end_time:$('#newEnd').val()
    }).done(function(r){ if(r.status){ showCreateMsg(r.message,'success'); setTimeout(()=>location.reload(),1000); }})
      .fail(function(x){ showCreateMsg(x.responseJSON?.message||'Error','danger'); });
  });

  // Toggle active
  $(document).on('click', '.btn-toggle', function () {
    var id=$(this).data('id');
    $.post('{{ url("admin/notice") }}/'+id+'/toggle',{})
      .done(function(r){ if(r.status) location.reload(); });
  });

  // Edit modal open
  $(document).on('click', '.btn-edit', function () {
    $('#editId').val($(this).data('id'));
    $('#editTitle').val($(this).data('title'));
    $('#editMessage').val($(this).data('message'));
    $('#editModal').modal('show');
  });

  // Update
  $('#btnUpdate').on('click', function () {
    var id=$('#editId').val();
    $.post('{{ url("admin/notice") }}/'+id+'/update',{title:$('#editTitle').val(),message:$('#editMessage').val()})
      .done(function(r){ if(r.status){ $('#editModal').modal('hide'); location.reload(); }})
      .fail(function(x){ alert(x.responseJSON?.message||'Error'); });
  });

  // Delete
  $(document).on('click', '.btn-delete', function () {
    var id=$(this).data('id');
    if(!confirm('Delete this announcement?')) return;
    $.ajax({ url:'{{ url("admin/notice") }}/'+id, method:'DELETE'})
      .done(function(r){ if(r.status) $('#ann-'+id).fadeOut(300,function(){$(this).remove();}); })
      .fail(function(x){ alert(x.responseJSON?.message||'Error'); });
  });

  function showCreateMsg(msg, type) {
    $('#createMsg').removeClass('d-none alert-success alert-danger').addClass('alert-'+type).text(msg);
    setTimeout(()=>$('#createMsg').addClass('d-none'), 4000);
  }
});
</script>
</body>
</html>
