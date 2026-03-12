<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Declare Result — Main Market | Admin</title>
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
        <div class="col-sm-6"><h1><i class="fas fa-trophy mr-2 text-warning"></i>Declare Result</h1></div>
        <div class="col-sm-6"><ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li><li class="breadcrumb-item">Main Market</li><li class="breadcrumb-item active">Declare Result</li></ol></div>
      </div>
    </div></section>
    <section class="content"><div class="container-fluid">

{{-- ── STEP 1: SELECT GAME ── --}}
<div class="card card-primary card-outline mb-3">
  <div class="card-header">
    <h3 class="card-title"><span class="step-circle bg-primary text-white mr-2">1</span>Select Game &amp; Session</h3>
  </div>
  <div class="card-body">
    <div class="row align-items-end">
      <div class="col-md-3">
        <label class="font-weight-600">Result Date</label>
        <input type="date" id="result_date" class="form-control" value="{{ date('Y-m-d') }}">
      </div>
      <div class="col-md-4">
        <label class="font-weight-600">Game Name</label>
        <select id="game_id" class="form-control select2">
          <option value="">— Select Game —</option>
          @foreach($games as $game)
          <option value="{{ $game->id }}">
            {{ $game->name }}
            @if($game->todaySchedule && $game->todaySchedule->open_time)
              ({{ \Carbon\Carbon::parse($game->todaySchedule->open_time)->format('h:i A') }}
               – {{ \Carbon\Carbon::parse($game->todaySchedule->close_time)->format('h:i A') }})
            @endif
          </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <label class="font-weight-600">Session</label>
        <select id="session" class="form-control select2">
          <option value="">— Select Session —</option>
          <option value="open">Open</option>
          <option value="close">Close</option>
        </select>
      </div>
      <div class="col-md-2">
        <button id="goBtn" class="btn btn-primary btn-block">
          <i class="fas fa-search mr-1"></i>Load
        </button>
      </div>
    </div>
  </div>
</div>

{{-- ── STEP 2: ENTER RESULT ── --}}
<div id="declareSection" class="d-none">
  <div class="card card-warning card-outline mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title"><span class="step-circle bg-warning text-dark mr-2">2</span>Enter Result Panna</h3>
      <div>
        <span id="resultStatusBadge" class="badge badge-secondary badge-pill px-3 py-2 mr-2" style="font-size:.85rem"></span>
        <span id="resultIdBadge" class="text-muted small"></span>
      </div>
    </div>
    <div class="card-body">
      <div class="row" id="openBlock">
        <div class="col-md-4">
          <label class="font-weight-600">Open Panna</label>
          <select id="open_panna" class="form-control select2">
            <option value="">— Select Panna —</option>
            @foreach($pannas as $p)<option value="{{ $p }}">{{ $p }}</option>@endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="font-weight-600">Open Digit <small class="text-muted">(auto)</small></label>
          <div class="input-group">
            <input type="text" id="open_digit" class="form-control font-weight-bold text-center bg-light" readonly style="font-size:1.3rem;letter-spacing:4px;">
            <div class="input-group-append"><span class="input-group-text"><i class="fas fa-lock text-muted"></i></span></div>
          </div>
        </div>
      </div>
      <div class="row mt-3" id="closeBlock">
        <div class="col-md-4">
          <label class="font-weight-600">Close Panna</label>
          <select id="close_panna" class="form-control select2">
            <option value="">— Select Panna —</option>
            @foreach($pannas as $p)<option value="{{ $p }}">{{ $p }}</option>@endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="font-weight-600">Close Digit <small class="text-muted">(auto)</small></label>
          <div class="input-group">
            <input type="text" id="close_digit" class="form-control font-weight-bold text-center bg-light" readonly style="font-size:1.3rem;letter-spacing:4px;">
            <div class="input-group-append"><span class="input-group-text"><i class="fas fa-lock text-muted"></i></span></div>
          </div>
        </div>
        <div class="col-md-5 d-flex align-items-end">
          <div class="callout callout-info mb-0 py-2 w-100" id="jodiPreview" style="display:none!important">
            <strong>Jodi Preview: </strong>
            <span class="panna-digit-badge" id="jodiValue">—</span>
          </div>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-12 d-flex" style="gap:10px">
          <button id="saveDraft" class="btn btn-success">
            <i class="fas fa-save mr-1"></i>Save Draft
          </button>
          <button id="showWinner" class="btn btn-info">
            <i class="fas fa-eye mr-1"></i>Preview Winners
          </button>
          <button id="declareResult" class="btn btn-danger">
            <i class="fas fa-gavel mr-1"></i>Declare &amp; Credit Wallets
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ── STEP 3: RESULT HISTORY ── --}}
<div class="card card-outline card-success">
  <div class="card-header"><h3 class="card-title"><span class="step-circle bg-success text-white mr-2">3</span>Recent Result History</h3></div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover table-sm mb-0">
      <thead class="thead-dark">
        <tr><th>#</th><th>Game</th><th>Date</th><th>Open Panna</th><th>Open Digit</th><th>Close Panna</th><th>Close Digit</th><th>Jodi</th><th>Status</th></tr>
      </thead>
      <tbody>
        @forelse($results as $i => $r)
        <tr class="{{ $r->status === 'declared' || $r->status === 'close_declared' ? 'table-success' : ($r->status === 'draft' ? 'table-warning' : '') }}">
          <td>{{ $i+1 }}</td>
          <td><strong>{{ optional($r->market)->name ?? '—' }}</strong></td>
          <td><small>{{ $r->result_date }}</small></td>
          <td><span class="panna-digit-badge" style="font-size:.8rem">{{ $r->open_panna ?? '—' }}</span></td>
          <td><strong>{{ $r->open_digit ?? '—' }}</strong></td>
          <td><span class="panna-digit-badge" style="font-size:.8rem">{{ $r->close_panna ?? '—' }}</span></td>
          <td><strong>{{ $r->close_digit ?? '—' }}</strong></td>
          <td>
            @if($r->open_digit !== null && $r->close_digit !== null)
            <span class="badge badge-dark px-2">{{ $r->open_digit }}{{ $r->close_digit }}</span>
            @else —
            @endif
          </td>
          <td>
            @php $sc = ['declared'=>'success','close_declared'=>'success','open_declared'=>'info','draft'=>'warning'][$r->status ?? ''] ?? 'secondary' @endphp
            <span class="badge badge-{{ $sc }}">{{ ucfirst(str_replace('_',' ',$r->status ?? '—')) }}</span>
          </td>
        </tr>
        @empty
        <tr><td colspan="9" class="text-center py-3 text-muted">No results declared yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- ── WINNER PREVIEW MODAL ── --}}
