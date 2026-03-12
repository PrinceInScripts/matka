<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Transaction Report | Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <x-admin-navbar />
  <x-admin-sidebar />
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1>Transaction / Wallet Report</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Transaction Report</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">

        <!-- Totals -->
        <div class="row mb-3">
          <div class="col-md-4">
            <div class="info-box bg-gradient-danger">
              <span class="info-box-icon"><i class="fas fa-arrow-circle-down"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Debit</span>
                <span class="info-box-number" id="totalDebit">₹{{ number_format($totalDebit, 2) }}</span>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="info-box bg-gradient-success">
              <span class="info-box-icon"><i class="fas fa-arrow-circle-up"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Credit</span>
                <span class="info-box-number" id="totalCredit">₹{{ number_format($totalCredit, 2) }}</span>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="info-box bg-gradient-info">
              <span class="info-box-icon"><i class="fas fa-list"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Transactions</span>
                <span class="info-box-number" id="totalCount">{{ $transactions->count() }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Filter Card -->
        <div class="card card-outline card-primary">
          <div class="card-header"><h3 class="card-title">Filter Transactions</h3></div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <label>Date</label>
                <input type="date" id="fDate" class="form-control" value="{{ date('Y-m-d') }}">
              </div>
              <div class="col-md-3">
                <label>Type</label>
                <select id="fType" class="form-control">
                  <option value="">All Types</option>
                  <option value="debit">Debit</option>
                  <option value="credit">Credit</option>
                </select>
              </div>
              <div class="col-md-3">
                <label>Source</label>
                <select id="fSource" class="form-control">
                  <option value="">All Sources</option>
                  <option value="bid">Main Market Bid</option>
                  <option value="starline_bid">Starline Bid</option>
                  <option value="gali_disawar_bid">Gali Disawar Bid</option>
                  <option value="deposit">Deposit</option>
                  <option value="withdraw">Withdraw</option>
                  <option value="win">Win</option>
                  <option value="admin_add">Admin Add</option>
                  <option value="admin_deduct">Admin Deduct</option>
                </select>
              </div>
              <div class="col-md-3 d-flex align-items-end">
                <button id="btnFilter" class="btn btn-primary btn-block">
                  <i class="fas fa-search mr-1"></i>Filter
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Table -->
        <div class="card">
          <div class="card-body table-responsive p-0">
            <table id="txnTable" class="table table-hover table-striped table-sm">
              <thead class="bg-dark text-white">
                <tr>
                  <th>#</th>
                  <th>User</th>
                  <th>Phone</th>
                  <th>Type</th>
                  <th>Source</th>
                  <th>Amount</th>
                  <th>Balance After</th>
                  <th>Reason</th>
                  <th>Txn Code</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody id="txnBody">
                @foreach($transactions as $t)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ optional(optional($t->wallet)->user)->name ?? '—' }}</td>
                  <td>{{ optional(optional($t->wallet)->user)->phone ?? '—' }}</td>
                  <td>
                    <span class="badge badge-{{ $t->type === 'credit' ? 'success' : 'danger' }}">
                      {{ strtoupper($t->type) }}
                    </span>
                  </td>
                  <td><small>{{ $t->source ?? '—' }}</small></td>
                  <td><strong>₹{{ number_format($t->amount, 2) }}</strong></td>
                  <td>₹{{ number_format($t->balance_after ?? 0, 2) }}</td>
                  <td><small>{{ $t->reason ?? '—' }}</small></td>
                  <td><small class="text-muted">{{ $t->transaction_code ?? '—' }}</small></td>
                  <td><small>{{ $t->created_at->format('d M Y, h:i A') }}</small></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  </div>
  <footer class="main-footer"><strong>Copyright &copy; Matka Admin.</strong></footer>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(function () {
  var dt = $('#txnTable').DataTable({
    responsive: true, autoWidth: false, order: [[9,'desc']],
    buttons: ['csv','excel','print'],
    columnDefs: [{ orderable: false, targets: [7,8] }]
  });
  dt.buttons().container().appendTo('#txnTable_wrapper .col-md-6:eq(0)');

  $('#btnFilter').on('click', function () {
    var btn = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Filtering...');
    $.post('{{ route("admin.wallet.bid_report.filter") }}', {
      date: $('#fDate').val(), type: $('#fType').val(), source: $('#fSource').val()
    })
    .done(function (r) {
      if (!r.status) return;
      dt.clear();
      var i = 1;
      r.data.forEach(function (t) {
        var typeBadge = '<span class="badge badge-'+(t.type==='credit'?'success':'danger')+'">'+t.type.toUpperCase()+'</span>';
        var user = (t.wallet && t.wallet.user) ? t.wallet.user : {};
        dt.row.add([
          i++, user.name||'—', user.phone||'—', typeBadge,
          '<small>'+(t.source||'—')+'</small>',
          '₹'+parseFloat(t.amount).toFixed(2),
          '₹'+parseFloat(t.balance_after||0).toFixed(2),
          '<small>'+(t.reason||'—')+'</small>',
          '<small class="text-muted">'+(t.transaction_code||'—')+'</small>',
          t.created_at
        ]);
      });
      dt.draw();
      $('#totalDebit').text('₹'+parseFloat(r.totals.total_debit||0).toFixed(2));
      $('#totalCredit').text('₹'+parseFloat(r.totals.total_credit||0).toFixed(2));
      $('#totalCount').text(r.data.length);
    })
    .fail(function () { alert('Filter failed'); })
    .always(function () { btn.prop('disabled',false).html('<i class="fas fa-search mr-1"></i>Filter'); });
  });
});
</script>
</body>
</html>
