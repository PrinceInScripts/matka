@php
  use App\Models\Setting;
  $siteName = Setting::get('site_name') ?? 'Matka Play';
  $siteLogo = Setting::get('site_logo');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Wallet | Matka Play</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <style>
    .home-content{flex:1;overflow-y:auto;background:#f0f4ff;padding:66px 14px 100px;height:calc(100dvh - 56px);box-sizing:border-box;}
    /* Hero card */
    .wallet-hero{background:linear-gradient(135deg,#2563eb,#1e40af);border-radius:20px;padding:22px 20px 18px;color:#fff;margin-bottom:14px;position:relative;overflow:hidden;}
    .wallet-hero::before{content:'';position:absolute;top:-30px;right:-30px;width:120px;height:120px;background:rgba(255,255,255,.08);border-radius:50%;}
    .wallet-hero::after{content:'';position:absolute;bottom:-40px;right:40px;width:80px;height:80px;background:rgba(255,255,255,.06);border-radius:50%;}
    .balance-label{font-size:12px;opacity:.8;font-weight:600;letter-spacing:.5px;text-transform:uppercase;}
    .balance-main{font-size:36px;font-weight:800;margin:4px 0 2px;line-height:1;}
    .balance-sub{font-size:11px;opacity:.7;}
    /* Balance breakdown */
    .bal-breakdown{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px;}
    .bal-card{background:#fff;border-radius:14px;padding:14px;box-shadow:0 2px 10px rgba(0,0,0,.06);text-align:center;}
    .bal-card .label{font-size:11px;color:#64748b;font-weight:600;margin-bottom:4px;}
    .bal-card .value{font-size:17px;font-weight:800;}
    /* Action buttons */
    .action-row{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px;}
    .action-btn{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;border:none;border-radius:16px;padding:16px 10px;font-weight:700;font-size:13px;cursor:pointer;text-decoration:none;transition:.15s;}
    .action-btn:hover{opacity:.9;text-decoration:none;}
    .btn-deposit{background:#22c55e;color:#fff;box-shadow:0 4px 14px rgba(34,197,94,.35);}
    .btn-withdraw{background:#ef4444;color:#fff;box-shadow:0 4px 14px rgba(239,68,68,.3);}
    .action-btn i{font-size:20px;}
    /* Stats */
    .stats-row{display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:14px;}
    .stat-box{background:#fff;border-radius:12px;padding:12px 8px;text-align:center;box-shadow:0 2px 6px rgba(0,0,0,.05);}
    .stat-box .val{font-size:14px;font-weight:800;}
    .stat-box .lbl{font-size:10px;color:#64748b;margin-top:2px;}
    /* Transaction list */
    .section-head{font-size:13px;font-weight:800;color:#1e293b;margin-bottom:10px;display:flex;justify-content:space-between;align-items:center;}
    .tx-item{background:#fff;border-radius:12px;padding:12px 14px;margin-bottom:8px;display:flex;align-items:center;gap:12px;box-shadow:0 1px 6px rgba(0,0,0,.05);}
    .tx-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;}
    .tx-icon.credit{background:#f0fdf4;color:#16a34a;}
    .tx-icon.debit{background:#fef2f2;color:#dc2626;}
    .tx-amount{font-size:15px;font-weight:800;}
    .tx-amount.credit{color:#16a34a;}
    .tx-amount.debit{color:#dc2626;}
    .tx-desc{font-size:12px;color:#334155;font-weight:600;}
    .tx-date{font-size:10px;color:#94a3b8;margin-top:1px;}
    .empty-tx{text-align:center;padding:24px;color:#94a3b8;}
    .empty-tx i{font-size:32px;display:block;margin-bottom:10px;}
    /* Quick links */
    .quick-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:14px;}
    .quick-item{display:flex;align-items:center;gap:10px;text-decoration:none;background:#fff;border-radius:12px;padding:12px;box-shadow:0 2px 6px rgba(0,0,0,.05);}
    .quick-item:hover{background:#f8faff;text-decoration:none;}
    .quick-item .qi-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;}
    .quick-item .qi-text{font-size:12px;font-weight:700;color:#334155;}
  </style>
</head>
<body>
<div class="app-layout">
  <div class="left-area">
    @include('components.topbar')
    <div class="home-content">

      {{-- HERO BALANCE CARD --}}
      <div class="wallet-hero">
        <div class="balance-label">Total Wallet Balance</div>
        <div class="balance-main">₹{{ number_format(($wallet->balance ?? 0) + ($wallet->bonus_balance ?? 0), 2) }}</div>
        <div class="balance-sub">Main + Bonus combined</div>
      </div>

      {{-- BALANCE BREAKDOWN --}}
      <div class="bal-breakdown">
        <div class="bal-card">
          <div class="label"><i class="fa fa-wallet me-1 text-primary"></i>Main Balance</div>
          <div class="value text-primary">₹{{ number_format($wallet->balance ?? 0, 2) }}</div>
          <div style="font-size:10px;color:#94a3b8;margin-top:2px">Withdrawable</div>
        </div>
        <div class="bal-card">
          <div class="label"><i class="fa fa-gift me-1 text-warning"></i>Bonus Balance</div>
          <div class="value text-warning">₹{{ number_format($wallet->bonus_balance ?? 0, 2) }}</div>
          <div style="font-size:10px;color:#94a3b8;margin-top:2px">Non-withdrawable</div>
        </div>
      </div>
      @if(($wallet->frozen_balance ?? 0) > 0)
      <div class="alert alert-warning py-2 mb-3" style="border-radius:12px;font-size:12px">
        <i class="fa fa-lock me-1"></i>
        <strong>₹{{ number_format($wallet->frozen_balance, 2) }}</strong> is currently frozen (pending withdrawal)
      </div>
      @endif

      {{-- ACTION BUTTONS --}}
      <div class="action-row">
        <a href="{{ route('deposit.funds') }}" class="action-btn btn-deposit">
          <i class="fa fa-plus-circle"></i>Add Money
        </a>
        <a href="{{ route('withdraw.funds') }}" class="action-btn btn-withdraw">
          <i class="fa fa-minus-circle"></i>Withdraw
        </a>
      </div>

      {{-- STATS --}}
      <div class="stats-row">
        <div class="stat-box">
          <div class="val text-success">₹{{ number_format($totalDeposit ?? 0, 0) }}</div>
          <div class="lbl">Total Deposited</div>
        </div>
        <div class="stat-box">
          <div class="val text-danger">₹{{ number_format($totalWithdraw ?? 0, 0) }}</div>
          <div class="lbl">Total Withdrawn</div>
        </div>
        <div class="stat-box">
          <div class="val text-primary">₹{{ number_format($todayProfit ?? 0, 0) }}</div>
          <div class="lbl">Today's Win</div>
        </div>
      </div>

      {{-- QUICK LINKS --}}
      <div class="section-head">Quick Access</div>
      <div class="quick-grid">
        <a href="{{ route('deposit.history') }}" class="quick-item">
          <div class="qi-icon" style="background:#eff6ff"><i class="fa fa-arrow-down text-primary"></i></div>
          <span class="qi-text">Deposit History</span>
        </a>
        <a href="{{ route('withdraw.history') }}" class="quick-item">
          <div class="qi-icon" style="background:#fef2f2"><i class="fa fa-arrow-up text-danger"></i></div>
          <span class="qi-text">Withdraw History</span>
        </a>
        <a href="{{ route('account.statement') }}" class="quick-item">
          <div class="qi-icon" style="background:#f0fdf4"><i class="fa fa-file-alt text-success"></i></div>
          <span class="qi-text">Account Statement</span>
        </a>
        <a href="{{ route('my.bids') }}" class="quick-item">
          <div class="qi-icon" style="background:#fffbeb"><i class="fa fa-receipt text-warning"></i></div>
          <span class="qi-text">My Bids</span>
        </a>
      </div>

      {{-- RECENT TRANSACTIONS --}}
      <div class="section-head">
        <span>Recent Transactions</span>
        <a href="{{ route('account.statement') }}" style="font-size:12px;color:#2563eb;font-weight:600;text-decoration:none">View All</a>
      </div>

      @forelse($transactions ?? [] as $tx)
      @php
        $isCredit = in_array($tx->type, ['credit','deposit','win','bonus','referral']);
        $icons = ['deposit'=>'fa-arrow-down','win'=>'fa-trophy','credit'=>'fa-plus','bonus'=>'fa-gift','withdraw'=>'fa-arrow-up','debit'=>'fa-minus','bet'=>'fa-dice'];
        $icon = $icons[$tx->source ?? $tx->type] ?? 'fa-exchange-alt';
      @endphp
      <div class="tx-item">
        <div class="tx-icon {{ $isCredit ? 'credit' : 'debit' }}"><i class="fa {{ $icon }}"></i></div>
        <div class="flex-grow-1">
          <div class="tx-desc">{{ ucfirst(str_replace('_',' ',$tx->source ?? $tx->type)) }}</div>
          <div class="tx-date">{{ \Carbon\Carbon::parse($tx->created_at)->format('d M Y • h:i A') }}</div>
        </div>
        <div class="tx-amount {{ $isCredit ? 'credit' : 'debit' }}">
          {{ $isCredit ? '+' : '-' }}₹{{ number_format(abs($tx->amount), 2) }}
        </div>
      </div>
      @empty
      <div class="empty-tx">
        <i class="fa fa-receipt"></i>
        <p style="font-size:13px">No transactions yet</p>
      </div>
      @endforelse

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
