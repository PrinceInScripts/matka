<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Half Sangam | Admin</title>
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
        <div class="col-sm-6"><h1>Half Sangam</h1></div>
        <div class="col-sm-6"><ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Half Sangam</li>
        </ol></div>
      </div>
    </div></section>
    <section class="content"><div class="container-fluid">
<div class="callout callout-info mb-3">
      <h5><i class="fas fa-info-circle mr-2"></i>Half Sangam</h5>
      <p class="mb-0">Combination of Panna + Single Digit. Open panna + close digit OR open digit + close panna.</p>
    </div>
<div class="card card-outline card-primary mb-3">
  <div class="card-header"><h3 class="card-title"><i class="fas fa-filter mr-2"></i>Filter Bids</h3></div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-3"><label class="small">Date</label>
        <input type="date" id="fDate" class="form-control" value="{{ date('Y-m-d') }}"></div>
      <div class="col-md-3"><label class="small">Game</label>
        <select id="fGame" class="form-control">
          <option value="">All Games</option>
          @foreach($games as $g)<option value="{{ $g->id }}">{{ $g->name }}</option>@endforeach
        </select></div>
      <div class="col-md-3"><label class="small">Session</label>
        <select id="fSession" class="form-control">
          <option value="">All</option><option value="open">Open</option><option value="close">Close</option>
        </select></div>
      <div class="col-md-3 d-flex align-items-end">
        <button id="btnFilter" class="btn btn-primary btn-block"><i class="fas fa-search mr-1"></i>Filter</button>
      </div>
    </div>
  </div>
</div><div class="row mb-3">
  <div class="col-md-3"><div class="info-box bg-info"><span class="info-box-icon"><i class="fas fa-list"></i></span>
    <div class="info-box-content"><span class="info-box-text">Total Bids</span><span class="info-box-number" id="sTotalBids">{{ $bids->count() }}</span></div></div></div>
  <div class="col-md-3"><div class="info-box bg-danger"><span class="info-box-icon"><i class="fas fa-rupee-sign"></i></span>
    <div class="info-box-content"><span class="info-box-text">Total Amount</span><span class="info-box-number" id="sTotalAmt">₹{{ number_format($bids->sum('amount'),0) }}</span></div></div></div>
  <div class="col-md-3"><div class="info-box bg-success"><span class="info-box-icon"><i class="fas fa-trophy"></i></span>
    <div class="info-box-content"><span class="info-box-text">Total Win</span><span class="info-box-number" id="sTotalWin">₹{{ number_format($bids->where('status','won')->sum('winning_amount'),0) }}</span></div></div></div>
  <div class="col-md-3"><div class="info-box bg-warning"><span class="info-box-icon"><i class="fas fa-clock"></i></span>
    <div class="info-box-content"><span class="info-box-text">Pending</span><span class="info-box-number" id="sPending">{{ $bids->where('status','pending')->count() }}</span></div></div></div>
</div><div class="card"><div class="card-body table-responsive p-0">
      <table id="gnTable" class="table table-hover table-striped table-sm">
        <thead class="thead-dark"><tr><th>#</th><th>User</th><th>Phone</th><th>Game</th><th>Session</th><th>Number</th><th>Amount</th><th>Status</th><th>Win Amt</th><th>Date</th></tr></thead>
        <tbody>@forelse($bids as $b)
<tr>
  <td>{{ $loop->iteration }}</td>
  <td>{{ optional($b->user)->name ?? '—' }}</td>
  <td>{{ optional($b->user)->phone ?? '—' }}</td>
  <td>{{ optional($b->market)->name ?? '—' }}</td>
  <td>{{ ucfirst($b->session ?? '—') }}</td>
  <td><strong class="text-primary">{{ $b->number }}</strong></td>
  <td>₹{{ number_format($b->amount,2) }}</td>
  <td><span class="badge badge-{{ $b->status==='won'?'success':($b->status==='lost'?'danger':'warning') }}">{{ ucfirst($b->status) }}</span></td>
  <td>{{ $b->winning_amount ? '₹'.number_format($b->winning_amount,2) : '—' }}</td>
  <td><small>{{ $b->draw_date }}</small></td>
</tr>
@empty
<tr><td colspan="10" class="text-center py-3 text-muted">No bids. Use filter to search.</td></tr>
@endforelse</tbody>
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
  var dt=$('#gnTable').DataTable({responsive:true,autoWidth:false,order:[[9,'desc']],
    buttons:['csv','excel','print']});
  dt.buttons().container().appendTo('#gnTable_wrapper .col-md-6:eq(0)');

  $('#btnFilter').on('click',function(){
    var btn=$(this).prop('disabled',true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Loading...');
    $.post('{{ route("admin.reports.user_bid_history.filter") }}',{
      date:$('#fDate').val(), game_id:$('#fGame').val(),
      session:$('#fSession').val(), game_type_id: 12
    })
    .done(function(r){
      dt.clear();
      var ta=0,tw=0,tp=0;
      if(!r.data||!r.data.length){
        dt.row.add(['','No data found','','','','','','','','']).draw();
      } else {
        var i=1;
        r.data.forEach(function(b){
          ta+=parseFloat(b.amount||0); tw+=parseFloat(b.winning_amount||0);
          if(b.status==='pending') tp++;
          var st=b.status==='won'?'success':(b.status==='lost'?'danger':'warning');
          dt.row.add([i++,b.user?b.user.name:'—',b.user?b.user.phone:'—',
            b.market?b.market.name:'—', b.session||'—',
            '<strong class="text-primary">'+b.number+'</strong>',
            '₹'+parseFloat(b.amount).toFixed(2),
            '<span class="badge badge-'+st+'">'+b.status+'</span>',
            b.winning_amount?'₹'+parseFloat(b.winning_amount).toFixed(2):'—',
            b.draw_date
          ]);
        });
        dt.draw();
        $('#sTotalBids').text(r.data.length);
        $('#sTotalAmt').text('₹'+ta.toFixed(0));
        $('#sTotalWin').text('₹'+tw.toFixed(0));
        $('#sPending').text(tp);
      }
    })
    .fail(function(){alert('Request failed');})
    .always(function(){btn.prop('disabled',false).html('<i class="fas fa-search mr-1"></i>Filter');});
  });
});
</script>
</body></html>