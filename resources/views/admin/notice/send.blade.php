<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Send Notification | Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
          <div class="col-sm-6"><h1>Send Notification</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.notice.manage') }}">Notices</a></li>
              <li class="breadcrumb-item active">Send Notification</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card card-primary card-outline">
              <div class="card-header"><h3 class="card-title"><i class="fas fa-bell mr-2"></i>Push Notification to Users</h3></div>
              <div class="card-body">

                <div class="form-group">
                  <label>Notification Title <span class="text-danger">*</span></label>
                  <input type="text" id="nTitle" class="form-control" placeholder="e.g. Result Declared!" maxlength="255">
                </div>

                <div class="form-group">
                  <label>Message <span class="text-danger">*</span></label>
                  <textarea id="nMessage" class="form-control" rows="4" placeholder="Notification message..." maxlength="1000"></textarea>
                  <small class="text-muted"><span id="charCount">0</span>/1000</small>
                </div>

                <div class="form-group">
                  <label>Send To</label>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="target" id="targetAll" value="all" checked>
                        <label class="form-check-label" for="targetAll">
                          <strong>All Users</strong> <span class="badge badge-info">{{ $users->count() }} users</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="target" id="targetSpecific" value="specific">
                        <label class="form-check-label" for="targetSpecific"><strong>Specific Users</strong></label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group" id="specificUserDiv" style="display:none">
                  <label>Select Users</label>
                  <select id="userIds" class="form-control select2bs4" multiple style="width:100%">
                    @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }} — {{ $u->phone }}</option>
                    @endforeach
                  </select>
                </div>

                <div id="notifMsg" class="alert d-none"></div>

              </div>
              <div class="card-footer">
                <button id="btnSend" class="btn btn-primary btn-lg btn-block">
                  <i class="fas fa-paper-plane mr-2"></i>Send Notification
                </button>
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

<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(function () {
  $('.select2bs4').select2({ theme: 'bootstrap4', placeholder: 'Search users...' });

  $('input[name="target"]').on('change', function () {
    $('#specificUserDiv').toggle($(this).val() === 'specific');
  });

  $('#nMessage').on('input', function () {
    $('#charCount').text($(this).val().length);
  });

  $('#btnSend').on('click', function () {
    var title   = $('#nTitle').val().trim();
    var message = $('#nMessage').val().trim();
    var target  = $('input[name="target"]:checked').val();
    var userIds = $('#userIds').val();

    if (!title)   { showMsg('Title is required.','danger'); return; }
    if (!message) { showMsg('Message is required.','danger'); return; }
    if (target === 'specific' && (!userIds || userIds.length === 0)) {
      showMsg('Select at least one user.','danger'); return;
    }

    var confirmMsg = target === 'all'
      ? 'Send this notification to ALL ' + {{ $users->count() }} + ' users?'
      : 'Send to ' + userIds.length + ' selected users?';
    if (!confirm(confirmMsg)) return;

    var btn = $(this).prop('disabled',true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Sending...');
    $.post('{{ route("admin.notice.send.post") }}', {
      title: title, message: message, target: target, 'user_ids[]': userIds
    })
    .done(function (r) {
      if (r.status) {
        showMsg(r.message, 'success');
        $('#nTitle').val(''); $('#nMessage').val(''); $('#charCount').text(0);
      }
    })
    .fail(function (x) { showMsg(x.responseJSON?.message || 'Send failed','danger'); })
    .always(function () { btn.prop('disabled',false).html('<i class="fas fa-paper-plane mr-2"></i>Send Notification'); });
  });

  function showMsg(msg, type) {
    $('#notifMsg').removeClass('d-none alert-success alert-danger').addClass('alert-'+type).text(msg);
    setTimeout(()=>$('#notifMsg').addClass('d-none'), 5000);
  }
});
</script>
</body>
</html>
