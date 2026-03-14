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
  <title>How To Play Settings | Admin</title>
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
        <div class="col-sm-6"><h1>How To Play</h1></div>
        <div class="col-sm-6"><ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Settings › How To Play</li>
        </ol></div>
      </div>
    </div></section>
    <section class="content"><div class="container-fluid">

<div class="row">
  <div class="col-md-5">
    <div class="card card-primary card-outline">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-plus-circle mr-2"></i>Add / Edit Step</h3></div>
      <div class="card-body">
        <input type="hidden" id="editId" value="">
        <div class="form-group">
          <label>Title <span class="text-danger">*</span></label>
          <input type="text" id="htpTitle" class="form-control" placeholder="e.g. How to Register">
        </div>
        <div class="form-group">
          <label>Content <span class="text-danger">*</span></label>
          <textarea id="htpContent" class="form-control" rows="5" placeholder="Step description..."></textarea>
        </div>
        <div class="form-group">
          <label>Video URL <small class="text-muted">(YouTube embed URL, optional)</small></label>
          <input type="url" id="htpVideo" class="form-control" placeholder="https://youtube.com/embed/...">
        </div>
        <div class="form-group">
          <label>Display Order</label>
          <input type="number" id="htpOrder" class="form-control" value="0" min="0">
        </div>
        <div class="form-group">
          <label>Status</label>
          <select id="htpStatus" class="form-control">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
          </select>
        </div>
        <button id="btnSaveHtp" class="btn btn-primary btn-block">
          <i class="fas fa-save mr-1"></i>Save Step
        </button>
        <button id="btnCancelHtp" class="btn btn-secondary btn-block mt-2" style="display:none">
          <i class="fas fa-times mr-1"></i>Cancel Edit
        </button>
      </div>
    </div>
  </div>
  <div class="col-md-7">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-question-circle mr-2"></i>How To Play Steps</h3>
        <span class="badge badge-info" id="stepCount">{{ $steps->count() }} steps</span>
      </div>
      <div class="card-body p-0" id="stepsList">
        @forelse($steps->sortBy('display_order') as $step)
        <div class="step-item border-bottom p-3" id="step-{{ $step->id }}">
          <div class="d-flex justify-content-between align-items-start">
            <div class="flex-grow-1">
              <div class="d-flex align-items-center mb-1">
                <span class="badge badge-{{ $step->is_active?'success':'secondary' }} mr-2">
                  {{ $step->is_active ? 'Active' : 'Inactive' }}
                </span>
                <span class="badge badge-light mr-2">Order: {{ $step->display_order }}</span>
                <strong>{{ $step->title }}</strong>
              </div>
              <p class="text-muted mb-1 small">{{ Str::limit($step->content, 100) }}</p>
              @if($step->video_url)
              <a href="{{ $step->video_url }}" target="_blank" class="small text-primary">
                <i class="fas fa-video mr-1"></i>Video attached
              </a>
              @endif
            </div>
            <div class="ml-2 text-nowrap">
              <button class="btn btn-xs btn-warning btn-edit-step mr-1"
                data-id="{{ $step->id }}" data-title="{{ $step->title }}"
                data-content="{{ $step->content }}" data-video="{{ $step->video_url }}"
                data-order="{{ $step->display_order }}" data-status="{{ $step->is_active }}">
                <i class="fas fa-edit"></i>
              </button>
              <button class="btn btn-xs btn-danger btn-del-step" data-id="{{ $step->id }}">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </div>
        </div>
        @empty
        <div class="text-center py-4 text-muted" id="emptyMsg">
          <i class="fas fa-question-circle fa-3x mb-2 d-block"></i>No steps yet. Add your first step!
        </div>
        @endforelse
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

  $('#btnSaveHtp').on('click',function(){
    var title=$('#htpTitle').val().trim();
    var content=$('#htpContent').val().trim();
    if(!title||!content){alert('Title and content are required');return;}
    var id=$('#editId').val();
    var url=id?'{{ route("admin.settings.how_to_play.update","__ID__") }}'.replace('__ID__',id):'{{ route("admin.settings.how_to_play.store") }}';
    var btn=$(this).prop('disabled',true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Saving...');
    $.post(url,{title:title,content:content,video_url:$('#htpVideo').val(),
      display_order:$('#htpOrder').val(),is_active:$('#htpStatus').val()})
    .done(function(r){
      if(r.status){location.reload();}
      else{alert(r.message||'Error');}
    })
    .fail(function(){alert('Server error');})
    .always(function(){btn.prop('disabled',false).html('<i class="fas fa-save mr-1"></i>Save Step');});
  });

  $(document).on('click','.btn-edit-step',function(){
    var d=$(this).data();
    $('#editId').val(d.id);
    $('#htpTitle').val(d.title);
    $('#htpContent').val(d.content);
    $('#htpVideo').val(d.video||'');
    $('#htpOrder').val(d.order);
    $('#htpStatus').val(d.status);
    $('#btnCancelHtp').show();
    $('#btnSaveHtp').html('<i class="fas fa-save mr-1"></i>Update Step');
    $('html,body').animate({scrollTop:0},300);
  });

  $('#btnCancelHtp').on('click',function(){
    $('#editId').val('');$('#htpTitle').val('');$('#htpContent').val('');
    $('#htpVideo').val('');$('#htpOrder').val(0);$('#htpStatus').val(1);
    $(this).hide();$('#btnSaveHtp').html('<i class="fas fa-save mr-1"></i>Save Step');
  });

  $(document).on('click','.btn-del-step',function(){
    var id=$(this).data('id');
    if(!confirm('Delete this step?')) return;
    $.ajax({url:'{{ route("admin.settings.how_to_play.destroy","__ID__") }}'.replace('__ID__',id),type:'DELETE'})
    .done(function(r){if(r.status)$('#step-'+id).remove();else alert(r.message);})
    .fail(function(){alert('Error');});
  });
});
</script>
</body></html>