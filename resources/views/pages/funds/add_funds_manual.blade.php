@php
  use App\Models\Setting;
  $siteName = Setting::get('site_name') ?? 'Matka Play';
  $siteLogo = Setting::get('site_logo');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Manual Deposit | Matka Play</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <style>
    .home-content{flex:1;overflow-y:auto;background:#f5f6fa;padding:70px 14px 100px;height:calc(100dvh - 56px);box-sizing:border-box;}
    .top-bar{position:fixed;top:0;width:100%;max-width:500px;display:flex;align-items:center;justify-content:space-between;padding:10px 16px;border-bottom:1px solid #eee;background:#fff;z-index:10;height:56px;}
    .back-btn{width:36px;height:36px;border-radius:50%;background:#2563eb;color:#fff;border:none;display:flex;align-items:center;justify-content:center;}
    .card-box{background:#fff;border-radius:16px;padding:16px;box-shadow:0 4px 14px rgba(0,0,0,.07);margin-bottom:14px;}
    .upi-box{background:#f0fdf4;border:1.5px dashed #22c55e;border-radius:12px;padding:14px 16px;display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;}
    .upi-id{font-family:monospace;font-size:15px;font-weight:800;color:#16a34a;word-break:break-all;}
    .copy-btn{border:none;background:#22c55e;color:#fff;border-radius:10px;padding:6px 12px;font-size:12px;font-weight:700;}
    .qr-wrap{text-align:center;margin:10px 0 4px;}
    .qr-img{max-width:180px;max-height:180px;border-radius:12px;border:2px solid #e2e8f0;padding:6px;}
    .amount-chips{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px;}
    .amount-chip{background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:20px;padding:6px 14px;font-size:13px;font-weight:700;color:#1d4ed8;cursor:pointer;}
    .amount-chip.active,.amount-chip:hover{background:#2563eb;color:#fff;border-color:#2563eb;}
    .form-field{border:1.5px solid #e2e8f0;border-radius:12px;padding:11px 14px;width:100%;font-size:14px;outline:none;transition:.15s;}
    .form-field:focus{border-color:#2563eb;}
    .upload-zone{border:2px dashed #bfdbfe;border-radius:12px;padding:20px;text-align:center;cursor:pointer;transition:.2s;background:#fafcff;}
    .upload-zone:hover{border-color:#2563eb;background:#eff6ff;}
    .preview-img{max-width:100%;border-radius:10px;margin-top:8px;display:none;}
    .submit-btn{width:100%;background:linear-gradient(135deg,#2563eb,#1d4ed8);color:#fff;border:none;border-radius:14px;padding:15px;font-weight:700;font-size:15px;box-shadow:0 4px 14px rgba(37,99,235,.35);margin-top:6px;}
    .step-badge{display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:50%;background:#2563eb;color:#fff;font-size:11px;font-weight:800;margin-right:6px;flex-shrink:0;}
  </style>
</head>
<body>
@php
  use App\Models\Setting;
  $upiId   = Setting::get('admin_upi_id') ?? ($upiId ?? '9999999999@upi');
  $upiName = Setting::get('admin_upi_name') ?? 'Matka Play';
  $qrPath  = Setting::get('admin_qr_image');
  $minRecharge = Setting::get('min_recharge') ?? 100;
  $maxRecharge = Setting::get('max_recharge') ?? 50000;
@endphp
<div class="app-layout">
  <div class="left-area">
    <div class="top-bar">
      <button class="back-btn" onclick="history.back()"><i class="fa fa-angle-left"></i></button>
      <h6 class="m-0 fw-bold">Manual UPI Deposit</h6>
      @include('components.walletinfo')
    </div>
    <div class="home-content">

      {{-- Steps Info --}}
      <div class="card-box" style="background:#fffbeb;border:1px solid #fde68a;">
        <div style="font-size:12px;color:#92400e;font-weight:700;margin-bottom:8px"><i class="fa fa-info-circle me-1"></i>How it works</div>
        <div style="font-size:12px;color:#78350f;line-height:1.7">
          <div><span class="step-badge">1</span>Copy UPI ID or scan QR below</div>
          <div><span class="step-badge">2</span>Pay the exact amount via any UPI app</div>
          <div><span class="step-badge">3</span>Enter amount + UTR number + upload screenshot</div>
          <div><span class="step-badge">4</span>Admin approves within 5–15 minutes</div>
        </div>
      </div>

      {{-- UPI Details --}}
      <div class="card-box">
        <div style="font-size:12px;font-weight:700;color:#64748b;margin-bottom:8px">PAY TO</div>
        <div class="upi-box">
          <div>
            <div style="font-size:11px;color:#64748b;margin-bottom:2px">{{ $upiName }}</div>
            <div class="upi-id" id="upiIdText">{{ $upiId }}</div>
          </div>
          <button class="copy-btn" onclick="copyUPI()"><i class="fa fa-copy me-1"></i>Copy</button>
        </div>
        @if($qrPath)
        <div class="qr-wrap">
          <img src="{{ asset('storage/'.$qrPath) }}" class="qr-img" alt="QR Code">
          <div style="font-size:11px;color:#64748b;margin-top:6px">Scan QR to pay</div>
        </div>
        @endif
      </div>

      {{-- Deposit Form --}}
      <div class="card-box">
        <div style="font-size:13px;font-weight:700;margin-bottom:10px"><i class="fa fa-rupee-sign me-1 text-primary"></i>Enter Amount</div>
        <div class="amount-chips">
          @foreach([100,200,500,1000,2000,5000] as $a)
            @if($a >= $minRecharge && $a <= $maxRecharge)
              <button class="amount-chip" onclick="setAmt({{ $a }},this)">₹{{ $a }}</button>
            @endif
          @endforeach
        </div>
        <input type="number" id="amount" class="form-field mb-3"
          placeholder="Enter amount (₹{{ $minRecharge }} – ₹{{ $maxRecharge }})"
          min="{{ $minRecharge }}" max="{{ $maxRecharge }}">

        <div style="font-size:13px;font-weight:700;margin-bottom:8px"><i class="fa fa-hashtag me-1 text-primary"></i>UTR / Transaction Number</div>
        <input type="text" id="transaction_id" class="form-field mb-3"
          placeholder="12-digit UTR number from payment app">

        <div style="font-size:13px;font-weight:700;margin-bottom:8px"><i class="fa fa-image me-1 text-primary"></i>Payment Screenshot</div>
        <div class="upload-zone" onclick="document.getElementById('screenshot').click()">
          <i class="fa fa-upload text-primary" style="font-size:22px;display:block;margin-bottom:6px"></i>
          <div style="font-size:13px;font-weight:600;color:#334155">Tap to upload screenshot</div>
          <div style="font-size:11px;color:#94a3b8;margin-top:2px">JPG, PNG – Max 4MB</div>
        </div>
        <input type="file" id="screenshot" accept="image/*" style="display:none" onchange="previewShot(this)">
        <img id="shotPreview" class="preview-img" alt="Preview">

        <button class="submit-btn" onclick="submitDeposit()">
          <i class="fa fa-paper-plane me-2"></i>Submit Deposit Request
        </button>
      </div>

    </div>
    @include('components.bottombar')
  </div>
  @include('components.rightside')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
function setAmt(v,el){
  document.getElementById('amount').value=v;
  document.querySelectorAll('.amount-chip').forEach(c=>c.classList.remove('active'));
  el.classList.add('active');
}
function copyUPI(){
  var text=document.getElementById('upiIdText').innerText;
  navigator.clipboard.writeText(text).then(()=>{
    Swal.fire({icon:'success',title:'Copied!',text:'UPI ID copied to clipboard',timer:1500,showConfirmButton:false});
  });
}
function previewShot(input){
  if(input.files&&input.files[0]){
    var reader=new FileReader();
    reader.onload=function(e){
      var p=document.getElementById('shotPreview');
      p.src=e.target.result; p.style.display='block';
    };
    reader.readAsDataURL(input.files[0]);
  }
}
function submitDeposit(){
  var amt=document.getElementById('amount').value;
  var utr=document.getElementById('transaction_id').value;
  var shot=document.getElementById('screenshot').files[0];
  var min={{ $minRecharge }};
  var max={{ $maxRecharge }};

  if(!amt||parseFloat(amt)<min||parseFloat(amt)>max){
    Swal.fire('Invalid Amount','Please enter amount between ₹'+min+' and ₹'+max,'warning');return;
  }
  Swal.fire({
    title:'Confirm Deposit',
    html:'<b>Amount:</b> ₹'+parseFloat(amt).toFixed(2)+'<br><b>UTR:</b> '+(utr||'Not provided')+'<br><br><small>Make sure payment is done before submitting</small>',
    icon:'question',
    showCancelButton:true,
    confirmButtonText:'Yes, Submit',
    confirmButtonColor:'#2563eb'
  }).then(r=>{
    if(!r.isConfirmed)return;
    var fd=new FormData();
    fd.append('amount',amt);
    fd.append('transaction_id',utr);
    if(shot)fd.append('screenshot',shot);
    fd.append('_token','{{ csrf_token() }}');

    fetch('{{ route("deposit.funds.manual.store") }}',{method:'POST',body:fd})
    .then(r=>r.json())
    .then(d=>{
      if(d.status){
        Swal.fire({icon:'success',title:'Submitted!',text:d.message,confirmButtonText:'View History'})
        .then(()=>window.location='{{ route("deposit.history") }}');
      }else{
        Swal.fire('Error',d.message||'Something went wrong','error');
      }
    }).catch(()=>Swal.fire('Error','Network error. Please try again.','error'));
  });
}
</script>
</body>
</html>
