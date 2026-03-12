<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>General Settings | Admin</title>
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
          <div class="col-sm-6"><h1>General Settings</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Settings</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div id="alertMsg" class="alert d-none"></div>
        <div class="row">
          <!-- Wallet Limits -->
          <div class="col-md-6">
            <div class="card card-outline card-primary">
              <div class="card-header"><h3 class="card-title"><i class="fas fa-wallet mr-2"></i>Wallet Limits</h3></div>
              <div class="card-body">
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label>Min Recharge (₹)</label>
                      <input type="number" name="min_recharge" class="form-control setting-field"
                        value="{{ $settings['min_recharge'] ?? 100 }}" min="1">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label>Max Recharge (₹)</label>
                      <input type="number" name="max_recharge" class="form-control setting-field"
                        value="{{ $settings['max_recharge'] ?? 50000 }}" min="1">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label>Min Withdraw (₹)</label>
                      <input type="number" name="min_withdraw" class="form-control setting-field"
                        value="{{ $settings['min_withdraw'] ?? 200 }}" min="1">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label>Max Withdraw (₹)</label>
                      <input type="number" name="max_withdraw" class="form-control setting-field"
                        value="{{ $settings['max_withdraw'] ?? 20000 }}" min="1">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Site Info -->
          <div class="col-md-6">
            <div class="card card-outline card-success">
              <div class="card-header"><h3 class="card-title"><i class="fas fa-cog mr-2"></i>Site Information</h3></div>
              <div class="card-body">
                <div class="form-group">
                  <label>Site Name</label>
                  <input type="text" name="site_name" class="form-control setting-field"
                    value="{{ $settings['site_name'] ?? 'Matka Play' }}" maxlength="100">
                </div>
              </div>
            </div>
          </div>

          <!-- Announcement -->
          <div class="col-12">
            <div class="card card-outline card-warning">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-bullhorn mr-2"></i>App Announcement Banner</h3>
                <div class="card-tools">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input setting-field" id="annStatus"
                      name="announcement_status" value="1"
                      {{ ($settings['announcement_status'] ?? '1') == '1' ? 'checked' : '' }}>
                    <label class="custom-control-label" for="annStatus">Active</label>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>Banner Title</label>
                  <input type="text" name="announcement_title" class="form-control setting-field"
                    value="{{ $settings['announcement_title'] ?? '' }}" maxlength="255">
                </div>
                <div class="form-group">
                  <label>Banner Message</label>
                  <textarea name="announcement_message" class="form-control setting-field" rows="3" maxlength="1000">{{ $settings['announcement_message'] ?? '' }}</textarea>
                </div>
              </div>
            </div>
          </div>

          <!-- Save Button -->
          <div class="col-12 mb-4">
            <button id="btnSave" class="btn btn-primary btn-lg">
              <i class="fas fa-save mr-2"></i>Save All Settings
            </button>
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
<script src="../../dist/js/adminlte.min.js"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
$(function () {
  $('#btnSave').on('click', function () {
    var data = {};
    $('.setting-field').each(function () {
      var name = $(this).attr('name');
      if ($(this).is(':checkbox')) {
        data[name] = $(this).is(':checked') ? 1 : 0;
      } else {
        data[name] = $(this).val();
      }
    });
    var btn = $(this).prop('disabled',true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...');
    $.post('{{ route("admin.settings.main.update") }}', data)
      .done(function(r){ if(r.status) showMsg(r.message,'success'); })
      .fail(function(x){ showMsg(x.responseJSON?.message||'Save failed','danger'); })
      .always(function(){ btn.prop('disabled',false).html('<i class="fas fa-save mr-2"></i>Save All Settings'); });
  });
  function showMsg(msg,type){
    $('#alertMsg').removeClass('d-none alert-success alert-danger').addClass('alert-'+type).text(msg);
    $('html,body').animate({scrollTop:0},300);
    setTimeout(()=>$('#alertMsg').addClass('d-none'),5000);
  }
});
</script>
</body>
</html>
