<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Add Money | Matka Play</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <style>
    .home-content{flex:1;overflow-y:auto;background:#f5f6fa;padding:80px 15px 100px;height:calc(100dvh - 56px);box-sizing:border-box;}
    .top-bar{position:fixed;top:0;width:100%;max-width:500px;display:flex;align-items:center;justify-content:space-between;padding:15px 20px;border-bottom:1px solid #eee;background:#fff;z-index:10;}
    .top-bar .back-btn{width:36px;height:36px;border-radius:50%;background:#2563eb;color:#fff;border:none;display:flex;align-items:center;justify-content:center;}
    .mode-card{background:#fff;border-radius:16px;padding:20px;box-shadow:0 4px 16px rgba(0,0,0,.07);margin-bottom:16px;cursor:pointer;border:2px solid transparent;transition:.2s;}
    .mode-card:hover,.mode-card.active{border-color:#2563eb;background:#eff6ff;}
    .mode-icon{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:12px;}
    .mode-title{font-weight:700;font-size:15px;margin-bottom:4px;}
    .mode-desc{font-size:12px;color:#64748b;line-height:1.4;}
    .mode-badge{font-size:10px;padding:2px 8px;border-radius:20px;margin-left:6px;}
    .balance-chip{background:#f0fdf4;border-radius:12px;padding:10px 16px;display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;}
    .proceed-btn{width:100%;background:#2563eb;color:#fff;border:none;border-radius:14px;padding:14px;font-weight:700;font-size:15px;box-shadow:0 4px 12px rgba(37,99,235,.3);}
  </style>
</head>
<body>
<div class="app-layout">
  <div class="left-area">
    <div class="top-bar">
      <button class="back-btn" onclick="history.back()"><i class="fa fa-angle-left"></i></button>
      <h6 class="m-0 fw-bold">Add Money</h6>
      @include('components.walletinfo')
    </div>
    <div class="home-content">
      <div class="balance-chip">
        <span class="text-muted" style="font-size:13px">Available Balance</span>
        <strong class="text-success" style="font-size:16px">₹{{ auth()->user()->wallet->balance ?? 0 }}</strong>
      </div>

      <p class="text-muted fw-600 mb-3" style="font-size:13px">Choose deposit method</p>

      <!-- Manual -->
      <div class="mode-card" onclick="window.location='{{ route('deposit.funds.manual') }}'">
        <div class="d-flex align-items-center gap-3">
          <div class="mode-icon bg-primary bg-opacity-10 text-primary"><i class="fa fa-qrcode"></i></div>
          <div>
            <div class="mode-title">Manual UPI / Bank Transfer <span class="badge bg-warning text-dark mode-badge">Always Active</span></div>
            <div class="mode-desc">Pay via UPI QR code or bank transfer. Upload screenshot proof. Admin approves within minutes.</div>
          </div>
        </div>
      </div>

      <!-- Auto -->
      <div class="mode-card" onclick="window.location='{{ route('deposit.funds.auto') }}'">
        <div class="d-flex align-items-center gap-3">
          <div class="mode-icon bg-success bg-opacity-10 text-success"><i class="fa fa-bolt"></i></div>
          <div>
            <div class="mode-title">Auto Payment Gateway <span class="badge bg-success mode-badge">Instant</span></div>
            <div class="mode-desc">Pay instantly via Razorpay / Cashfree / PhonePe. Amount credited automatically after payment.</div>
          </div>
        </div>
      </div>

      <!-- History link -->
      <a href="{{ route('deposit.history') }}" class="d-flex align-items-center gap-2 text-decoration-none mt-3 p-3" style="background:#fff;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.06)">
        <i class="fa fa-history text-primary"></i>
        <span style="font-size:13px;font-weight:600;color:#334155">View Deposit History</span>
        <i class="fa fa-angle-right ms-auto text-muted"></i>
      </a>
    </div>
    @include('components.bottombar')
  </div>
  @include('components.rightside')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