<div class="modal fade" id="winnerModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="fas fa-trophy text-warning mr-2"></i>Winner Preview</h5>
        <button class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body p-0">
        <div class="row no-gutters border-bottom bg-light py-2 px-3">
          <div class="col-md-3 text-center border-right py-2">
            <div class="text-muted small">Total Bids</div>
            <div class="h4 font-weight-bold text-primary mb-0" id="mTotalBids">—</div>
          </div>
          <div class="col-md-3 text-center border-right py-2">
            <div class="text-muted small">Total Bet Amount</div>
            <div class="h4 font-weight-bold text-danger mb-0">₹<span id="mTotalBid">—</span></div>
          </div>
          <div class="col-md-3 text-center border-right py-2">
            <div class="text-muted small">Total Win Payout</div>
            <div class="h4 font-weight-bold text-success mb-0">₹<span id="mTotalWin">—</span></div>
          </div>
          <div class="col-md-3 text-center py-2">
            <div class="text-muted small">Net P&L</div>
            <div class="h4 font-weight-bold mb-0" id="mNetPnl">—</div>
          </div>
        </div>
        <ul class="nav nav-tabs px-3 pt-2" id="winnerTabs">
          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#wWinners">
            <i class="fas fa-trophy text-success mr-1"></i>Winners <span class="badge badge-success" id="wWinnerCount">0</span>
          </a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#wLosers">
            <i class="fas fa-times-circle text-danger mr-1"></i>Losers <span class="badge badge-danger" id="wLoserCount">0</span>
          </a></li>
        </ul>
        <div class="tab-content p-3">
          <div class="tab-pane fade show active" id="wWinners">
            <div class="table-responsive">
              <table class="table table-sm table-bordered" id="tblWinners">
                <thead class="thead-dark"><tr><th>#</th><th>User</th><th>Game Type</th><th>Session</th><th>Bet Amt</th><th class="text-success">Win Amt</th><th>Time</th></tr></thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="wLosers">
            <div class="table-responsive">
              <table class="table table-sm table-bordered" id="tblLosers">
                <thead class="thead-dark"><tr><th>#</th><th>User</th><th>Game Type</th><th>Session</th><th>Bet Amt</th><th>Time</th></tr></thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button class="btn btn-danger" id="declareFromModal"><i class="fas fa-gavel mr-1"></i>Declare Now</button>
      </div>
    </div>
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
var resultId = null;

function calcDigit(p){ if(!p) return ''; var s=p.toString().split('').reduce(function(a,b){return a+parseInt(b)},0); return s%10; }

$('#open_panna').on('change',function(){ $('#open_digit').val(calcDigit($(this).val())||''); updateJodiPreview(); });
$('#close_panna').on('change',function(){ $('#close_digit').val(calcDigit($(this).val())||''); updateJodiPreview(); });

