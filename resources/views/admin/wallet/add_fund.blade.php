<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Add Fund | Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
          <div class="col-sm-6"><h1>Add Fund to User</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Add Fund</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-7">
            <div class="card card-primary card-outline">
              <div class="card-header"><h3 class="card-title"><i class="fas fa-plus-circle mr-2"></i>Manually Add Fund</h3></div>
              <div class="card-body">
                <div class="form-group">
                  <label>Select User <span class="text-danger">*</span></label>
                  <select id="userId" class="form-control select2bs4" style="width:100%">
                    <option value="">— Select User —</option>
                    @foreach($users as $u)
                    <option value="{{ $u->id }}" data-balance="{{ $u->wallet->balance ?? 0 }}">
                      {{ $u->name }} — {{ $u->phone }}
                      (Bal: ₹{{ number_format($u->wallet->balance ?? 0, 2) }})
                    </option>
                    @endforeach
                  </select>
                </div>
                <div id="balanceDisplay" class="alert alert-info d-none">
                  Current Balance: <strong id="currentBal">₹0</strong>
                </div>
                <div class="form-group">
                  <label>Amount (₹) <span class="text-danger">*</span></label>
                  <input type="number" id="amount" class="form-control" placeholder="Enter amount" min="1" max="500000">
                </div>
                <div class="form-group">
<label>Fund Type</label>
<select id="fund_type" class="form-control">
<option value="deposit">Deposit (Real Money)</option>
<option value="bonus">Bonus</option>
<option value="correction">Balance Correction</option>
<option value="refund">Bet Refund</option>
</select>
</div>

<div class="form-group">
<label>Note / Reason</label>
<input type="text" id="note" class="form-control" placeholder="Optional note">
</div>
                <div id="alertMsg" class="alert d-none"></div>
              </div>
              <div class="card-footer">
                <button id="btnAdd" class="btn btn-success btn-block btn-lg">
                  <i class="fas fa-wallet mr-2"></i>Add Fund to Wallet
                </button>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="card">
              <div class="card-header bg-secondary text-white"><h3 class="card-title">Quick Actions</h3></div>
              <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <a href="{{ route('admin.wallet.fund_request') }}" class="text-primary">
                      <i class="fas fa-arrow-right mr-2"></i>View Deposit Requests
                    </a>
                  </li>
                  <li class="list-group-item">
                    <a href="{{ route('admin.wallet.withdraw_request') }}" class="text-primary">
                      <i class="fas fa-arrow-right mr-2"></i>View Withdrawal Requests
                    </a>
                  </li>
                  <li class="list-group-item">
                    <a href="{{ route('admin.users.index') }}" class="text-primary">
                      <i class="fas fa-arrow-right mr-2"></i>All Users
                    </a>
                  </li>
                </ul>
              </div>
            </div>
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
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(function () {
  $('.select2bs4').select2({ theme: 'bootstrap4' });

  $('#userId').on('change', function () {
    var opt = $(this).find(':selected');
    var bal = opt.data('balance');
    if ($(this).val()) {
      $('#balanceDisplay').removeClass('d-none');
      $('#currentBal').text('₹' + parseFloat(bal).toFixed(2));
    } else {
      $('#balanceDisplay').addClass('d-none');
    }
  });

  $('#btnAdd').on('click', function () {
    var uid    = $('#userId').val();
    var amount = $('#amount').val();
    var note = $('#note').val();
var fundType = $('#fund_type').val();
    if (!uid)           { showMsg('Please select a user.', 'danger'); return; }
    if (!amount || +amount < 1) { showMsg('Enter a valid amount (minimum ₹1).', 'danger'); return; }
    if (!confirm('Add ₹' + parseFloat(amount).toFixed(2) + ' to this user\'s wallet?')) return;

    $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Processing...');
    $.post('{{ route("admin.wallet.add_fund.store") }}', { user_id: uid, amount: amount, note: note,fund_type: fundType })
      .done(function (r) {
        if (r.status) {
          showMsg(r.message, 'success');
          $('#amount').val(''); $('#note').val(''); $('#userId').val(null).trigger('change');
          $('#balanceDisplay').addClass('d-none');
        }
      })
      .fail(function (x) { showMsg(x.responseJSON?.message || 'An error occurred.', 'danger'); })
      .always(function () { $('#btnAdd').prop('disabled',false).html('<i class="fas fa-wallet mr-2"></i>Add Fund to Wallet'); });
  });

  function showMsg(msg, type) {
    $('#alertMsg').removeClass('d-none alert-success alert-danger').addClass('alert-' + type).text(msg);
    setTimeout(function () { $('#alertMsg').addClass('d-none'); }, 5000);
  }
});
</script>
</body>
</html>
