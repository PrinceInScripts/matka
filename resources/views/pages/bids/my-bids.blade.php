<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>My Bids | Matka Play</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <style>
    .home-content{flex:1;overflow-y:auto;background:#f5f6fa;padding:64px 12px 100px;height:calc(100dvh - 56px);box-sizing:border-box;}
    .top-bar{position:fixed;top:0;width:100%;max-width:500px;display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid #eee;background:#fff;z-index:10;}
    .top-bar .back-btn{width:36px;height:36px;border-radius:50%;background:#2563eb;color:#fff;border:none;display:flex;align-items:center;justify-content:center;}
    /* Filter section */
    .filter-wrap{background:#fff;border-radius:14px;padding:12px;box-shadow:0 2px 8px rgba(0,0,0,.06);margin-bottom:14px;}
    .scroll-chips{display:flex;gap:8px;overflow-x:auto;padding-bottom:4px;scrollbar-width:none;}
    .scroll-chips::-webkit-scrollbar{display:none;}
    .chip{border:none;border-radius:20px;padding:6px 14px;font-size:12px;font-weight:600;white-space:nowrap;background:#f1f5f9;color:#64748b;transition:.15s;}
    .chip.active{background:#2563eb;color:#fff;}
    .divider{height:1px;background:#f1f5f9;margin:10px 0;}
    .adv-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:10px;}
    .adv-grid label{font-size:11px;color:#64748b;font-weight:600;margin-bottom:3px;display:block;}
    .adv-input{border:1.5px solid #e2e8f0;border-radius:10px;padding:7px 10px;font-size:13px;width:100%;outline:none;}
    .adv-input:focus{border-color:#2563eb;}
    /* Bid card */
    .bid-card{background:#fff;border-radius:14px;padding:14px;margin-bottom:12px;box-shadow:0 2px 10px rgba(0,0,0,.06);border-left:4px solid transparent;}
    .bid-card.status-won{border-left-color:#22c55e;}
    .bid-card.status-lost{border-left-color:#ef4444;}
    .bid-card.status-pending{border-left-color:#f59e0b;}
    .bid-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;}
    .bid-market{font-weight:700;font-size:14px;color:#2563eb;}
    .status-badge{padding:3px 12px;border-radius:20px;font-size:11px;font-weight:700;}
    .badge-won{background:#dcfce7;color:#16a34a;}
    .badge-lost{background:#fee2e2;color:#dc2626;}
    .badge-pending{background:#fef3c7;color:#d97706;}
    .bid-row{display:flex;justify-content:space-between;font-size:13px;margin-bottom:4px;align-items:center;}
    .bid-number{font-size:18px;font-weight:900;color:#1e40af;letter-spacing:1px;}
    .bid-amount{color:#2563eb;font-weight:700;}
    .win-amount{color:#16a34a;font-weight:800;font-size:15px;}
    .bid-foot{font-size:11px;color:#94a3b8;margin-top:8px;display:flex;gap:12px;}
    .empty-state{text-align:center;padding:40px 20px;color:#94a3b8;}
    .empty-state i{font-size:40px;display:block;margin-bottom:12px;color:#cbd5e1;}
    /* Summary strip */
    .summary-strip{display:flex;gap:8px;margin-bottom:12px;}
    .sum-box{flex:1;background:#fff;border-radius:12px;padding:10px 8px;text-align:center;box-shadow:0 2px 6px rgba(0,0,0,.06);}
    .sum-val{font-size:15px;font-weight:800;}
    .sum-lbl{font-size:10px;color:#64748b;margin-top:1px;}
  </style>
</head>
<body>
<div class="app-layout">
  <div class="left-area">
    <div class="top-bar">
      <button class="back-btn" onclick="history.back()"><i class="fa fa-angle-left"></i></button>
      <h6 class="m-0 fw-bold">My Bids</h6>
      @include('components.walletinfo')
    </div>
    <div class="home-content">

      <!-- FILTER CARD -->
      <div class="filter-wrap">
        <!-- Market tabs -->
        <div class="scroll-chips" id="marketChips">
          <button class="chip active" data-market="">All Markets</button>
          <button class="chip" data-market="main_market">Main Market</button>
          <button class="chip" data-market="starline">Starline</button>
          <button class="chip" data-market="gali_disawar">Gali Disawar</button>
        </div>
        <div class="divider"></div>
        <!-- Date range -->
        <div class="scroll-chips" id="dateChips">
          <button class="chip active" data-range="today">Today</button>
          <button class="chip" data-range="week">7 Days</button>
          <button class="chip" data-range="month">30 Days</button>
          <button class="chip" id="advBtn" data-range="">
            <i class="fa fa-sliders me-1"></i>Filter
          </button>
        </div>
        <!-- Advanced -->
        <div id="advPanel" style="display:none">
          <div class="adv-grid">
            <div>
              <label>Status</label>
              <select id="statusFilter" class="adv-input">
                <option value="">All</option>
                <option value="pending">Pending</option>
                <option value="won">Won</option>
                <option value="lost">Lost</option>
              </select>
            </div>
            <div>
              <label>From Date</label>
              <input type="date" id="dateFrom" class="adv-input">
            </div>
            <div>
              <label>To Date</label>
              <input type="date" id="dateTo" class="adv-input">
            </div>
            <div class="d-flex align-items-end gap-2">
              <button onclick="applyAdv()" class="btn btn-primary btn-sm w-100" style="border-radius:10px">Apply</button>
              <button onclick="resetAll()" class="btn btn-light btn-sm" style="border-radius:10px"><i class="fa fa-undo"></i></button>
            </div>
          </div>
        </div>
      </div>

      <!-- Summary -->
      <div class="summary-strip" id="summaryStrip" style="display:none">
        <div class="sum-box"><div class="sum-val text-primary" id="sumTotal">0</div><div class="sum-lbl">Bids</div></div>
        <div class="sum-box"><div class="sum-val text-danger" id="sumBet">₹0</div><div class="sum-lbl">Total Bet</div></div>
        <div class="sum-box"><div class="sum-val text-success" id="sumWin">₹0</div><div class="sum-lbl">Won</div></div>
      </div>

      <!-- Bid List -->
      <div id="bidList">
        @include('pages.bids.partials.bid-list', ['bids' => $bids])
      </div>
    </div>
    @include('components.bottombar')
  </div>
  @include('components.rightside')
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
$.ajaxSetup({headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});
var F={market:'',range:'today',status:'',date_from:'',date_to:''};

// Market chips
$('#marketChips .chip').click(function(){
  $('#marketChips .chip').removeClass('active');
  $(this).addClass('active');
  F.market=$(this).data('market');
  load(1);
});

// Date chips
$('#dateChips .chip[data-range]').not('#advBtn').click(function(){
  $('#dateChips .chip').removeClass('active');
  $(this).addClass('active');
  F.range=$(this).data('range');
  $('#advPanel').hide();
  load(1);
});

// Adv toggle
$('#advBtn').click(function(){
  $('#advPanel').slideToggle(150);
  $(this).toggleClass('active');
});

function applyAdv(){
  $('#dateChips .chip').removeClass('active');
  $('#advBtn').addClass('active');
  F.status=$('#statusFilter').val();
  F.date_from=$('#dateFrom').val();
  F.date_to=$('#dateTo').val();
  F.range='custom';
  load(1);
}

function resetAll(){
  F={market:'',range:'today',status:'',date_from:'',date_to:''};
  $('#marketChips .chip').removeClass('active');$('#marketChips .chip:first').addClass('active');
  $('#dateChips .chip').removeClass('active');$('#dateChips .chip[data-range="today"]').addClass('active');
  $('#statusFilter').val('');$('#dateFrom').val('');$('#dateTo').val('');
  $('#advPanel').hide();$('#advBtn').removeClass('active');
  load(1);
}

$(document).on('click','.pagination a',function(e){
  e.preventDefault();
  var pg=$(this).attr('href').split('page=')[1];
  load(pg);
});

function load(page){
  $('#bidList').html('<div style="text-align:center;padding:30px;color:#64748b"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
  $.ajax({url:'{{ route("my.bids") }}',method:'GET',
    data:{page:page,market:F.market,range:F.range,status:F.status,date_from:F.date_from,date_to:F.date_to},
    success:function(r){ $('#bidList').html(r.html); }
  });
}

load(1);
</script>
</body>
</html>