function updateJodiPreview(){
  var od=$('#open_digit').val(), cd=$('#close_digit').val();
  if(od!=='' && cd!==''){
    $('#jodiValue').text(od+''+cd);
    $('#jodiPreview').show();
  } else { $('#jodiPreview').hide(); }
}

$('#session').on('change',function(){ applySessionUI($(this).val()); });
$('#game_id').on('change',function(){ $('#declareSection').addClass('d-none'); resultId=null; });

function applySessionUI(s){
  if(!s){ $('#openBlock').show(); $('#closeBlock').show(); return; }
  if(s==='open'){ $('#openBlock').show(); $('#closeBlock').hide(); $('#close_panna').val('').trigger('change'); $('#close_digit').val(''); }
  if(s==='close'){ $('#openBlock').hide(); $('#openBlock').hide(); $('#closeBlock').show(); $('#open_panna').val('').trigger('change'); $('#open_digit').val(''); }
}

$('#goBtn').on('click',function(){
  if(!$('#game_id').val()){ Swal.fire('Missing','Select a game first','warning'); return; }
  var btn=$(this).prop('disabled',true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Loading...');
  $('#open_panna').val('').trigger('change'); $('#close_panna').val('').trigger('change');
  $('#open_digit').val(''); $('#close_digit').val(''); resultId=null;
  $.post('{{ route("admin.result.save_draft") }}'.replace('/save-draft','').replace('save-draft','context'),
    {game_id:$('#game_id').val(), result_date:$('#result_date').val(), session:$('#session').val()})
  .done(function(res){
    $('#declareSection').removeClass('d-none');
    applySessionUI($('#session').val());
    if(res && res.id){
      resultId=res.id;
      $('#open_panna').val(res.open_panna).trigger('change');
      $('#close_panna').val(res.close_panna).trigger('change');
      var sc={'declared':'success','close_declared':'success','open_declared':'info','draft':'warning'}[res.status]||'secondary';
      $('#resultStatusBadge').removeClass().addClass('badge badge-'+sc+' badge-pill px-3 py-2 mr-2').text((res.status||'').toUpperCase().replace('_',' '));
      $('#resultIdBadge').text('Result ID: #'+res.id);
    } else {
      $('#resultStatusBadge').removeClass().addClass('badge badge-secondary badge-pill px-3 py-2 mr-2').text('NEW');
      $('#resultIdBadge').text('');
    }
  })
  .fail(function(){ Swal.fire('Error','Failed to load context','error'); })
  .always(function(){ btn.prop('disabled',false).html('<i class="fas fa-search mr-1"></i>Load'); });
});

// Use correct context URL
$.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
$('#goBtn').off('click').on('click',function(){
  if(!$('#game_id').val()){ Swal.fire('Missing','Select a game first','warning'); return; }
  var btn=$(this).prop('disabled',true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Loading...');
  $('#open_panna').val(null).trigger('change'); $('#close_panna').val(null).trigger('change');
  $('#open_digit').val(''); $('#close_digit').val(''); resultId=null;
  $.ajax({url:'/admin/result/context', type:'POST',
    data:{game_id:$('#game_id').val(), result_date:$('#result_date').val(), session:$('#session').val()}
  }).done(function(res){
    $('#declareSection').removeClass('d-none'); applySessionUI($('#session').val());
    if(res && res.id){
      resultId=res.id;
      if(res.open_panna) $('#open_panna').val(res.open_panna).trigger('change');
      if(res.close_panna) $('#close_panna').val(res.close_panna).trigger('change');
      var sc={'declared':'success','close_declared':'success','open_declared':'info','draft':'warning'}[res.status]||'secondary';
      $('#resultStatusBadge').removeClass().addClass('badge badge-'+sc+' badge-pill px-3 py-2 mr-2').text((res.status||'new').toUpperCase().replace(/_/g,' '));
      $('#resultIdBadge').text('Result #'+res.id);
    } else {
      $('#resultStatusBadge').removeClass().addClass('badge badge-secondary badge-pill px-3 py-2 mr-2').text('NEW');
    }
  }).fail(function(){ Swal.fire('Error','Failed to load game context','error'); })
  .always(function(){ btn.prop('disabled',false).html('<i class="fas fa-search mr-1"></i>Load'); });
});

$('#saveDraft').on('click',function(){
  var btn=$(this).prop('disabled',true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Saving...');
  $.ajax({url:'/admin/result/save-draft', type:'POST',
    data:{result_id:resultId, market_id:$('#game_id').val(), session:$('#session').val(),
      result_date:$('#result_date').val(), open_panna:$('#open_panna').val(),
      open_digit:$('#open_digit').val(), close_panna:$('#close_panna').val(), close_digit:$('#close_digit').val()}
  }).done(function(res){
    resultId=res.id;
    $('#resultStatusBadge').removeClass().addClass('badge badge-warning badge-pill px-3 py-2 mr-2').text('DRAFT');
    $('#resultIdBadge').text('Result #'+res.id);
    Swal.fire({icon:'success',title:'Saved',text:'Result saved as draft',timer:1500,showConfirmButton:false});
  }).fail(function(){ Swal.fire('Error','Failed to save','error'); })
  .always(function(){ btn.prop('disabled',false).html('<i class="fas fa-save mr-1"></i>Save Draft'); });
});

function loadWinners(onSuccess){
  if(!resultId){ Swal.fire('No Result','Save the result first','warning'); return; }
  Swal.fire({title:'Calculating winners…',allowOutsideClick:false,didOpen:()=>Swal.showLoading()});
  $.get('/admin/result/winners/'+resultId).done(function(res){
    Swal.close();
    var wt=$('#tblWinners tbody').empty();
    var lt=$('#tblLosers tbody').empty();
    var tb=$('#mTotalBid').text(parseFloat(res.total_bid||0).toFixed(2));
    var tw=$('#mTotalWin').text(parseFloat(res.total_win||0).toFixed(2));
    var pnl=parseFloat(res.total_bid||0)-parseFloat(res.total_win||0);
    $('#mTotalBids').text((res.winners||[]).length+(res.losers||[]).length);
    $('#mNetPnl').html('<span class="'+(pnl>=0?'text-success':'text-danger')+'">₹'+pnl.toFixed(2)+'</span>');
    $('#wWinnerCount').text((res.winners||[]).length);
    $('#wLoserCount').text((res.losers||[]).length);
    var i=1;
    (res.winners||[]).forEach(function(w){
      wt.append('<tr class="winner-row"><td>'+i+'</td><td><strong>'+w.name+'</strong></td><td><span class="badge badge-info">'+w.game_type+'</span></td><td><span class="badge badge-'+(w.session==='open'?'primary':'warning')+'">'+w.session+'</span></td><td>₹'+w.amount+'</td><td class="text-success font-weight-bold">₹'+w.winning_amount+'</td><td><small>'+w.bid_time+'</small></td></tr>');
      i++;
    });
    if(!res.winners||!res.winners.length) wt.append('<tr><td colspan="7" class="text-center text-muted py-3"><i class="fas fa-info-circle mr-1"></i>No winners for this result</td></tr>');
    i=1;
    (res.losers||[]).forEach(function(l){
      lt.append('<tr class="loser-row"><td>'+i+'</td><td>'+l.name+'</td><td><span class="badge badge-secondary">'+l.game_type+'</span></td><td><span class="badge badge-'+(l.session==='open'?'primary':'warning')+'">'+l.session+'</span></td><td class="text-danger">₹'+l.amount+'</td><td><small>'+l.bid_time+'</small></td></tr>');
      i++;
    });
    if(!res.losers||!res.losers.length) lt.append('<tr><td colspan="6" class="text-center text-muted py-3">No losers</td></tr>');
    if(onSuccess) onSuccess();
    else $('#winnerModal').modal('show');
  }).fail(function(){ Swal.fire('Error','Failed to fetch winners','error'); });
}

$('#showWinner').on('click',function(){ loadWinners(function(){ $('#winnerModal').modal('show'); }); });

function doDeclare(){
  if(!resultId){ Swal.fire('No Result','Save the result as draft first','warning'); return; }
  Swal.fire({title:'Are you sure?',html:'<b>This will credit winning amounts to all winners wallets</b><br>and lock the result permanently.',icon:'warning',showCancelButton:true,confirmButtonColor:'#dc3545',cancelButtonColor:'#6c757d',confirmButtonText:'<i class="fas fa-gavel mr-1"></i>Yes, Declare!'})
  .then(function(r){ if(!r.isConfirmed) return;
    Swal.fire({title:'Declaring…',allowOutsideClick:false,didOpen:()=>Swal.showLoading()});
    $.ajax({url:'/admin/result/declare',type:'POST',data:{result_id:resultId}})
    .done(function(){ Swal.fire({icon:'success',title:'Declared!',text:'Result declared and wallets credited',confirmButtonText:'Reload'}).then(()=>location.reload()); })
    .fail(function(xhr){
      var msg='Declaration failed';
      try{msg=xhr.responseJSON.message||msg;}catch(e){}
      Swal.fire('Error',msg,'error');
    });
  });
}
$('#declareResult').on('click',doDeclare);
$('#declareFromModal').on('click',function(){ $('#winnerModal').modal('hide'); doDeclare(); });
</script>
</body></html>