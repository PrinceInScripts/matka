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
  <title>Add Money | Matka Play</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <style>
    .home-content{flex:1;overflow-y:auto;background:#f5f6fa;padding:34px 15px 100px;height:calc(100dvh - 56px);box-sizing:border-box;}
    .top-bar{position:fixed;top:0;width:100%;max-width:500px;display:flex;align-items:center;justify-content:space-between;padding:10px 16px;border-bottom:1px solid #eee;background:#fff;z-index:10;height:56px;}
    .back-btn{width:36px;height:36px;border-radius:50%;background:#2563eb;color:#fff;border:none;display:flex;align-items:center;justify-content:center;}
    .balance-chip{background:#f0fdf4;border-radius:12px;padding:12px 16px;display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;border:1px solid #bbf7d0;}
    .mode-card{background:#fff;border-radius:16px;padding:18px;box-shadow:0 4px 16px rgba(0,0,0,.07);margin-bottom:14px;cursor:pointer;border:2px solid transparent;transition:.2s;display:flex;align-items:center;gap:14px;}
    .mode-card:hover,.mode-card:active{border-color:#2563eb;background:#eff6ff;}
    .mode-icon{width:50px;height:50px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;}
    .mode-title{font-weight:700;font-size:14px;margin-bottom:3px;}
    .mode-desc{font-size:12px;color:#64748b;line-height:1.4;}
    .mode-badge{font-size:10px;padding:2px 7px;border-radius:20px;margin-left:5px;font-weight:700;}
    .section-label{font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.8px;margin-bottom:10px;}
    .history-link{display:flex;align-items:center;gap:10px;text-decoration:none;padding:13px 16px;background:#fff;border-radius:14px;box-shadow:0 2px 8px rgba(0,0,0,.06);margin-top:4px;}
  </style>
</head>
<body>
@php
  $depositMode = Setting::get('deposit_mode') ?? 'both';
  $minRecharge = Setting::get('min_recharge') ?? 100;
  $maxRecharge = Setting::get('max_recharge') ?? 50000;
  $wallet = auth()->user()->wallet;
@endphp
<div class="app-layout">
  <div class="left-area">
    {{-- <div class="top-bar">
      <button class="back-btn" onclick="history.back()"><i class="fa fa-angle-left"></i></button>
      <h6 class="m-0 fw-bold">Add Money</h6>
      @include('components.walletinfo')
    </div> --}}
    @include('components.topbar')
    <div class="home-content">

      {{-- Balance chip --}}
      <div class="balance-chip">
        <div>
          <div style="font-size:11px;color:#64748b;font-weight:600">Available Balance</div>
          <div style="font-size:20px;font-weight:800;color:#16a34a">₹{{ number_format($wallet->balance ?? 0, 2) }}</div>
        </div>
        <div style="text-align:right">
          <div style="font-size:11px;color:#64748b">Limit: ₹{{ number_format($minRecharge,0) }} – ₹{{ number_format($maxRecharge,0) }}</div>
          <div style="font-size:11px;color:#64748b;margin-top:2px">Per transaction</div>
        </div>
      </div>

      {{-- Show options based on deposit_mode setting --}}
      @if($depositMode === 'both' || $depositMode === 'manual')
      <div class="section-label">{{ $depositMode === 'both' ? 'Choose Deposit Method' : 'Deposit Method' }}</div>
      <div class="mode-card" onclick="window.location='{{ route('deposit.funds.manual') }}'">
        <div class="mode-icon bg-warning bg-opacity-10 text-warning"><i class="fa fa-qrcode"></i></div>
        <div>
          <div class="mode-title">
            Manual UPI / Bank Transfer
            <span class="badge bg-warning text-dark mode-badge">{{ $depositMode==='both' ? 'Backup' : 'Active' }}</span>
          </div>
          <div class="mode-desc">Pay via UPI QR code or bank transfer. Upload payment screenshot. Admin approves within minutes.</div>
        </div>
        <i class="fa fa-angle-right ms-auto text-muted"></i>
      </div>
      @endif

      @if($depositMode === 'both' || $depositMode === 'auto')
      <div class="mode-card" onclick="window.location='{{ route('deposit.funds.auto') }}'">
        <div class="mode-icon bg-success bg-opacity-10 text-success"><i class="fa fa-bolt"></i></div>
        <div>
          <div class="mode-title">
            Auto Payment Gateway
            <span class="badge bg-success mode-badge">Instant</span>
          </div>
          <div class="mode-desc">Pay instantly via Razorpay / Cashfree. Amount credited automatically after successful payment.</div>
        </div>
        <i class="fa fa-angle-right ms-auto text-muted"></i>
      </div>
      @endif

      @if($depositMode === 'manual')
      <div class="alert alert-info py-2 mt-2" style="border-radius:12px;font-size:12px">
        <i class="fa fa-info-circle me-1"></i>
        Only manual deposit is currently active. Contact support if you need help.
      </div>
      @elseif($depositMode === 'auto')
      <div class="alert alert-info py-2 mt-2" style="border-radius:12px;font-size:12px">
        <i class="fa fa-info-circle me-1"></i>
        Only instant payment gateway is active. Amount is credited automatically.
      </div>
      @endif

      {{-- Deposit History Link --}}
      <a href="{{ route('deposit.history') }}" class="history-link mt-3">
        <div style="width:38px;height:38px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center">
          <i class="fa fa-history text-primary"></i>
        </div>
        <div>
          <div style="font-size:13px;font-weight:700;color:#334155">Deposit History</div>
          <div style="font-size:11px;color:#64748b">View all past deposit requests</div>
        </div>
        <i class="fa fa-angle-right ms-auto text-muted"></i>
      </a>

    </div>
    @include('components.bottombar')
    @include('components.sidebar')
  </div>
  @include('components.rightside')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
