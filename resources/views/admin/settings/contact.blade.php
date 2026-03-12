<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Contact Settings | Admin</title>
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
          <div class="col-sm-6"><h1>Contact / Support Settings</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Contact Settings</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div id="alertMsg" class="alert d-none"></div>
        <div class="row justify-content-center">
          <div class="col-md-7">
            <div class="card card-primary card-outline">
              <div class="card-header"><h3 class="card-title"><i class="fas fa-headset mr-2"></i>Support Contact Details</h3></div>
              <div class="card-body">

                <div class="form-group">
                  <label><i class="fab fa-whatsapp text-success mr-2"></i>WhatsApp Number 1</label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">+</span></div>
                    <input type="text" name="support_whatsapp_1" class="form-control contact-field"
                      value="{{ $settings['support_whatsapp_1'] ?? '' }}"
                      placeholder="e.g. 919876543210" maxlength="20">
                  </div>
                  <small class="text-muted">Include country code, no + sign. e.g. 919876543210</small>
                </div>

                <div class="form-group">
                  <label><i class="fab fa-whatsapp text-success mr-2"></i>WhatsApp Number 2</label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">+</span></div>
                    <input type="text" name="support_whatsapp_2" class="form-control contact-field"
                      value="{{ $settings['support_whatsapp_2'] ?? '' }}"
                      placeholder="Optional second number" maxlength="20">
                  </div>
                </div>

                <div class="form-group">
                  <label><i class="fas fa-phone text-primary mr-2"></i>Call Support Number</label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">+</span></div>
                    <input type="text" name="support_call" class="form-control contact-field"
                      value="{{ $settings['support_call'] ?? '' }}"
                      placeholder="e.g. 919876543210" maxlength="20">
                  </div>
                </div>

                <div class="form-group">
                  <label><i class="fab fa-telegram text-info mr-2"></i>Telegram Link</label>
                  <input type="text" name="support_telegram" class="form-control contact-field"
                    value="{{ $settings['support_telegram'] ?? '' }}"
                    placeholder="e.g. https://t.me/yourchannel" maxlength="255">
                </div>

                <!-- Preview -->
                <div class="card bg-light">
                  <div class="card-header"><strong>Preview Links</strong></div>
                  <div class="card-body">
                    <a href="https://wa.me/{{ $settings['support_whatsapp_1'] ?? '' }}" target="_blank" class="btn btn-sm btn-success mr-2">
                      <i class="fab fa-whatsapp mr-1"></i>WhatsApp 1
                    </a>
                    @if(!empty($settings['support_whatsapp_2']))
                    <a href="https://wa.me/{{ $settings['support_whatsapp_2'] }}" target="_blank" class="btn btn-sm btn-success mr-2">
                      <i class="fab fa-whatsapp mr-1"></i>WhatsApp 2
                    </a>
                    @endif
                    @if(!empty($settings['support_telegram']))
                    <a href="{{ $settings['support_telegram'] }}" target="_blank" class="btn btn-sm btn-info mr-2">
                      <i class="fab fa-telegram mr-1"></i>Telegram
                    </a>
                    @endif
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <button id="btnSave" class="btn btn-primary btn-block">
                  <i class="fas fa-save mr-2"></i>Save Contact Settings
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
<script src="../../dist/js/adminlte.min.js"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
$(function () {
  $('#btnSave').on('click', function () {
    var data = {};
    $('.contact-field').each(function () { data[$(this).attr('name')] = $(this).val(); });
    var btn = $(this).prop('disabled',true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...');
    $.post('{{ route("admin.settings.contact.update") }}', data)
      .done(function(r){ if(r.status) showMsg(r.message,'success'); })
      .fail(function(x){ showMsg(x.responseJSON?.message||'Save failed','danger'); })
      .always(function(){ btn.prop('disabled',false).html('<i class="fas fa-save mr-2"></i>Save Contact Settings'); });
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
