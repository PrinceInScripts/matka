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
    <title>Bid Win Report | Admin</title>
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
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Bid Win Report</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Bid Win</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">

                    <!-- Filter -->
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-filter mr-2"></i>Filter Winning Bids</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Date</label>
                                    <input type="date" id="fDate" class="form-control"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Game</label>
                                    <select id="fGame" class="form-control">
                                        <option value="">All Games</option>
                                        @foreach ($games as $g)
                                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Game Type</label>
                                    <select id="fType" class="form-control">
                                        <option value="">All Types</option>
                                        @foreach ($gameType as $t)
                                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button id="btnFilter" class="btn btn-success btn-block">
                                        <i class="fas fa-trophy mr-1"></i>Show Winners
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="info-box bg-success"><span class="info-box-icon"><i
                                        class="fas fa-trophy"></i></span>
                                <div class="info-box-content"><span class="info-box-text">Total Winners</span><span
                                        class="info-box-number" id="totalWinners">0</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-primary"><span class="info-box-icon"><i
                                        class="fas fa-rupee-sign"></i></span>
                                <div class="info-box-content"><span class="info-box-text">Total Win Amount</span><span
                                        class="info-box-number" id="totalWinAmt">₹0</span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-warning"><span class="info-box-icon"><i
                                        class="fas fa-percent"></i></span>
                                <div class="info-box-content"><span class="info-box-text">Avg Win Amount</span><span
                                        class="info-box-number" id="avgWinAmt">₹0</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table id="bidWinTable" class="table table-hover table-striped table-sm">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Phone</th>
                                        <th>Game</th>
                                        <th>Type</th>
                                        <th>Number</th>
                                        <th>Bet Amt</th>
                                        <th>Win Amt</th>
                                        <th>Session</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                       
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                             <td class="text-center text-muted py-3">Select date and click
                                            Show Winners</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </section>
        </div>
        <footer class="main-footer"><strong>Matka Admin</strong></footer>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function() {
            var dt = $('#bidWinTable').DataTable({
                responsive: true,
                autoWidth: false,
                buttons: ['csv', 'excel', 'print']
            });
            dt.buttons().container().appendTo('#bidWinTable_wrapper .col-md-6:eq(0)');

            $('#btnFilter').on('click', function() {
                var btn = $(this).prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin mr-1"></i>Loading...');
                $.post('{{ route('admin.reports.winning.filter') }}', {
                        date: $('#fDate').val(),
                        game_id: $('#fGame').val()
                    })
                    .done(function(r) {
                        dt.clear();
                        var totalWin = 0;
                        if (!r.data || !r.data.length) {
                            dt.row.add(['—', 'No winners for this date', '', '', '', '', '', '', '',
                                '']).draw();
                        } else {
                            var i = 1;
                            r.data.forEach(function(b) {
                                totalWin += parseFloat(b.winning_amount || 0);
                                dt.row.add([i++, b.user ? b.user.name : '—', b.user ? b.user
                                    .phone : '—',
                                    b.market ? b.market.name : '—', b.game_type ? b
                                    .game_type.name : '—',
                                    '<strong>' + b.number + '</strong>',
                                    '₹' + parseFloat(b.amount).toFixed(2),
                                    '<strong class="text-success">₹' + parseFloat(b
                                        .winning_amount || 0).toFixed(2) + '</strong>',
                                    ucfirst(b.session || '—'), b.created_at
                                ]);
                            });
                            dt.draw();
                            $('#totalWinners').text(r.data.length);
                            $('#totalWinAmt').text('₹' + totalWin.toFixed(2));
                            $('#avgWinAmt').text('₹' + (totalWin / r.data.length).toFixed(2));
                        }
                    })
                    .fail(function() {
                        alert('Failed');
                    })
                    .always(function() {
                        btn.prop('disabled', false).html(
                            '<i class="fas fa-trophy mr-1"></i>Show Winners');
                    });
            });

            function ucfirst(s) {
                return s ? s.charAt(0).toUpperCase() + s.slice(1) : s;
            }
        });
    </script>
</body>

</html>
