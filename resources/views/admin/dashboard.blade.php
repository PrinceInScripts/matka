<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard | Admin</title>
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <style>
        .metric-card {
            padding: 20px;
            border-radius: 14px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .07)
        }

        .metric-icon {
            width: 48px;
            height: 48px;
            background: #5a6ff0;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px
        }

        .ank-card {
            background: #fff;
            border-radius: 12px;
            text-align: center;
            padding: 14px 8px 0;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .07);
            height: 100%
        }

        .ank-title {
            font-size: 12px;
            font-weight: 600;
            color: #4f5dff;
            margin-bottom: 4px
        }

        .ank-value {
            font-weight: 700;
            margin: 0;
            font-size: 1.5rem
        }

        .ank-sub {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 8px
        }

        .ank-footer {
            color: #fff;
            padding: 5px 0;
            border-radius: 0 0 12px 12px;
            font-size: 13px;
            font-weight: 600
        }

        .ank-0 .ank-footer {
            background: #5a6ff0
        }

        .ank-1 .ank-footer {
            background: #2ec27e
        }

        .ank-2 .ank-footer {
            background: #339af0
        }

        .ank-3 .ank-footer {
            background: #fab005
        }

        .ank-4 .ank-footer {
            background: #ae3ec9
        }

        .ank-5 .ank-footer {
            background: #f76707
        }

        .ank-6 .ank-footer {
            background: #e64980
        }

        .ank-7 .ank-footer {
            background: #4c6ef5
        }

        .ank-8 .ank-footer {
            background: #ff3b7f
        }

        .ank-9 .ank-footer {
            background: #20c997
        }

        .dashboard-header {
            background: #dfe6ff;
            padding: 20px 24px;
            border-radius: 14px 14px 0 0
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <x-admin-navbar />
        <x-admin-sidebar />
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    <!-- Top Row: Welcome + Stats -->
                    <div class="row mb-3">
                        <!-- Welcome Card -->
                        <div class="col-lg-5">
                            <div class="card border-0 shadow-sm h-100" style="border-radius:14px;overflow:hidden">
                                <div class="dashboard-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1 font-weight-bold text-primary">Welcome Back!</h5>
                                        <p class="mb-0 text-muted">{{ $loggedInAdmin->username ?? 'Admin' }}</p>
                                    </div>
                                    <i class="fas fa-user-shield fa-3x text-primary opacity-50"></i>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-4 border-right">
                                            <h3 class="font-weight-bold text-primary">{{ $totalUsers }}</h3>
                                            <p class="text-muted small mb-0">Total Users</p>
                                        </div>
                                        <div class="col-4 border-right">
                                            <h3 class="font-weight-bold text-success">{{ $approvedUsers }}</h3>
                                            <p class="text-muted small mb-0">Active</p>
                                        </div>
                                        <div class="col-4">
                                            <h3 class="font-weight-bold text-danger">{{ $totalUsers - $approvedUsers }}
                                            </h3>
                                            <p class="text-muted small mb-0">Inactive</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Metric Cards -->
                        <div class="col-lg-7">
                            <div class="row">
                                <div class="col-md-4 col-6 mb-3">
                                    <div class="card metric-card h-100">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-1 text-muted small">Total Games</p>
                                                <h4 class="font-weight-bold mb-0">{{ $totalGames }}</h4>
                                            </div>
                                            <div class="metric-icon"><i class="fas fa-gamepad"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6 mb-3">
                                    <div class="card metric-card h-100">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-1 text-muted small">24h Bids</p>
                                                <h4 class="font-weight-bold mb-0">
                                                    ₹{{ number_format($last24HourBidAmount, 0) }}</h4>
                                            </div>
                                            <div class="metric-icon" style="background:#2ec27e"><i
                                                    class="fas fa-rupee-sign"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6 mb-3">
                                    <div class="card metric-card h-100">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-1 text-muted small">Active Markets</p>
                                                <h4 class="font-weight-bold mb-0">{{ $games->count() }}</h4>
                                            </div>
                                            <div class="metric-icon" style="background:#f76707"><i
                                                    class="fas fa-store"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card shadow-sm border-0" style="border-radius:12px">
                                        <div class="card-body py-3">
                                            <h6 class="font-weight-bold mb-2">Single Ank Bids — <span
                                                    id="selectedGame">{{ optional($defaultMarket)->name ?? 'No Market' }}</span>
                                            </h6>
                                            <div class="row align-items-end">
                                                <div class="col-md-5">
                                                    <label class="small">Game</label>
                                                    <select id="ankGameId" class="form-control form-control-sm">
                                                        @foreach ($games as $g)
                                                            <option value="{{ $g->id }}"
                                                                {{ optional($defaultMarket)->id == $g->id ? 'selected' : '' }}>
                                                                {{ $g->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="small">Session</label>
                                                    <select id="ankSession" class="form-control form-control-sm">
                                                        <option value="open">Open</option>
                                                        <option value="close">Close</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <button id="btnLoadAnk"
                                                        class="btn btn-primary btn-sm btn-block">Get</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ank Cards Row -->
                    <div class="row mb-4">
                        @for ($i = 0; $i <= 9; $i++)
                            @php $ankRow = $ankData->get($i); @endphp
                            <div class="col-lg col-md-2 col-4 mb-3">
                                <div class="ank-card ank-{{ $i }}" id="ank-card-{{ $i }}">
                                    <p class="ank-title" id="ank-bids-{{ $i }}">
                                        {{ $ankRow ? $ankRow->total_bids : 0 }} Bids</p>
                                    <h3 class="ank-value" id="ank-amt-{{ $i }}">
                                        ₹{{ $ankRow ? number_format($ankRow->total_amount, 0) : 0 }}</h3>
                                    <p class="ank-sub">Amount</p>
                                    <div class="ank-footer">Ank {{ $i }}</div>
                                </div>
                            </div>
                        @endfor
                    </div>

                    <!-- Today's Market Summary -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="card-title"><i class="fas fa-store mr-2"></i>Today's Active Markets
                                    </h3>
                                    <span class="badge badge-success">{{ $games->count() }} Markets</span>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-sm table-hover mb-0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Market</th>
                                                <th>Open Time</th>
                                                <th>Close Time</th>
                                                <th>Today Bid Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($games as $g)
                                                <tr>
                                                    <td><strong>{{ $g->name }}</strong></td>
                                                    <td>{{ $g->today_open_time ?? 'N/A' }}</td>
                                                    <td>{{ $g->today_close_time ?? 'N/A' }}</td>
                                                    <td><strong
                                                            class="text-success">₹{{ number_format($g->today_bid_amount ?? 0, 0) }}</strong>
                                                    </td>
                                                    <td><span class="badge badge-success">Active</span></td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-3">No active
                                                        markets today</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Deposit Requests -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="card-title"><i class="fas fa-clock mr-2"></i>Recent Pending Deposits
                                    </h3>
                                    <a href="{{ route('admin.wallet.fund_request') }}"
                                        class="btn btn-sm btn-primary">View All</a>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table id="fundTable" class="table table-bordered table-striped table-sm mb-0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>User</th>
                                                <th>Amount</th>
                                                <th>Mode</th>
                                                <th>Txn ID</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pendingDepositBody">
                                            {{-- <tr><td colspan="7" class="text-center text-muted py-3">Loading...</td></tr> --}}
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center text-muted">Loading...</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
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

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            // Init datatable for fund requests
            var dt = $('#fundTable').DataTable({
                paging: false,
                searching: false,
                info: false,
                ordering: false
            });

            // Load pending deposits via AJAX
            $.get('{{ route('admin.wallet.fund_request') }}', function() {}).always(function() {});

            // Fetch pending deposits (load from deposits endpoint)
            loadPendingDeposits();

            function loadPendingDeposits() {
                // We'll just show a message to visit the fund request page since we don't have a dedicated API
                $('#pendingDepositBody').html(
                    '<tr><td colspan="7" class="text-center"><a href="{{ route('admin.wallet.fund_request') }}" class="btn btn-sm btn-warning"><i class="fas fa-eye mr-1"></i>View Pending Deposit Requests</a></td></tr>'
                    );
            }

            // Ank refresh
            $('#btnLoadAnk').on('click', function() {
                var gameId = $('#ankGameId').val();
                var session = $('#ankSession').val();
                var btn = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
                console.log('Fetching ank data for game_id=' + gameId + ', session=' + session);

                $.post('{{ route('admin.dashboard.ank') }}', {
                        game_id: gameId,
                        session: session
                    })
                    .done(function(r) {
                        if (r.status) {
                            $('#selectedGame').text(r.game_name);
                            for (var i = 0; i <= 9; i++) {
                                var d = r.ank_data[i] || {
                                    total_bids: 0,
                                    total_amount: 0
                                };
                                $('#ank-bids-' + i).text(d.total_bids + ' Bids');
                                $('#ank-amt-' + i).text('₹' + parseFloat(d.total_amount).toFixed(0));
                            }
                        }
                    })
                    .fail(function(xhr) {
                        console.log("Error:", xhr.responseText);
                        alert("Request failed. Check console.");
                    })
                    .always(function() {
                        btn.prop('disabled', false).html('Get');
                    });
            });
        });
    </script>
</body>

</html>
