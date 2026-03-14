@php
  use App\Models\Setting;
  $siteName = Setting::get('site_name') ?? 'Matka Play';
  $siteLogo = Setting::get('site_logo');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $user->name }} | Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
          <div class="col-sm-6"><h1>User: {{ $user->name }}</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
              <li class="breadcrumb-item active">{{ $user->name }}</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div id="topMsg" class="alert d-none"></div>
        <div class="row">

          <!-- LEFT: Profile Card -->
          <div class="col-md-3">
            <div class="card card-primary card-outline">
              <div class="card-body text-center">
                <img src="../../dist/img/user1-128x128.jpg" class="img-circle img-fluid" style="width:80px">
                <h4 class="mt-2 mb-0">{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->phone }}</p>

                <div class="mt-3">
                  <h2 class="text-success font-weight-bold">₹{{ number_format($user->balance, 2) }}</h2>
                  <p class="text-muted mb-1">Available Balance</p>
                  @if($user->wallet && $user->wallet->frozen_balance > 0)
                  <small class="text-warning">Frozen: ₹{{ number_format($user->wallet->frozen_balance, 2) }}</small>
                  
                  @endif
                </br>
                  @if($user->wallet && $user->wallet->bonus_balance > 0)
                  <small class="text-primary">Frozen: ₹{{ number_format($user->wallet->bonus_balance, 2) }}</small>
                  
                  @endif
                </div>

                <div class="row mt-3 text-center">
                  <div class="col-6 border-right">
                    <strong>₹{{ number_format($totalBid, 0) }}</strong><br>
                    <small class="text-muted">Total Bets</small>
                  </div>
                  <div class="col-6">
                    <strong class="text-success">₹{{ number_format($totalWin, 0) }}</strong><br>
                    <small class="text-muted">Total Won</small>
                  </div>
                </div>

                <hr>

                <!-- Toggle Controls -->
                <div class="row mb-2">
                  <div class="col-4 text-center">
                    <button class="btn btn-sm btn-block {{ $user->status ? 'btn-success' : 'btn-secondary' }} btn-toggle-status"
                      data-id="{{ $user->id }}">
                      <i class="fas fa-{{ $user->status ? 'check' : 'ban' }}"></i>
                      <small>{{ $user->status ? 'Active' : 'Blocked' }}</small>
                    </button>
                  </div>
                  <div class="col-4 text-center">
                    <button class="btn btn-sm btn-block {{ $user->betting ? 'btn-success' : 'btn-secondary' }} btn-toggle-betting"
                      data-id="{{ $user->id }}">
                      <i class="fas fa-dice"></i>
                      <small>Bet {{ $user->betting ? 'On' : 'Off' }}</small>
                    </button>
                  </div>
                  <div class="col-4 text-center">
                    <button class="btn btn-sm btn-block {{ $user->transfer ? 'btn-success' : 'btn-secondary' }} btn-toggle-transfer"
                      data-id="{{ $user->id }}">
                      <i class="fas fa-exchange-alt"></i>
                      <small>TP {{ $user->transfer ? 'On' : 'Off' }}</small>
                    </button>
                  </div>
                </div>

                <button class="btn btn-success btn-block btn-sm mt-2" data-toggle="modal" data-target="#addBalModal">
                  <i class="fas fa-plus-circle mr-1"></i>Add Balance
                </button>
                <button class="btn btn-danger btn-block btn-sm mt-1" data-toggle="modal" data-target="#deductBalModal">
                  <i class="fas fa-minus-circle mr-1"></i>Deduct Balance
                </button>
              </div>
            </div>

            <!-- User Info Card -->
            <div class="card">
              <div class="card-header bg-secondary text-white"><h3 class="card-title">User Details</h3></div>
              <div class="card-body p-0">
                <table class="table table-sm mb-0">
                  <tr><th>Phone</th><td>{{ $user->phone }}</td></tr>
                  <tr><th>Email</th><td>{{ $user->email ?: 'N/A' }}</td></tr>
                  <tr><th>MPIN</th><td>{{ $user->plain_mpin ?: '—' }}</td></tr>
                  <tr><th>KYC</th><td><span class="badge badge-info">{{ ucfirst($user->kyc_status ?? 'N/A') }}</span></td></tr>
                  <tr><th>Joined</th><td>{{ $user->created_at->format('d M Y') }}</td></tr>
                  <tr><th>Last Login</th><td>{{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->format('d M Y') : 'N/A' }}</td></tr>
                </table>
              </div>
            </div>
          </div>

          <!-- RIGHT: Tabs -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-0">
                <ul class="nav nav-tabs" id="userTabs">
                  <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-bids">Bid History</a></li>
                  <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-deposits">Deposits</a></li>
                  <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-withdraws">Withdrawals</a></li>
                  <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-txns">Wallet Transactions</a></li>
                  <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-bonus">Bonus Transactions</a></li>
                </ul>
              </div>
              <div class="card-body tab-content">

                <!-- Bid History Tab -->
                <div id="tab-bids" class="tab-pane active">
                  <table class="table table-sm table-striped table-bordered">
                    <thead class="thead-dark">
                      <tr><th>#</th><th>Game</th><th>Type</th><th>Session</th><th>Amount</th><th>Status</th><th>Win Amt</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                      @forelse($recentBids as $b)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ optional($b->market)->name ?? '—' }}</td>
                        <td><small>{{ optional($b->gameType)->name ?? '—' }}</small></td>
                        <td>{{ ucfirst($b->session ?? '—') }}</td>
                        <td>₹{{ number_format($b->amount, 2) }}</td>
                        <td>
                          <span class="badge badge-{{ $b->status === 'won' ? 'success' : ($b->status === 'lost' ? 'danger' : 'warning') }}">
                            {{ ucfirst($b->status) }}
                          </span>
                        </td>
                        <td>{{ $b->winning_amount ? '₹'.number_format($b->winning_amount,2) : '—' }}</td>
                        <td><small>{{ $b->created_at->format('d M Y') }}</small></td>
                      </tr>
                      @empty
                      <tr><td colspan="8" class="text-center text-muted">No bids placed yet</td></tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>

                <!-- Deposits Tab -->
                <div id="tab-deposits" class="tab-pane">
                  <table class="table table-sm table-striped table-bordered">
                    <thead class="thead-dark">
                      <tr><th>#</th><th>Amount</th><th>Mode</th><th>Txn ID</th><th>Status</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                      @forelse($deposits as $d)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>₹{{ number_format($d->amount, 2) }}</strong></td>
                        <td>{{ strtoupper($d->payment_mode ?? 'UPI') }}</td>
                        <td><small>{{ $d->transaction_id ?? '—' }}</small></td>
                        <td><span class="badge badge-{{ $d->status === 'approved' ? 'success' : ($d->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($d->status) }}</span></td>
                        <td><small>{{ $d->created_at->format('d M Y') }}</small></td>
                      </tr>
                      @empty
                      <tr><td colspan="6" class="text-center text-muted">No deposit requests</td></tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>

                <!-- Withdrawals Tab -->
                <div id="tab-withdraws" class="tab-pane">
                  <table class="table table-sm table-striped table-bordered">
                    <thead class="thead-dark">
                      <tr><th>#</th><th>Amount</th><th>UPI ID</th><th>Status</th><th>Note</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                      @forelse($withdraws as $w)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>₹{{ number_format($w->amount, 2) }}</strong></td>
                        <td>{{ $w->upi_id ?? '—' }}</td>
                        <td><span class="badge badge-{{ $w->status === 'approved' ? 'success' : ($w->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($w->status) }}</span></td>
                        <td><small>{{ $w->admin_note ?? '—' }}</small></td>
                        <td><small>{{ $w->created_at->format('d M Y') }}</small></td>
                      </tr>
                      @empty
                      <tr><td colspan="6" class="text-center text-muted">No withdrawal requests</td></tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>

                <!-- Wallet Transactions Tab -->
                <div id="tab-txns" class="tab-pane">
                  <table class="table table-sm table-striped table-bordered">
                    <thead class="thead-dark">
                      <tr><th>#</th><th>Type</th><th>Source</th><th>Amount</th><th>Balance After</th><th>Reason</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                      @forelse($transactions as $t)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge badge-{{ $t->type === 'credit' ? 'success' : 'danger' }}">{{ strtoupper($t->type) }}</span></td>
                        <td><small>{{ $t->source ?? '—' }}</small></td>
                        <td><strong>₹{{ number_format($t->amount, 2) }}</strong></td>
                        <td>₹{{ number_format($t->balance_after ?? 0, 2) }}</td>
                        <td><small>{{ $t->reason ?? '—' }}</small></td>
                        <td><small>{{ $t->created_at->format('d M Y H:i') }}</small></td>
                      </tr>
                      @empty
                      <tr><td colspan="7" class="text-center text-muted">No transactions</td></tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
                <div id="tab-bonus" class="tab-pane">
                  <table class="table table-sm table-striped table-bordered">
                    <thead class="thead-dark">
                      <tr><th>#</th><th>Type</th><th>Source</th><th>Amount</th><th>Balance After</th><th>Reason</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                      @forelse($bonusTransaction as $t)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge badge-{{ $t->type === 'credit' ? 'success' : 'danger' }}">{{ strtoupper($t->type) }}</span></td>
                        <td><small>{{ $t->source ?? '—' }}</small></td>
                        <td><strong>₹{{ number_format($t->amount, 2) }}</strong></td>
                        <td>₹{{ number_format($t->balance_after ?? 0, 2) }}</td>
                        <td><small>{{ $t->reason ?? '—' }}</small></td>
                        <td><small>{{ $t->created_at->format('d M Y H:i') }}</small></td>
                      </tr>
                      @empty
                      <tr><td colspan="7" class="text-center text-muted">No transactions</td></tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>

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

