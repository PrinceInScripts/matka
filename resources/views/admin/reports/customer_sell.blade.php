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
    <title>Customer Sell Report | Admin</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <x-admin-navbar /><x-admin-sidebar />
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Customer Sell Report</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">Customer Sell</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Filter by Date & Game</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Date <span class="text-danger">*</span></label>
                                    <input type="date" id="fDate" class="form-control"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-4">
                                    <label>Game</label>
                                    <select id="fGame" class="form-control">
                                        <option value="">All Games</option>
                                        @foreach ($games as $g)
                                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button id="btnFilter" class="btn btn-primary btn-block">
                                        <i class="fas fa-search mr-1"></i>Get Report
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2 d-none" id="summaryRow">
                        <div class="col-md-4">
                            <div class="info-box bg-info"><span class="info-box-icon"><i
                                        class="fas fa-rupee-sign"></i></span>
                                <div class="info-box-content"><span class="info-box-text">Total Sell</span>
                                    <span class="info-box-number" id="totalSell">₹0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-success"><span class="info-box-icon"><i
                                        class="fas fa-trophy"></i></span>
                                <div class="info-box-content"><span class="info-box-text">Total Win</span>
                                    <span class="info-box-number" id="totalWin">₹0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table id="sellTable" class="table table-hover table-striped table-sm">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Game Type</th>
                                        <th>Total Bids</th>
                                        <th>Total Amount</th>
                                        <th>Total Win</th>
                                    </tr>
                                </thead>
                                <tbody id="sellBody">
                                    {{-- <tr>
                                        <td colspan="5" class="text-center text-muted">Select date and click Get
                                            Report</td>
                                            <tr> --}}
<tr>
<td></td>
<td></td>
<td class="text-center text-muted">Select date and click Get
                                            Report</td>
<td></td>
<td></td>
</tr>
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
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../dist/js/adminlte.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function() {
            var dt = $('#sellTable').DataTable({
                responsive: true,
                autoWidth: false
            });
            $('#btnFilter').on('click', function() {
                var btn = $(this).prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin mr-1"></i>Loading...');
                $.post('{{ route('admin.reports.customer_sell.filter') }}', {
                        date: $('#fDate').val(),
                        game_id: $('#fGame').val()
                    })
                    .done(function(r) {
                        dt.clear();
                        if (!r.data || r.data.length === 0) {
                            dt.row.add(['—', 'No data for selected date', '', '', '']).draw();
                        } else {
                            var i = 1;
                            r.data.forEach(function(row) {
                                dt.row.add([i++, row.game_type, row.total_bids,
                                    '₹' + parseFloat(row.total_amount).toFixed(2),
                                    '<span class="text-success">₹' + parseFloat(row
                                        .total_win).toFixed(2) + '</span>'
                                ]);
                            });
                            dt.draw();
                            $('#totalSell').text('₹' + parseFloat(r.total_amount || 0).toFixed(2));
                            $('#totalWin').text('₹' + parseFloat(r.total_win || 0).toFixed(2));
                            $('#summaryRow').removeClass('d-none');
                        }
                    })
                    .fail(function() {
                        alert('Failed');
                    })
                    .always(function() {
                        btn.prop('disabled', false).html(
                        '<i class="fas fa-search mr-1"></i>Get Report');
                    });
            });
        });
    </script>
</body>

</html>
