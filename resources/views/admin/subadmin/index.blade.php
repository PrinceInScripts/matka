<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Sub-Admin Management | Admin</title>
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
        <div class="col-sm-6"><h1>Sub-Admin Management</h1></div>
        <div class="col-sm-6"><ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Sub-Admin Management</li>
        </ol></div>
      </div>
    </div></section>
    <section class="content"><div class="container-fluid">

<div class="row mb-3">
  <div class="col-md-3"><div class="info-box bg-primary"><span class="info-box-icon"><i class="fas fa-user-shield"></i></span>
    <div class="info-box-content"><span class="info-box-text">Total Sub-Admins</span><span class="info-box-number">{{ $subAdmins->count() }}</span></div></div></div>
  <div class="col-md-3"><div class="info-box bg-success"><span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
    <div class="info-box-content"><span class="info-box-text">Active</span><span class="info-box-number">{{ $subAdmins->where('status',1)->count() }}</span></div></div></div>
  <div class="col-md-3"><div class="info-box bg-danger"><span class="info-box-icon"><i class="fas fa-ban"></i></span>
    <div class="info-box-content"><span class="info-box-text">Inactive</span><span class="info-box-number">{{ $subAdmins->where('status',0)->count() }}</span></div></div></div>
</div>

<div class="row">
  <div class="col-md-5">
    <div class="card card-primary card-outline">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-user-plus mr-2"></i><span id="saFormTitle">Add Sub-Admin</span></h3></div>
      <div class="card-body">
        <input type="hidden" id="saEditId">
        <div class="form-group">
          <label>Full Name <span class="text-danger">*</span></label>
          <input type="text" id="saName" class="form-control" placeholder="Full name">
        </div>
        <div class="form-group">
          <label>Username <span class="text-danger">*</span></label>
          <input type="text" id="saUsername" class="form-control" placeholder="username">
        </div>
        <div class="form-group">
          <label>Phone</label>
          <input type="text" id="saPhone" class="form-control" placeholder="Mobile number">
        </div>
        <div class="form-group">
          <label>Password <span id="saPassNote" class="text-danger">*</span></label>
          <input type="password" id="saPassword" class="form-control" placeholder="Password (leave blank to keep)">
        </div>
        <div class="form-group">
          <label>Status</label>
          <select id="saStatus" class="form-control">
            <option value="1">Active</option><option value="0">Inactive</option>
          </select>
        </div>
        <div class="form-group">
          <label>Permissions</label>
          <div class="row">
            @foreach(['dashboard','users','wallet','reports','games','starline','gali_disawar','notices','settings','queries'] as $perm)
            <div class="col-6">
              <div class="icheck-primary">
                <input type="checkbox" id="perm_{{ $perm }}" value="{{ $perm }}" class="perm-check">
                <label for="perm_{{ $perm }}">{{ ucfirst(str_replace('_',' ',$perm)) }}</label>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        <button id="btnSaveSa" class="btn btn-primary btn-block"><i class="fas fa-save mr-1"></i>Save Sub-Admin</button>
        <button id="btnCancelSa" class="btn btn-secondary btn-block mt-2" style="display:none"><i class="fas fa-times mr-1"></i>Cancel</button>
      </div>
    </div>
  </div>
  <div class="col-md-7">
    <div class="card">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-users-cog mr-2"></i>Sub-Admin List</h3></div>
      <div class="card-body table-responsive p-0">
        <table id="saTable" class="table table-hover table-striped table-sm">
          <thead class="thead-dark">
            <tr><th>#</th><th>Name</th><th>Username</th><th>Phone</th><th>Permissions</th><th>Status</th><th>Last Login</th><th>Action</th></tr>
          </thead>
          <tbody>
            @forelse($subAdmins as $sa)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td><strong>{{ $sa->name }}</strong></td>
              <td><code>{{ $sa->username }}</code></td>
              <td>{{ $sa->phone ?? '—' }}</td>
              <td>
                @if($sa->permissions)
                  @foreach(array_slice($sa->permissions,0,3) as $p)
                  <span class="badge badge-info mr-1">{{ ucfirst($p) }}</span>
                  @endforeach
                  @if(count($sa->permissions)>3)<span class="badge badge-secondary">+{{ count($sa->permissions)-3 }} more</span>@endif
                @else
                <span class="text-muted">All</span>
                @endif
              </td>
              <td>
                <span class="badge badge-{{ $sa->status?'success':'danger' }}">{{ $sa->status?'Active':'Inactive' }}</span>
              </td>
              <td><small>{{ $sa->last_login ? \Carbon\Carbon::parse($sa->last_login)->format('d M Y H:i') : 'Never' }}</small></td>
              <td>
                <button class="btn btn-xs btn-warning btn-edit-sa mr-1"
                  data-id="{{ $sa->id }}" data-name="{{ $sa->name }}"
                  data-username="{{ $sa->username }}" data-phone="{{ $sa->phone }}"
                  data-status="{{ $sa->status }}"
                  data-permissions="{{ json_encode($sa->permissions ?? []) }}">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-xs btn-{{ $sa->status?'secondary':'success' }} btn-toggle-sa"
                  data-id="{{ $sa->id }}" data-status="{{ $sa->status }}">
                  <i class="fas fa-{{ $sa->status?'ban':'check' }}"></i>
                </button>
                <button class="btn btn-xs btn-danger btn-del-sa ml-1" data-id="{{ $sa->id }}">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center py-4 text-muted">
              No sub-admins yet. Run the SQL to create the sub_admins table first.</td></tr>
            @endforelse
          </tbody>
        </table>
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
  var dt=$('#saTable').DataTable({responsive:true,autoWidth:false,columnDefs:[{orderable:false,targets:[7]}]});

  $('#btnSaveSa').on('click',function(){
    var name=$('#saName').val().trim(), uname=$('#saUsername').val().trim();
    var id=$('#saEditId').val();
    if(!name||!uname){alert('Name and username required');return;}
    if(!id&&!$('#saPassword').val()){alert('Password required for new sub-admin');return;}
    var perms=[];$('.perm-check:checked').each(function(){perms.push($(this).val());});
    var url=id?'{{ route("admin.sub_admin.update","__ID__") }}'.replace('__ID__',id):'{{ route("admin.sub_admin.store") }}';
    var btn=$(this).prop('disabled',true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Saving...');
    $.post(url,{name:name,username:uname,phone:$('#saPhone').val(),
      password:$('#saPassword').val(),status:$('#saStatus').val(),permissions:perms})
    .done(function(r){r.status?location.reload():alert(r.message||'Error');})
    .fail(function(xhr){
      var msg='Server error';
      try{msg=xhr.responseJSON.message||msg;}catch(e){}
      alert(msg);
    })
    .always(function(){btn.prop('disabled',false).html('<i class="fas fa-save mr-1"></i>Save Sub-Admin');});
  });

  $(document).on('click','.btn-edit-sa',function(){
    var d=$(this).data();
    $('#saEditId').val(d.id);$('#saName').val(d.name);
    $('#saUsername').val(d.username).prop('readonly',true);
    $('#saPhone').val(d.phone||'');$('#saStatus').val(d.status);
    $('#saPassword').attr('placeholder','Leave blank to keep current');
    $('#saPassNote').text('(optional)');
    var perms=d.permissions||[];
    if(typeof perms==='string') try{perms=JSON.parse(perms);}catch(e){perms=[];}
    $('.perm-check').prop('checked',false);
    perms.forEach(function(p){$('#perm_'+p).prop('checked',true);});
    $('#saFormTitle').text('Edit Sub-Admin');
    $('#btnCancelSa').show();
    $('html,body').animate({scrollTop:0},300);
  });

  $('#btnCancelSa').on('click',function(){
    $('#saEditId').val('');$('#saName').val('');$('#saUsername').val('').prop('readonly',false);
    $('#saPhone').val('');$('#saPassword').val('');$('#saStatus').val(1);
    $('.perm-check').prop('checked',false);
    $('#saFormTitle').text('Add Sub-Admin');$(this).hide();
    $('#saPassNote').text('*');$('#saPassword').attr('placeholder','Password');
  });

  $(document).on('click','.btn-toggle-sa',function(){
    var id=$(this).data('id'), st=$(this).data('status');
    $.post('{{ route("admin.sub_admin.toggle","__ID__") }}'.replace('__ID__',id))
    .done(function(r){r.status?location.reload():alert(r.message);})
    .fail(function(){alert('Error');});
  });

  $(document).on('click','.btn-del-sa',function(){
    var id=$(this).data('id');
    if(!confirm('Delete this sub-admin? This cannot be undone.')) return;
    $.ajax({url:'{{ route("admin.sub_admin.destroy","__ID__") }}'.replace('__ID__',id),type:'DELETE'})
    .done(function(r){r.status?location.reload():alert(r.message);})
    .fail(function(){alert('Error');});
  });
});
</script>
</body></html>