<!-- Add Balance Modal -->
<div class="modal fade" id="addBalModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-success text-white"><h5 class="modal-title">Add Balance</h5>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Amount (₹)</label>
          <input type="number" id="addAmt" class="form-control" min="1" placeholder="Enter amount">
        </div>
        <div class="form-group">
          <label>Note</label>
          <input type="text" id="addNote" class="form-control" placeholder="Reason (optional)">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
        <button id="btnAddBal" class="btn btn-success btn-sm">Add Balance</button>
      </div>
    </div>
  </div>
</div>

<!-- Deduct Balance Modal -->
<div class="modal fade" id="deductBalModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white"><h5 class="modal-title">Deduct Balance</h5>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Amount (₹)</label>
          <input type="number" id="deductAmt" class="form-control" min="1" placeholder="Enter amount">
        </div>
        <div class="form-group">
          <label>Note</label>
          <input type="text" id="deductNote" class="form-control" placeholder="Reason (optional)">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
        <button id="btnDeductBal" class="btn btn-danger btn-sm">Deduct Balance</button>
      </div>
    </div>
  </div>
</div>

<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var userId = {{ $user->id }};

$(function () {
  // Toggle Status
  $('.btn-toggle-status').on('click', function () {
    $.post('/admin/user/'+userId+'/toggle-status',{})
      .done(function(r){ if(r.status) location.reload(); });
  });
  // Toggle Betting
  $('.btn-toggle-betting').on('click', function () {
    $.post('/admin/user/'+userId+'/toggle-betting',{})
      .done(function(r){ if(r.status) location.reload(); });
  });
  // Toggle Transfer
  $('.btn-toggle-transfer').on('click', function () {
    $.post('/admin/user/'+userId+'/toggle-transfer',{})
      .done(function(r){ if(r.status) location.reload(); });
  });

  // Add Balance
  $('#btnAddBal').on('click', function () {
    var amt=$('#addAmt').val();
    if(!amt||+amt<1){ alert('Enter a valid amount'); return; }
    $.post('/admin/user/'+userId+'/add-balance',{amount:amt,note:$('#addNote').val()})
      .done(function(r){ if(r.status){ $('#addBalModal').modal('hide'); showMsg(r.message,'success'); setTimeout(()=>location.reload(),1000); }})
      .fail(function(x){ alert(x.responseJSON?.message||'Error'); });
  });

  // Deduct Balance
  $('#btnDeductBal').on('click', function () {
    var amt=$('#deductAmt').val();
    if(!amt||+amt<1){ alert('Enter a valid amount'); return; }
    if(!confirm('Deduct ₹'+amt+' from this user?')) return;
    $.post('/admin/user/'+userId+'/deduct-balance',{amount:amt,note:$('#deductNote').val()})
      .done(function(r){ if(r.status){ $('#deductBalModal').modal('hide'); showMsg(r.message,'success'); setTimeout(()=>location.reload(),1000); }})
      .fail(function(x){ alert(x.responseJSON?.message||'Error'); });
  });

  function showMsg(msg,type){
    $('#topMsg').removeClass('d-none alert-success alert-danger').addClass('alert-'+type).text(msg);
    $('html,body').animate({scrollTop:0});
    setTimeout(()=>$('#topMsg').addClass('d-none'),4000);
  }
});
</script>
</body>
</html>
