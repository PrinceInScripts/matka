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
  <title>Starline Sell Report | Admin</title>
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <x-admin-navbar /><x-admin-sidebar />
  <div class="content-wrapper">
    <section class="content-header"><div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1>Starline Sell Report</h1></div>
        <div class="col-sm-6"><ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Starline › Sell Report</li>
        </ol></div>
      </div>
    </div></section>
    <section class="content"><div class="container-fluid">
<div class="card card-outline card-warning mb-3">
  <div class="card-header"><h3 class="card-title"><i class="fas fa-filter mr-2"></i>Filter Sell Report</h3></div>
  <div class="card-body"><div class="row">
    <div class="col-md-4"><label class="small">Date</label>
      <input type="date" id="fDate" class="form-control" value="{{ date('Y-m-d') }}"></div>
    <div class="col-md-4"><label class="small">Starline Game</label>
      <select id="fGame" class="form-control">
        <option value="">All Games</option>
        @foreach($games as $g)<option value="{{ $g->id }}">{{ $g->name }}</option>@endforeach
      </select></div>
    <div class="col-md-4 d-flex align-items-end">
      <button id="btnFilter" class="btn btn-warning btn-block"><i class="fas fa-chart-bar mr-1"></i>Get Sell Report</button>
    </div>
  </div></div>
</div><div class="row mb-3" id="sellSummary" style="display:none!important">
  <div class="col-md-4"><div class="info-box bg-info"><span class="info-box-icon"><i class="fas fa-list"></i></span>
    <div class="info-box-content"><span class="info-box-text">Total Bids</span>
    <span class="info-box-number" id="sTotal">0</span></div></div></div>
  <div class="col-md-4"><div class="info-box bg-danger"><span class="info-box-icon"><i class="fas fa-rupee-sign"></i></span>
    <div class="info-box-content"><span class="info-box-text">Total Sell</span>
    <span class="info-box-number" id="sSell">₹0</span></div></div></div>
  <div class="col-md-4"><div class="info-box bg-success"><span class="info-box-icon"><i class="fas fa-trophy"></i></span>
    <div class="info-box-content"><span class="info-box-text">Total Win</span>
    <span class="info-box-number" id="sWin">₹0</span></div></div></div>
</div><div class="card"><div class="card-body table-responsive p-0">
      <table id="slSellTable" class="table table-hover table-striped table-sm">
        <thead class="thead-dark"><tr><th>#</th><th>Game Type</th><th>Total Bids</th><th>Total Sell Amount</th><th>Total Win Amount</th><th>Net P&L</th></tr></thead>
        <tbody></tbody>
      </table></div></div>
    </div></section>
  </div>
  <footer class="main-footer"><strong>Matka Admin &copy; {{ date('Y') }}</strong></footer>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<script>
$.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
$(function(){
  var dt=$('#slSellTable').DataTable({responsive:true,autoWidth:false,buttons:['csv','excel','print']});
  dt.buttons().container().appendTo('#slSellTable_wrapper .col-md-6:eq(0)');
  $('#btnFilter').on('click',function(){
    var btn=$(this).prop('disabled',true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Loading...');
    $.post('{{ route("admin.starline.sell_report.filter") }}',{date:$('#fDate').val(), game_id:$('#fGame').val()})
    .done(function(r){
      dt.clear();
      if(r.data&&r.data.length){
        var i=1,ta=0,tw=0;
        r.data.forEach(function(d){
          ta+=parseFloat(d.total_amount||0); tw+=parseFloat(d.total_win||0);
          var pnl=parseFloat(d.total_amount||0)-parseFloat(d.total_win||0);
          var cls=pnl>=0?'text-success':'text-danger';
          dt.row.add([i++, d.game_type, d.total_bids,
            '₹'+parseFloat(d.total_amount||0).toFixed(2),
            '₹'+parseFloat(d.total_win||0).toFixed(2),
            '<span class="'+cls+' font-weight-bold">₹'+pnl.toFixed(2)+'</span>']);
        });
        dt.draw();
        $('#sTotal').text(r.total_bids||0);
        $('#sSell').text('₹'+ta.toFixed(2));
        $('#sWin').text('₹'+tw.toFixed(2));
        $('#sellSummary').show();
      } else {
        dt.row.add(['','No data for selected date/game','','','','']).draw();
      }
    })
    .fail(function(){alert('Request failed');})
    .always(function(){btn.prop('disabled',false).html('<i class="fas fa-chart-bar mr-1"></i>Get Sell Report');});
  });
});
</script>
</body></html>