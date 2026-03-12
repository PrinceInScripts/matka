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
    .home-content{flex:1;overflow-y:auto;background:#f5f6fa;padding:80px 15px 100px;height:calc(100dvh - 56px);box-sizing:border-box;}
    .top-bar{position:fixed;top:0;width:100%;max-width:500px;display:flex;align-items:center;justify-content:space-between;padding:15px 20px;border-bottom:1px solid #eee;background:#fff;z-index:10;}
    .top-bar .back-btn{width:36px;height:36px;border-radius:50%;background:#2563eb;color:#fff;border:none;display:flex;align-items:center;justify-content:center;}
    .card-box{background:#fff;border-radius:16px;padding:18px;box-shadow:0 4px 16px rgba(0,0,0,.07);margin-bottom:16px;}
    .upi-box{background:linear-gradient(135deg,#2563eb,#1d4ed8);border-radius:14px;padding:18px;color:#fff;text-align:center;margin-bottom:16px;}
    .upi-id-chip{background:rgba(255,255,255,.15);border-radius:10px;padding:8px 16px;font-size:15px;font-weight:700;letter-spacing:.5px;display:inline-flex;align-items:center;gap:8px;cursor:pointer;}
    .amount-chips{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px;}
    .amount-chip{background:#f1f5f9;border:none;border-radius:20px;padding:6px 14px;font-size:13px;font-weight:600;transition:.15s;}
    .amount-chip:hover,.amount-chip.active{background:#2563eb;color:#fff;}
    .form-field{border:1.5px solid #e2e8f0;border-radius:12px;padding:12px 16px;width:100%;font-size:14px;outline:none;}
    .form-field:focus{border-color:#2563eb;}
    .upload-zone{border:2px dashed #cbd5e1;border-radius:12px;padding:24px;text-align:center;cursor:pointer;transition:.2s;background:#f8fafc;}
    .upload-zone:hover,.upload-zone.has-file{border-color:#2563eb;background:#eff6ff;}
    .submit-btn{width:100%;background:#2563eb;color:#fff;border:none;border-radius:14px;padding:14px;font-weight:700;font-size:15px;box-shadow:0 4px 12px rgba(37,99,235,.3);margin-top:16px;}
    .step-badge{width:24px;height:24px;border-radius:50%;background:#2563eb;color:#fff;font-size:12px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;margin-right:8px;}
    .preview-img{max-width:100%;border-radius:10px;margin-top:10px;display:none;}
  </style>
</head>
<body>
<div class="app-layout">
  <div class="left-area">
    <div class="top-bar">
      <button class="back-btn" onclick="history.back()"><i class="fa fa-angle-left"></i></button>
      <h6 class="m-0 fw-bold">Manual Deposit</h6>
      @include('components.walletinfo')
    </div>
    <div class="home-content">

      <!-- Step 1: Pay to UPI -->
      <div class="card-box">
        <div class="mb-3"><span class="step-badge">1</span><strong style="font-size:14px">Pay to our UPI</strong></div>
        <div class="upi-box">
          <div style="font-size:12px;opacity:.8;margin-bottom:6px">Scan QR or pay to UPI ID</div>
          {{-- QR Code if available --}}
          @if(!empty($qrImage))
          <img src="{{ asset('storage/'.$qrImage) }}" style="width:130px;height:130px;border-radius:10px;background:#fff;padding:6px;margin-bottom:10px">
          @else
          <div style="width:120px;height:120px;background:rgba(255,255,255,.15);border-radius:12px;margin:0 auto 10px;display:flex;align-items:center;justify-content:center;">
            <i class="fa fa-qrcode" style="font-size:50px;opacity:.6"></i>
          </div>
          @endif
          <div class="upi-id-chip" onclick="copyUpi(this)">
            <i class="fa fa-copy" style="font-size:13px;opacity:.8"></i>
            <span id="upiIdText">{{ $upiId ?? '9999999999@upi' }}</span>
          </div>
          <div style="font-size:11px;opacity:.7;margin-top:8px">Tap UPI ID to copy</div>
        </div>

        <!-- Quick Amounts -->
        <p style="font-size:12px;color:#64748b;font-weight:600;margin-bottom:8px">Quick amounts</p>
        <div class="amount-chips">
          @foreach([100,200,500,1000,2000,5000] as $amt)
          <button class="amount-chip" onclick="setAmount({{ $amt }})">₹{{ $amt }}</button>
          @endforeach
        </div>
      </div>

      <!-- Step 2: Submit Proof -->
      <div class="card-box">
        <div class="mb-3"><span class="step-badge">2</span><strong style="font-size:14px">Submit Payment Proof</strong></div>

        <label style="font-size:12px;font-weight:600;color:#475569;margin-bottom:6px">Amount Paid (₹)</label>
        <input type="number" id="amount" class="form-field mb-3" placeholder="Enter amount you paid" min="100">

        <label style="font-size:12px;font-weight:600;color:#475569;margin-bottom:6px">UTR / Transaction ID <span style="color:#94a3b8">(optional but recommended)</span></label>
        <input type="text" id="txnId" class="form-field mb-3" placeholder="e.g. 407812345678">

        <label style="font-size:12px;font-weight:600;color:#475569;margin-bottom:6px">Payment Screenshot</label>
        <div class="upload-zone" id="uploadZone" onclick="document.getElementById('screenshot').click()">
          <i class="fa fa-cloud-upload-alt" style="font-size:32px;color:#94a3b8;display:block;margin-bottom:8px"></i>
          <div style="font-size:13px;color:#64748b;font-weight:600">Click to upload screenshot</div>
          <div style="font-size:11px;color:#94a3b8">PNG, JPG up to 4MB</div>
        </div>
        <input type="file" id="screenshot" style="display:none" accept="image/*" onchange="previewFile(this)">
        <img id="previewImg" class="preview-img">

        <button class="submit-btn" id="submitBtn" onclick="submitDeposit()">
          <i class="fa fa-paper-plane me-2"></i>Submit Request
        </button>
        <p style="font-size:11px;color:#94a3b8;text-align:center;margin-top:10px">Admin will approve your deposit within 5–15 minutes</p>
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
function setAmount(v){ document.getElementById('amount').value=v; document.querySelectorAll('.amount-chip').forEach(c=>c.classList.remove('active')); event.target.classList.add('active'); }
function copyUpi(el){ var txt=document.getElementById('upiIdText').innerText; navigator.clipboard.writeText(txt).then(()=>{ el.style.background='rgba(34,197,94,.3)'; setTimeout(()=>el.style.background='',1200); }); }
function previewFile(inp){ var f=inp.files[0]; if(!f)return; var r=new FileReader(); r.onload=e=>{ var img=document.getElementById('previewImg'); img.src=e.target.result; img.style.display='block'; document.getElementById('uploadZone').classList.add('has-file'); }; r.readAsDataURL(f); }
function submitDeposit(){
  var amt=document.getElementById('amount').value;
  if(!amt||amt<100){ Swal.fire('Invalid','Minimum deposit is ₹100','warning'); return; }
  var fd=new FormData();
  fd.append('_token','{{ csrf_token() }}');
  fd.append('amount',amt);
  fd.append('transaction_id',document.getElementById('txnId').value);
  var file=document.getElementById('screenshot').files[0];
  if(file) fd.append('screenshot',file);
  document.getElementById('submitBtn').disabled=true;
  document.getElementById('submitBtn').innerHTML='<i class="fa fa-spinner fa-spin me-2"></i>Submitting...';
  fetch('{{ route("deposit.funds.manual.store") }}',{method:'POST',body:fd})
  .then(r=>r.json()).then(d=>{
    if(d.status){
      Swal.fire({icon:'success',title:'Submitted!',text:d.message,confirmButtonText:'View History'}).then(()=>window.location='{{ route("deposit.history") }}');
    }else{ Swal.fire('Error',d.message||'Submit failed','error'); }
  }).catch(()=>Swal.fire('Error','Network error','error'))
  .finally(()=>{ document.getElementById('submitBtn').disabled=false; document.getElementById('submitBtn').innerHTML='<i class="fa fa-paper-plane me-2"></i>Submit Request'; });
}
</script>
</body>
</html>
