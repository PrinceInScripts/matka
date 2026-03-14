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
  <title>General Settings | Admin</title>
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <style>
    .preview-img{max-width:120px;max-height:80px;border-radius:8px;border:1px solid #dee2e6;padding:4px;margin-top:6px;}
    .mode-radio-group{display:flex;gap:10px;flex-wrap:wrap;}
    .mode-radio-card{border:2px solid #dee2e6;border-radius:10px;padding:12px 18px;cursor:pointer;flex:1;min-width:140px;transition:.15s;}
    .mode-radio-card:hover{border-color:#007bff;}
    .mode-radio-card input{margin-right:8px;}
    .mode-radio-card.selected{border-color:#007bff;background:#f0f7ff;}
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <x-admin-navbar /><x-admin-sidebar />
  <div class="content-wrapper">
    <section class="content-header"><div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1>General Settings</h1></div>
        <div class="col-sm-6"><ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Settings</li>
        </ol></div>
      </div>
    </div></section>

    <section class="content"><div class="container-fluid">
      <div id="alertMsg" class="alert d-none mb-3"></div>

      <form id="settingsForm" enctype="multipart/form-data">
        @csrf
        <div class="row">

          {{-- ══ WALLET LIMITS ══ --}}
          <div class="col-md-6">
            <div class="card card-outline card-primary">
              <div class="card-header"><h3 class="card-title"><i class="fas fa-wallet mr-2"></i>Wallet Limits</h3></div>
              <div class="card-body">
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label>Min Recharge (₹)</label>
                      <input type="number" name="min_recharge" class="form-control" value="{{ $settings['min_recharge'] ?? 100 }}" min="1">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label>Max Recharge (₹)</label>
                      <input type="number" name="max_recharge" class="form-control" value="{{ $settings['max_recharge'] ?? 50000 }}" min="1">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label>Min Withdraw (₹)</label>
                      <input type="number" name="min_withdraw" class="form-control" value="{{ $settings['min_withdraw'] ?? 200 }}" min="1">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label>Max Withdraw (₹)</label>
                      <input type="number" name="max_withdraw" class="form-control" value="{{ $settings['max_withdraw'] ?? 20000 }}" min="1">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- ══ SITE INFO ══ --}}
          <div class="col-md-6">
            <div class="card card-outline card-success">
              <div class="card-header"><h3 class="card-title"><i class="fas fa-cog mr-2"></i>Site Information</h3></div>
              <div class="card-body">
                <div class="form-group">
                  <label>Site Name</label>
                  <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? 'Matka Play' }}" maxlength="100">
                </div>
                <div class="form-group">
                  <label>Currency Symbol</label>
                  <input type="text" name="currency_symbol" class="form-control" value="{{ $settings['currency_symbol'] ?? '₹' }}" maxlength="5">
                </div>
              </div>
            </div>
          </div>

          {{-- ══ SITE LOGO ══ --}}
          <div class="col-md-6">
            <div class="card card-outline card-info">
              <div class="card-header"><h3 class="card-title"><i class="fas fa-image mr-2"></i>Site Logo & QR Code</h3></div>
              <div class="card-body">
                <div class="form-group">
                  <label>Site Logo <small class="text-muted">(shown in topbar on user side)</small></label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="site_logo" name="site_logo" accept="image/*">
                      <label class="custom-file-label" for="site_logo">Choose logo...</label>
                    </div>
                  </div>
                  @if(!empty($settings['site_logo']))
                    <img src="{{ asset('storage/'.$settings['site_logo']) }}" class="preview-img mt-2" id="logoPreview" alt="Logo">
                  @else
                    <img src="" class="preview-img mt-2 d-none" id="logoPreview" alt="Logo">
                  @endif
                  <small class="text-muted d-block mt-1">Recommended: PNG with transparent background, max 2MB</small>
                </div>
                <div class="form-group mb-0">
                  <label>UPI QR Code Image <small class="text-muted">(shown on manual deposit page)</small></label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="admin_qr_image" name="admin_qr_image" accept="image/*">
                      <label class="custom-file-label" for="admin_qr_image">Choose QR image...</label>
                    </div>
                  </div>
                  @if(!empty($settings['admin_qr_image']))
                    <img src="{{ asset('storage/'.$settings['admin_qr_image']) }}" class="preview-img mt-2" id="qrPreview" alt="QR">
                  @else
                    <img src="" class="preview-img mt-2 d-none" id="qrPreview" alt="QR">
                  @endif
                </div>
              </div>
            </div>
          </div>

          {{-- ══ UPI DETAILS ══ --}}
          <div class="col-md-6">
            <div class="card card-outline card-secondary">
              <div class="card-header"><h3 class="card-title"><i class="fas fa-rupee-sign mr-2"></i>UPI / Payment Details</h3></div>
              <div class="card-body">
                <div class="form-group">
                  <label>Admin UPI ID <small class="text-muted">(shown to users for manual deposit)</small></label>
                  <input type="text" name="admin_upi_id" class="form-control" value="{{ $settings['admin_upi_id'] ?? '' }}" placeholder="yourname@upi">
                </div>
                <div class="form-group mb-0">
                  <label>UPI Account Name</label>
                  <input type="text" name="admin_upi_name" class="form-control" value="{{ $settings['admin_upi_name'] ?? '' }}" placeholder="Account holder name">
                </div>
              </div>
            </div>
          </div>

          {{-- ══ DEPOSIT MODE ══ --}}
          <div class="col-12">
            <div class="card card-outline card-warning">
              <div class="card-header"><h3 class="card-title"><i class="fas fa-money-bill-wave mr-2"></i>Deposit Mode Control</h3></div>
              <div class="card-body">
                <label class="mb-2 font-weight-bold">Which deposit methods are active for users?</label>
                <div class="mode-radio-group" id="depositModeGroup">
                  @php $depMode = $settings['deposit_mode'] ?? 'both'; @endphp
                  <label class="mode-radio-card {{ $depMode==='manual' ? 'selected' : '' }}">
                    <input type="radio" name="deposit_mode" value="manual" {{ $depMode==='manual' ? 'checked' : '' }}>
                    <i class="fas fa-qrcode text-warning mr-1"></i><strong>Manual Only</strong>
                    <div class="text-muted small mt-1">Users must upload screenshot proof. Admin approves manually.</div>
                  </label>
                  <label class="mode-radio-card {{ $depMode==='auto' ? 'selected' : '' }}">
                    <input type="radio" name="deposit_mode" value="auto" {{ $depMode==='auto' ? 'checked' : '' }}>
                    <i class="fas fa-bolt text-success mr-1"></i><strong>Auto Gateway Only</strong>
                    <div class="text-muted small mt-1">Payment gateway only. Instant credit on success.</div>
                  </label>
                  <label class="mode-radio-card {{ $depMode==='both' ? 'selected' : '' }}">
                    <input type="radio" name="deposit_mode" value="both" {{ $depMode==='both' ? 'checked' : '' }}>
                    <i class="fas fa-th-large text-primary mr-1"></i><strong>Both Options</strong>
                    <div class="text-muted small mt-1">User can choose Manual or Auto gateway.</div>
                  </label>
                </div>
                <div class="alert alert-info mt-3 mb-0 py-2">
                  <i class="fas fa-info-circle mr-1"></i>
                  <strong>Manual is always kept as backup.</strong> Even if Auto Only is selected, manual mode exists in the codebase for admin fallback.
                </div>
              </div>
            </div>
          </div>

          {{-- ══ APP DOWNLOAD ══ --}}
          <div class="col-md-6">
            <div class="card card-outline card-dark">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-download mr-2"></i>App Download Banner</h3>
                <div class="card-tools">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="appDownloadEnabled" name="app_download_enabled" value="1"
                      {{ ($settings['app_download_enabled'] ?? '1') == '1' ? 'checked' : '' }}>
                    <label class="custom-control-label" for="appDownloadEnabled">Show Banner</label>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group mb-0">
                  <label>APK Download URL <small class="text-muted">(link shown in banner above bottom bar)</small></label>
                  <input type="text" name="app_download_url" class="form-control" value="{{ $settings['app_download_url'] ?? '' }}" placeholder="https://yoursite.com/app.apk">
                </div>
              </div>
            </div>
          </div>

          {{-- ══ ANNOUNCEMENT ══ --}}
          <div class="col-md-6">
            <div class="card card-outline card-danger">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-bullhorn mr-2"></i>Announcement Banner</h3>
                <div class="card-tools">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="annStatus" name="announcement_status" value="1"
                      {{ ($settings['announcement_status'] ?? '1') == '1' ? 'checked' : '' }}>
                    <label class="custom-control-label" for="annStatus">Active</label>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>Announcement Title</label>
                  <input type="text" name="announcement_title" class="form-control" value="{{ $settings['announcement_title'] ?? '' }}" maxlength="255">
                </div>
                <div class="form-group mb-0">
                  <label>Announcement Message</label>
                  <textarea name="announcement_message" class="form-control" rows="3" maxlength="1000">{{ $settings['announcement_message'] ?? '' }}</textarea>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="row">
          <div class="col-12 text-right mb-4">
            <button type="submit" class="btn btn-primary btn-lg px-5">
              <i class="fas fa-save mr-2"></i>Save All Settings
            </button>
          </div>
        </div>
      </form>

    </div></section>
  </div>
