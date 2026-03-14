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
  <title>Auto Deposit | {{ $siteName }} </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <style>
    .home-content{flex:1;overflow-y:auto;background:#f5f6fa;padding:80px 15px 100px;height:calc(100dvh - 56px);box-sizing:border-box;}
    .top-bar{position:fixed;top:0;width:100%;max-width:500px;display:flex;align-items:center;justify-content:space-between;padding:15px 20px;border-bottom:1px solid #eee;background:#fff;z-index:10;}
    .back-btn{width:36px;height:36px;border-radius:50%;background:#2563eb;color:#fff;border:none;display:flex;align-items:center;justify-content:center;}
    .hero-card{background:linear-gradient(135deg,#2563eb,#1d4ed8);border-radius:20px;padding:24px;color:#fff;text-align:center;margin-bottom:20px;}
    .hero-card .balance{font-size:28px;font-weight:800;}
    .hero-card .label{font-size:12px;opacity:.8;margin-bottom:8px;}
    .card-box{background:#fff;border-radius:16px;padding:18px;box-shadow:0 4px 16px rgba(0,0,0,.07);margin-bottom:16px;}
    .amount-chips{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px;}
    .amount-chip{background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:20px;padding:6px 16px;font-size:13px;font-weight:700;color:#1d4ed8;}
    .amount-chip:hover,.amount-chip.active{background:#2563eb;color:#fff;border-color:#2563eb;}
    .form-field{border:1.5px solid #e2e8f0;border-radius:12px;padding:12px 16px;width:100%;font-size:14px;outline:none;}
    .form-field:focus{border-color:#2563eb;}
    .pay-btn{width:100%;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border:none;border-radius:14px;padding:15px;font-weight:700;font-size:16px;box-shadow:0 4px 16px rgba(34,197,94,.4);margin-top:14px;}
    .method-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px;}
    .method-card{border:2px solid #e2e8f0;border-radius:12px;padding:12px;text-align:center;cursor:pointer;transition:.15s;}
    .method-card:hover,.method-card.active{border-color:#2563eb;background:#eff6ff;}
    .method-card img{width:36px;height:36px;object-fit:contain;margin-bottom:6px;}
    .method-card span{display:block;font-size:12px;font-weight:600;color:#334155;}
    .info-tag{background:#fef3c7;border-radius:10px;padding:10px 14px;font-size:12px;color:#92400e;display:flex;align-items:flex-start;gap:8px;}
  </style>
</head>
<body>
<div class="app-layout">
  <div class="left-area">
    <div class="top-bar">
      <button class="back-btn" onclick="history.back()"><i class="fa fa-angle-left"></i></button>
      <h6 class="m-0 fw-bold">Quick Pay – Auto Deposit</h6>
      @include('components.walletinfo')
    </div>
    <div class="home-content">

      <!-- Balance -->
      <div class="hero-card">
        <div class="label">Wallet Balance</div>
        <div class="balance">₹{{ number_format(auth()->user()->wallet->balance ?? 0, 2) }}</div>
        <div style="font-size:11px;opacity:.7;margin-top:6px">Instant credit after successful payment</div>
      </div>

      <!-- Amount -->
      <div class="card-box">
        <div class="mb-2" style="font-weight:700;font-size:14px"><i class="fa fa-rupee-sign me-2 text-primary"></i>Enter Amount</div>
        <div class="amount-chips" id="amountChips">
          @foreach([100,200,500,1000,2000,5000] as $a)
          <button class="amount-chip" onclick="setAmt({{ $a }},this)">₹{{ $a }}</button>
          @endforeach
        </div>
        <input type="number" id="amount" class="form-field" placeholder="Or enter custom amount (Min ₹100)" min="100">
      </div>

      <!-- Payment Method -->
      <div class="card-box">
        <div class="mb-3" style="font-weight:700;font-size:14px"><i class="fa fa-credit-card me-2 text-primary"></i>Payment Method</div>
        <div class="method-grid">
          <div class="method-card active" data-method="upi" onclick="selectMethod(this)">
            <img src="https://cdn-icons-png.flaticon.com/512/7085/7085129.png">
            <span>UPI / QR Code</span>
          </div>
          <div class="method-card" data-method="bank" onclick="selectMethod(this)">
            <img src="https://cdn-icons-png.flaticon.com/512/2830/2830284.png">
            <span>Net Banking</span>
          </div>
          <div class="method-card" data-method="wallet" onclick="selectMethod(this)">
            <img src="https://cdn-icons-png.flaticon.com/512/1087/1087143.png">
            <span>Paytm / Wallet</span>
          </div>
          <div class="method-card" data-method="card" onclick="selectMethod(this)">
            <img src="https://cdn-icons-png.flaticon.com/512/633/633611.png">
            <span>Debit / Credit</span>
          </div>
        </div>

        <div class="info-tag">
          <i class="fa fa-info-circle mt-1"></i>
          <span>Auto payments are processed instantly via our payment gateway. Amount is credited to your wallet within seconds after successful payment.</span>
        </div>

        <button class="pay-btn" onclick="initiatePayment()">
          <i class="fa fa-bolt me-2"></i>Pay Now
        </button>
      </div>

      <!-- Go Manual -->
      <a href="{{ route('deposit.funds.manual') }}" class="d-flex align-items-center gap-3 text-decoration-none p-3" style="background:#fff;border-radius:14px;box-shadow:0 2px 8px rgba(0,0,0,.06)">
        <div style="width:40px;height:40px;border-radius:12px;background:#fef3c7;display:flex;align-items:center;justify-content:center">
          <i class="fa fa-qrcode text-warning" style="font-size:18px"></i>
        </div>
        <div>
          <div style="font-weight:700;font-size:13px;color:#334155">Use Manual Deposit Instead</div>
          <div style="font-size:11px;color:#64748b">Pay via UPI, upload screenshot for admin approval</div>
        </div>
        <i class="fa fa-angle-right ms-auto text-muted"></i>
      </a>
    </div>
    @include('components.bottombar')
  </div>
  @include('components.rightside')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
$.ajaxSetup({headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});
var selectedMethod='upi';
function setAmt(v,el){ document.getElementById('amount').value=v; document.querySelectorAll('.amount-chip').forEach(c=>c.classList.remove('active')); el.classList.add('active'); }
function selectMethod(el){ document.querySelectorAll('.method-card').forEach(c=>c.classList.remove('active')); el.classList.add('active'); selectedMethod=el.dataset.method; }
function initiatePayment(){
  var amt=document.getElementById('amount').value;
  if(!amt||amt<100){ Swal.fire('Invalid','Minimum deposit is ₹100','warning'); return; }
  // Integration point: Replace this with actual Razorpay / Cashfree SDK call
  // Example Razorpay integration:
  Swal.fire({
    title:'Payment Gateway',
    html:'<p style="font-size:13px;color:#64748b">Redirecting to payment gateway...<br>Amount: <strong>₹'+parseFloat(amt).toFixed(2)+'</strong></p>',
    icon:'info',
    confirmButtonText:'Proceed to Pay',
    showCancelButton:true,
    confirmButtonColor:'#2563eb'
  }).then(r=>{
    if(!r.isConfirmed) return;
    // POST to create order and get payment link
    $.post('{{ route("deposit.funds.store") }}',{amount:amt,method:selectedMethod})
    .done(d=>{
      if(d.status){
        // If gateway returns a redirect URL: window.location.href = d.payment_url;
        // For now show success (admin will approve via webhook)
        Swal.fire({icon:'success',title:'Order Created',text:'Complete payment in the gateway window. Your wallet will be credited automatically.',confirmButtonText:'View History'})
        .then(()=>window.location='{{ route("deposit.history") }}');
      }
    }).fail(()=>Swal.fire('Error','Could not create payment order','error'));
  });
}
</script>
</body>
</html>
