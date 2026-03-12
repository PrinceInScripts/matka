<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Withdraw | Matka Play</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <style>
    .home-content{flex:1;overflow-y:auto;background:#f5f6fa;padding:80px 15px 100px;height:calc(100dvh - 56px);box-sizing:border-box;}
    .top-bar{position:fixed;top:0;width:100%;max-width:500px;display:flex;align-items:center;justify-content:space-between;padding:15px 20px;border-bottom:1px solid #eee;background:#fff;z-index:10;}
    .top-bar .back-btn{width:36px;height:36px;border-radius:50%;background:#ef4444;color:#fff;border:none;display:flex;align-items:center;justify-content:center;}
    .balance-card{background:linear-gradient(135deg,#ef4444,#dc2626);border-radius:16px;padding:20px;color:#fff;margin-bottom:16px;text-align:center;}
    .balance-card .amount{font-size:32px;font-weight:800;letter-spacing:1px;}
    .balance-card .frozen{font-size:12px;opacity:.8;margin-top:4px;}
    .card-box{background:#fff;border-radius:16px;padding:18px;box-shadow:0 4px 16px rgba(0,0,0,.07);margin-bottom:16px;}
    .form-field{border:1.5px solid #e2e8f0;border-radius:12px;padding:12px 16px;width:100%;font-size:14px;outline:none;}
    .form-field:focus{border-color:#ef4444;}
    .amount-chips{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px;}
    .amount-chip{background:#f1f5f9;border:none;border-radius:20px;padding:6px 14px;font-size:13px;font-weight:600;}
    .amount-chip:hover{background:#ef4444;color:#fff;}
    .submit-btn{width:100%;background:#ef4444;color:#fff;border:none;border-radius:14px;padding:14px;font-weight:700;font-size:15px;box-shadow:0 4px 12px rgba(239,68,68,.3);margin-top:16px;}
    .info-row{display:flex;justify-content:space-between;font-size:13px;padding:8px 0;border-bottom:1px solid #f1f5f9;}
    .info-row:last-child{border-bottom:none;}
    .rule-item{display:flex;align-items:flex-start;gap:10px;font-size:12px;color:#64748b;margin-bottom:8px;}
  </style>
</head>
<body>
<div class="app-layout">
  <div class="left-area">
    <div class="top-bar">
      <button class="back-btn" onclick="history.back()"><i class="fa fa-angle-left"></i></button>
      <h6 class="m-0 fw-bold">Withdraw Funds</h6>
      @include('components.walletinfo')
    </div>
    <div class="home-content">

      @php $wallet = auth()->user()->wallet; @endphp

      <!-- Balance Card -->
      <div class="balance-card">
        <div style="font-size:12px;opacity:.8;margin-bottom:4px">Available Balance</div>
        <div class="amount">₹{{ number_format($wallet->balance ?? 0, 2) }}</div>
        @if(($wallet->frozen_balance ?? 0) > 0)
        <div class="frozen"><i class="fa fa-lock me-1"></i>₹{{ number_format($wallet->frozen_balance,2) }} frozen (pending withdrawals)</div>
        @endif
      </div>

      <!-- Withdraw Form -->
      <div class="card-box">
        <div class="mb-3"><strong style="font-size:14px"><i class="fa fa-arrow-up me-2 text-danger"></i>Withdraw Amount</strong></div>

        <div class="amount-chips mb-3">
          @foreach([500,1000,2000,5000,10000] as $amt)
          <button class="amount-chip" onclick="setAmt({{ $amt }})">₹{{ $amt }}</button>
          @endforeach
        </div>

        <label style="font-size:12px;font-weight:600;color:#475569;margin-bottom:6px">Amount (₹) <span style="color:#94a3b8">Min ₹500</span></label>
        <input type="number" id="wAmount" class="form-field mb-3" placeholder="Enter amount" min="500">

        <label style="font-size:12px;font-weight:600;color:#475569;margin-bottom:6px">Your UPI ID</label>
        <input type="text" id="upiId" class="form-field mb-3" placeholder="e.g. 9876543210@okaxis">

        <label style="font-size:12px;font-weight:600;color:#475569;margin-bottom:6px">Confirm UPI ID</label>
        <input type="text" id="upiConfirm" class="form-field mb-3" placeholder="Re-enter UPI ID">

        <button class="submit-btn" onclick="submitWithdraw()">
          <i class="fa fa-paper-plane me-2"></i>Request Withdrawal
        </button>
      </div>

      <!-- Rules -->
      <div class="card-box">
        <strong style="font-size:13px"><i class="fa fa-info-circle me-2 text-primary"></i>Withdrawal Rules</strong>
        <div class="mt-3">
          <div class="rule-item"><i class="fa fa-check-circle text-green-500" style="color:#22c55e;margin-top:2px"></i>Minimum withdrawal: ₹500</div>
          <div class="rule-item"><i class="fa fa-clock" style="color:#f59e0b;margin-top:2px"></i>Processing time: Within 24 hours (usually within 2 hours)</div>
          <div class="rule-item"><i class="fa fa-shield-alt" style="color:#2563eb;margin-top:2px"></i>Amount is frozen until admin processes your request</div>
          <div class="rule-item"><i class="fa fa-undo" style="color:#ef4444;margin-top:2px"></i>If rejected, balance is automatically restored to your wallet</div>
        </div>
      </div>

      <!-- History Link -->
      <a href="{{ route('withdraw.history') }}" class="d-flex align-items-center gap-2 text-decoration-none p-3" style="background:#fff;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.06)">
        <i class="fa fa-history text-danger"></i>
        <span style="font-size:13px;font-weight:600;color:#334155">View Withdrawal History</span>
        <i class="fa fa-angle-right ms-auto text-muted"></i>
      </a>
    </div>
    @include('components.bottombar')
  </div>
  @include('components.rightside')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
$.ajaxSetup({headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});
function setAmt(v){ document.getElementById('wAmount').value=v; }
function submitWithdraw(){
  var amt=document.getElementById('wAmount').value;
  var upi=document.getElementById('upiId').value.trim();
  var upi2=document.getElementById('upiConfirm').value.trim();
  if(!amt||amt<500){ Swal.fire('Invalid','Minimum withdrawal is ₹500','warning'); return; }
  if(!upi){ Swal.fire('Required','Please enter your UPI ID','warning'); return; }
  if(upi!==upi2){ Swal.fire('Mismatch','UPI IDs do not match','warning'); return; }
  if(amt>{{ $wallet->balance ?? 0 }}){ Swal.fire('Insufficient','Not enough balance','error'); return; }
  Swal.fire({title:'Confirm Withdrawal',html:'Withdraw <strong>₹'+amt+'</strong> to UPI: <strong>'+upi+'</strong>',icon:'question',showCancelButton:true,confirmButtonText:'Yes, Withdraw',confirmButtonColor:'#ef4444'})
  .then(r=>{if(!r.isConfirmed)return;
    $.post('{{ route("withdraw.funds.store") }}',{amount:amt,upi_id:upi})
    .done(d=>{if(d.status){Swal.fire({icon:'success',title:'Requested!',text:d.message,confirmButtonText:'View History'}).then(()=>window.location='{{ route("withdraw.history") }}');}else{Swal.fire('Error',d.message,'error');}})
    .fail(x=>{var m='Request failed';try{m=x.responseJSON.message||m;}catch(e){}Swal.fire('Error',m,'error');});
  });
}
</script>
</body>
</html>