</div>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<script>
// Image previews
function previewImage(inputId, previewId) {
  document.getElementById(inputId).addEventListener('change', function() {
    var preview = document.getElementById(previewId);
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) { preview.src = e.target.result; preview.classList.remove('d-none'); };
      reader.readAsDataURL(this.files[0]);
      // update label
      this.nextElementSibling.innerText = this.files[0].name;
    }
  });
}
previewImage('site_logo', 'logoPreview');
previewImage('admin_qr_image', 'qrPreview');

// Radio card highlight
document.querySelectorAll('#depositModeGroup input[type=radio]').forEach(function(r) {
  r.addEventListener('change', function() {
    document.querySelectorAll('.mode-radio-card').forEach(c => c.classList.remove('selected'));
    this.closest('.mode-radio-card').classList.add('selected');
  });
});

// Form submit with FormData (supports file uploads)
document.getElementById('settingsForm').addEventListener('submit', function(e) {
  e.preventDefault();
  var alertEl = document.getElementById('alertMsg');
  alertEl.className = 'alert d-none';

  var formData = new FormData(this);
  // Ensure checkboxes send 0 when unchecked
  if (!document.getElementById('annStatus').checked) formData.set('announcement_status', '0');
  if (!document.getElementById('appDownloadEnabled').checked) formData.set('app_download_enabled', '0');

  fetch('{{ route("admin.settings.main.update") }}', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: formData
  })
  .then(r => r.json())
  .then(d => {
    alertEl.className = 'alert alert-' + (d.status ? 'success' : 'danger');
    alertEl.textContent = d.message;
    window.scrollTo(0,0);
    setTimeout(() => alertEl.className = 'alert d-none', 4000);
  })
  .catch(() => {
    alertEl.className = 'alert alert-danger';
    alertEl.textContent = 'Failed to save settings. Please try again.';
  });
});
</script>
</body>
</html>
