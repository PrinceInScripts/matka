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
  <title>Starline Win History | {{ $siteName }} </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <style>
    .home-content{flex:1;overflow-y:auto;background:#f5f6fa;padding:70px 12px 100px;height:calc(100dvh - 56px);box-sizing:border-box;}
    .top-bar{position:fixed;top:0;width:100%;max-width:500px;display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid #eee;background:#fff;z-index:10;}
    .top-bar .back-btn{width:36px;height:36px;border-radius:50%;background:#2563eb;color:#fff;border:none;display:flex;align-items:center;justify-content:center;}
    .tab-row{display:flex;background:#fff;border-bottom:2px solid #f1f5f9;position:sticky;top:56px;z-index:9;}
    .tab-btn{flex:1;padding:12px;border:none;background:none;font-weight:600;font-size:13px;color:#64748b;border-bottom:3px solid transparent;}
    .tab-btn.active{color:#2563eb;border-bottom-color:#2563eb;}
    .bid-card{background:#fff;border-radius:14px;padding:14px;margin-bottom:12px;box-shadow:0 2px 10px rgba(0,0,0,.06);}
    .bid-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;}
    .game-name{font-weight:700;font-size:14px;color:#2563eb;}
    .status-badge{padding:3px 12px;border-radius:20px;font-size:11px;font-weight:700;}
    .status-won{background:#dcfce7;color:#16a34a;}
    .status-lost{background:#fee2e2;color:#dc2626;}
    .status-pending{background:#e0f2fe;color:#0284c7;}
    .bid-row{display:flex;justify-content:space-between;font-size:13px;margin-bottom:3px;}
    .bid-number{font-size:18px;font-weight:800;color:#1e40af;}
    .bid-amount{color:#2563eb;font-weight:700;}
    .win-amount{color:#16a34a;font-weight:800;font-size:16px;}
    .bid-foot{font-size:11px;color:#94a3b8;margin-top:6px;}
    .stats-row{display:flex;gap:10px;margin-bottom:14px;}
    .stat-box{flex:1;background:#fff;border-radius:12px;padding:10px;text-align:center;box-shadow:0 2px 6px rgba(0,0,0,.06);}
    .stat-val{font-size:16px;font-weight:800;}
    .stat-lbl{font-size:10px;color:#64748b;}
  </style>
</head>
<body>
<div class="app-layout">
  <div class="left-area">
    {{-- <div class="top-bar">
      <button class="back-btn" onclick="history.back()"><i class="fa fa-angle-left"></i></button>
      <h6 class="m-0 fw-bold">Galidisawar History</h6>
      @include('components.walletinfo')
    </div> --}}
     @include('components.topbar')
    <!-- Tab Switch -->
    {{-- <div class="tab-row" style="top:56px">
      <a href="{{ route('starline.win.history') }}" class="tab-btn active"><i class="fa fa-list me-1"></i>Win History</a>
      <a href="{{ route('starline.win.history') }}" class="tab-btn active"><i class="fa fa-trophy me-1"></i>Win History</a>
    </div> --}}
    <div class="home-content" style="padding-top:20px">
      @php
        $won = $bids->getCollection()->where('status','won');
        $totalBid = $bids->getCollection()->sum('amount');
        $totalWin = $won->sum('winning_amount');
      @endphp
      <div class="stats-row">
        <div class="stat-box"><div class="stat-val text-primary">{{ $bids->total() }}</div><div class="stat-lbl">Total Bids</div></div>
        <div class="stat-box"><div class="stat-val text-danger">₹{{ number_format($totalBid,0) }}</div><div class="stat-lbl">Total Bet</div></div>
        <div class="stat-box"><div class="stat-val text-success">₹{{ number_format($totalWin,0) }}</div><div class="stat-lbl">Total Won</div></div>
      </div>

      @forelse($bids as $b)
      <div class="bid-card">
        <div class="bid-header">
          <div class="game-name">{{ optional($b->starline)->name ?? 'Starline' }}</div>
          <span class="status-badge status-{{ $b->status }}">{{ ucfirst($b->status) }}</span>
        </div>
        <div class="bid-row"><span class="text-muted">Game Type</span><strong>{{ optional($b->gameType)->name ?? '—' }}</strong></div>
        <div class="bid-row"><span class="text-muted">Number</span><span class="bid-number">{{ $b->bet_value }}</span></div>
        <div class="bid-row"><span class="text-muted">Bet Amount</span><span class="bid-amount">₹{{ number_format($b->amount,2) }}</span></div>
        @if($b->status === 'won')
        <div class="bid-row"><span class="text-muted">Won Amount</span><span class="win-amount">₹{{ number_format($b->winning_amount,2) }}</span></div>
        @endif
        <div class="bid-foot"><i class="fa fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($b->bid_date ?? $b->created_at)->format('d M Y • h:i A') }}</div>
      </div>
      @empty
      <div style="text-align:center;padding:40px;color:#94a3b8"><i class="fa fa-inbox" style="font-size:40px;display:block;margin-bottom:12px"></i><p>No bids found</p></div>
      @endforelse

      <div class="d-flex justify-content-center mt-3">{{ $bids->links('pagination::bootstrap-5') }}</div>
    </div>
    @include('components.bottombar')
  </div>
  @include('components.rightside')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
