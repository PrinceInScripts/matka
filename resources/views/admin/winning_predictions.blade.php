@php
  use App\Models\Setting;
  $siteName = Setting::get('site_name') ?? 'Matka Play';
  $siteLogo = Setting::get('site_logo');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Winning Predictions — Main Market | Admin</title>
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
  <style>
    .select2-container--bootstrap4 .select2-selection--single{height:calc(2.25rem + 2px);line-height:1.5;padding:.375rem .75rem;border:1px solid #ced4da;border-radius:.25rem;}
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow{height:100%;position:absolute;top:0;right:.75rem;width:20px;}
    .panna-digit-badge{display:inline-block;background:#343a40;color:#fff;border-radius:6px;padding:2px 10px;font-size:1.05rem;letter-spacing:2px;font-weight:700;}
    .result-card{border-left:4px solid #007bff;}
    .result-card.declared{border-left-color:#28a745;}
    .result-card.draft{border-left-color:#ffc107;}
    .step-circle{width:32px;height:32px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;}
    .winner-row{background:#f0fff4!important;}
    .loser-row{background:#fff5f5!important;}
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <x-admin-navbar /><x-admin-sidebar />
  <div class="content-wrapper">    <section class="content-header"><div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1><i class="fas fa-trophy mr-2 text-warning"></i>Winning Predictions</h1></div>
        <div class="col-sm-6"><ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item">Main Market</li><li class="breadcrumb-item active">Winning Predictions</li></ol></div>
      </div>
    </div></section>
    <section class="content"><div class="container-fluid">

<div class="card card-primary card-outline mb-3">
  <div class="card-header"><h3 class="card-title"><i class="fas fa-filter mr-2"></i>Search Predictions</h3></div>
  <div class="card-body">
    <div class="row align-items-end">
      <div class="col-md-2">
        <label class="font-weight-600 small">Date</label>
        <input type="date" id="pred_date" class="form-control" value="{{ date('Y-m-d') }}">
      </div>
      <div class="col-md-3">
        <label class="font-weight-600 small">Game</label>
        <select id="pred_game" class="form-control select2">
          <option value="">— Select Game —</option>
          @foreach($games as $g)
          <option value="{{ $g->id }}">{{ $g->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label class="font-weight-600 small">Session</label>
        <select id="pred_session" class="form-control select2">
          <option value="">All Sessions</option>
          <option value="open">Open</option>
          <option value="close">Close</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="font-weight-600 small">Open Panna</label>
        <select id="pred_open_panna" class="form-control select2" disabled>
          <option value="">— Panna —</option>
          @foreach($pannas as $p)<option value="{{ $p }}">{{ $p }}</option>@endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label class="font-weight-600 small">Close Panna</label>
        <select id="pred_close_panna" class="form-control select2" disabled>
          <option value="">— Panna —</option>
          @foreach($pannas as $p)<option value="{{ $p }}">{{ $p }}</option>@endforeach
        </select>
      </div>
      <div class="col-md-1">
        <button id="predGoBtn" class="btn btn-primary btn-block"><i class="fas fa-search"></i></button>
      </div>
    </div>
  </div>
</div>

<div class="row mb-3" id="predSummary" style="display:none!important">
  <div class="col-md-3"><div class="info-box bg-primary"><span class="info-box-icon"><i class="fas fa-list-ol"></i></span>
    <div class="info-box-content"><span class="info-box-text">Total Bids</span><span class="info-box-number" id="sPredCount">0</span></div></div></div>
  <div class="col-md-3"><div class="info-box bg-danger"><span class="info-box-icon"><i class="fas fa-rupee-sign"></i></span>
    <div class="info-box-content"><span class="info-box-text">Total Bid Amount</span><span class="info-box-number">₹<span id="sPredBid">0</span></span></div></div></div>
  <div class="col-md-3"><div class="info-box bg-success"><span class="info-box-icon"><i class="fas fa-trophy"></i></span>
    <div class="info-box-content"><span class="info-box-text">Total Win Amount</span><span class="info-box-number">₹<span id="sPredWin">0</span></span></div></div></div>
  <div class="col-md-3"><div class="info-box bg-warning"><span class="info-box-icon"><i class="fas fa-calculator"></i></span>
    <div class="info-box-content"><span class="info-box-text">Net P&L</span><span class="info-box-number" id="sPnl">₹0</span></div></div></div>
</div>

<div class="card">
  <div class="card-header d-flex justify-content-between">
    <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Prediction Results</h3>
    <small class="text-muted align-self-center">Select game and panna to see who might win</small>
  </div>
  <div class="card-body table-responsive p-0">
    <table id="predTable" class="table table-hover table-sm mb-0">
      <thead class="thead-dark">
        <tr><th>#</th><th>User</th><th>Phone</th><th>Game Type</th><th>Session</th><th>Bet Value</th><th>Bet Amount</th><th>Potential Win</th><th>Txn ID</th></tr>
      </thead>
      <tbody id="predTbody">
        <tr><td colspan="9" class="text-center py-4 text-muted"><i class="fas fa-search fa-2x d-block mb-2"></i>Select filters and click search to see predictions</td></tr>
      </tbody>
    </table>
  </div>
</div>
    </div></section>  </div>
  <footer class="main-footer"><strong>Matka Admin</strong> &copy; {{ date('Y') }}</footer>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){
  initSelect2();
  $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
});
function initSelect2(ctx){
  var scope = ctx ? $(ctx) : $('body');
  scope.find('.select2').select2({theme:'bootstrap4',width:'100%',allowClear:true});
}
$(document).on('shown.bs.modal',function(){
  $('.modal:visible .select2').select2({theme:'bootstrap4',width:'100%',dropdownParent:$('.modal:visible')});
});
</script>
<script>
$.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});

$('#pred_session').on('change',function(){
  var s=$(this).val();
  if(!s){ $('#pred_open_panna,#pred_close_panna').prop('disabled',true).val(null).trigger('change'); return; }
  if(s==='open'){ $('#pred_open_panna').prop('disabled',false); $('#pred_close_panna').prop('disabled',true).val(null).trigger('change'); }
  if(s==='close'){ $('#pred_close_panna').prop('disabled',false); $('#pred_open_panna').prop('disabled',true).val(null).trigger('change'); }
});

$('#predGoBtn').on('click',function(){
  if(!$('#pred_game').val()){ Swal.fire('Missing','Select a game first','warning'); return; }
  var btn=$(this).prop('disabled',true).html('<i class="fas fa-spinner fa-spin"></i>');
  $.get('/admin/result/winning-predictions/search',{
    date:$('#pred_date').val(), game_id:$('#pred_game').val(),
    session:$('#pred_session').val()||null,
    open_panna:$('#pred_open_panna').val()||null,
    close_panna:$('#pred_close_panna').val()||null
  }).done(function(res){
    var tbody=''; var i=1;
    if(!res.data||!res.data.length){
      tbody='<tr><td colspan="9" class="text-center py-4 text-muted"><i class="fas fa-inbox fa-2x d-block mb-2"></i>No matching bids found</td></tr>';
    } else {
      res.data.forEach(function(r){
        var gt=r.game_type?r.game_type.name:'—';
        var bv='';
        try{ var bd=typeof r.bet_data==='string'?JSON.parse(r.bet_data):r.bet_data; bv=bd.digit||bd.panna||bd.open_panna||'—'; }catch(e){}
        tbody+='<tr><td>'+i+'</td><td><strong>'+(r.user?r.user.name:'—')+'</strong></td><td><small>'+(r.user?r.user.phone:'—')+'</small></td><td><span class="badge badge-info">'+gt+'</span></td><td><span class="badge badge-'+(r.session==='open'?'primary':'warning')+'">'+r.session+'</span></td><td><strong>'+bv+'</strong></td><td>₹'+r.amount+'</td><td class="text-success font-weight-bold">₹'+(r.winning_amount||0)+'</td><td><small class="text-muted">'+(r.txn_id||'—')+'</small></td></tr>';
        i++;
      });
    }
    $('#predTbody').html(tbody);
    var tb=parseFloat(res.totals?res.totals.total_bid:0);
    var tw=parseFloat(res.totals?res.totals.total_win:0);
    $('#sPredCount').text(res.data?res.data.length:0);
    $('#sPredBid').text(tb.toFixed(2));
    $('#sPredWin').text(tw.toFixed(2));
    var pnl=tb-tw;
    $('#sPnl').html('₹'+pnl.toFixed(2)).closest('.info-box').removeClass('bg-warning bg-success bg-danger').addClass(pnl>=0?'bg-success':'bg-danger');
    $('#predSummary').show();
  }).fail(function(){ Swal.fire('Error','Failed to fetch predictions','error'); })
  .always(function(){ btn.prop('disabled',false).html('<i class="fas fa-search"></i>'); });
});
</script>
</body></html>