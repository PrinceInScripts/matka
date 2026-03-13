<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Deposit History | MPL Matka</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <style>
    .home-content{flex:1;overflow-y:auto;background:#f5f6fa;padding:80px 15px 100px;height:calc(100dvh - 56px);box-sizing:border-box;}
    .top-bar{position:fixed;top:0;width:100%;max-width:500px;display:flex;align-items:center;justify-content:space-between;padding:15px 20px;border-bottom:1px solid #eee;background:#fff;z-index:10;}
    .top-bar .back-btn{width:36px;height:36px;border-radius:50%;background:#2563eb;color:#fff;border:none;display:flex;align-items:center;justify-content:center;}
    .txn-card{background:#fff;border-radius:14px;padding:14px 16px;margin-bottom:12px;box-shadow:0 2px 8px rgba(0,0,0,.06);border-left:4px solid #e2e8f0;}
    .txn-card.pending{border-left-color:#f59e0b;}
    .txn-card.approved{border-left-color:#22c55e;}
    .txn-card.rejected{border-left-color:#ef4444;}
    .txn-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;}
    .txn-amount{font-size:18px;font-weight:800;color:#2563eb;}
    .badge-pill{padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;}
    .badge-pending{background:#fef3c7;color:#d97706;}
    .badge-approved{background:#dcfce7;color:#16a34a;}
    .badge-rejected{background:#fee2e2;color:#dc2626;}
    .txn-meta{font-size:12px;color:#64748b;display:flex;flex-wrap:wrap;gap:12px;}
    .proof-thumb{width:48px;height:48px;border-radius:8px;object-fit:cover;cursor:pointer;border:2px solid #e2e8f0;}
    .stats-row{display:flex;gap:12px;margin-bottom:16px;}
    .stat-box{flex:1;background:#fff;border-radius:14px;padding:12px;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,.06);}
    .stat-box .val{font-size:18px;font-weight:800;}
    .stat-box .lbl{font-size:11px;color:#64748b;margin-top:2px;}
  </style>
</head>
<body>
<div class="app-layout">
  <div class="left-area">
    <div class="top-bar">
      <button class="back-btn" onclick="history.back()"><i class="fa fa-angle-left"></i></button>
      <h6 class="m-0 fw-bold">Deposit History</h6>
      @include('components.walletinfo')
    </div>
    <div class="home-content">
      @php
        $allDeps = $deposits->getCollection();
        $pending  = $allDeps->where('status','pending')->sum('amount');
        $approved = $allDeps->where('status','approved')->sum('amount');
        $rejected = $allDeps->where('status','rejected')->count();
      @endphp
      <div class="stats-row">
        <div class="stat-box"><div class="val text-success">₹{{ number_format($approved,0) }}</div><div class="lbl">Credited</div></div>
        <div class="stat-box"><div class="val text-warning">₹{{ number_format($pending,0) }}</div><div class="lbl">Pending</div></div>
        <div class="stat-box"><div class="val text-danger">{{ $rejected }}</div><div class="lbl">Rejected</div></div>
      </div>

      @forelse($deposits as $d)
      <div class="txn-card {{ $d->status }}">
        <div class="txn-top">
          <div class="txn-amount">+₹{{ number_format($d->amount,2) }}</div>
          <span class="badge-pill badge-{{ $d->status }}">{{ strtoupper($d->status) }}</span>
        </div>
        <div class="txn-meta">
          <span><i class="fa fa-calendar me-1"></i>{{ $d->created_at->format('d M Y, h:i A') }}</span>
          @if($d->transaction_id)<span><i class="fa fa-hashtag me-1"></i>{{ $d->transaction_id }}</span>@endif
          <span><i class="fa fa-credit-card me-1"></i>{{ strtoupper($d->payment_mode ?? 'Manual') }}</span>
        </div>
        @if($d->screenshot)
        <div class="mt-2 d-flex align-items-center gap-2">
          <img src="{{ asset('storage/'.$d->screenshot) }}" class="proof-thumb" onclick="viewProof('{{ asset('storage/'.$d->screenshot) }}')">
          <span style="font-size:11px;color:#64748b">Payment Screenshot</span>
        </div>
        @endif
        @if($d->admin_note)
        <div class="mt-2" style="font-size:12px;color:#ef4444"><i class="fa fa-info-circle me-1"></i>{{ $d->admin_note }}</div>
        @endif
      </div>
      @empty
      <div style="text-align:center;padding:40px;color:#94a3b8">
        <i class="fa fa-inbox" style="font-size:40px;display:block;margin-bottom:12px"></i>
        <p style="font-size:14px">No deposit requests yet</p>
        <a href="{{ route('deposit.funds') }}" style="color:#2563eb;font-weight:600;font-size:13px">Add Money →</a>
      </div>
      @endforelse

      {{ $deposits->links() }}
    </div>
    @include('components.bottombar')
  </div>
  @include('components.rightside')
</div>
<!-- Screenshot modal -->
<div id="proofModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:9999;display:flex;align-items:center;justify-content:center;" onclick="this.style.display='none'">
  <img id="proofImg" style="max-width:90vw;max-height:80vh;border-radius:12px">
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
function viewProof(src){ document.getElementById('proofImg').src=src; document.getElementById('proofModal').style.display='flex'; }
document.getElementById('proofModal').style.display='none';
</script>
</body>
</html>
