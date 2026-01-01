<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">

    <style>
        /* General spacing improvement */
        .card {
            background: #fff;
        }

        /* LEFT DASHBOARD CARD */
        .dashboard-card {
            border-radius: 14px;
            overflow: hidden;
        }

        .dashboard-header {
            background: #dfe6ff;
            padding: 22px 24px;
        }

        .dashboard-card .card-body {
            padding: 24px;
        }

        /* Profile section breathing room */
        .profile-img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        /* Stats spacing */
        .dashboard-card .col-md-8 .row>div {
            padding-top: 10px;
        }

        /* METRIC CARDS */
        .metric-card {
            padding: 22px;
            border-radius: 14px;
            border: none;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        }

        .metric-card p {
            font-size: 14px;
        }

        .metric-card h4 {
            margin-top: 4px;
        }

        /* Metric icon */
        .metric-icon {
            width: 50px;
            height: 50px;
            background: #5a6ff0;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        /* TOTAL BIDS CARD */
        .total-bid-card {
            border-radius: 14px;
            margin-top: 6px;
        }

        .total-bid-card .card-body {
            padding: 24px;
        }

        .total-bid-card h6 {
            margin-bottom: 18px;
        }

        /* Form spacing */
        .total-bid-card .form-label {
            font-weight: 500;
            margin-bottom: 6px;
        }

        .total-bid-card .form-select {
            height: 44px;
        }

        .total-bid-card .btn {
            height: 44px;
            margin-top: 2px;
        }

        /* MARKET CARD */
        .market-card {
            border-radius: 14px;
        }

        .market-card .card-body {
            padding: 24px;
        }

        /* ANK CARDS */
        .ank-card {
            background: #fff;
            border-radius: 12px;
            text-align: center;
            padding: 16px 10px 0;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
            height: 100%;
        }

        .ank-title {
            font-size: 13px;
            font-weight: 600;
            color: #4f5dff;
            margin-bottom: 6px;
        }

        .ank-value {
            font-weight: 700;
            margin: 0;
        }

        .ank-sub {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .ank-footer {
            color: #fff;
            padding: 6px 0;
            border-radius: 0 0 12px 12px;
            font-size: 14px;
            font-weight: 600;
        }

        /* Footer colors (subtle, not loud) */
        .ank-0 .ank-footer {
            background: #5a6ff0;
        }

        .ank-1 .ank-footer {
            background: #2ec27e;
        }

        .ank-2 .ank-footer {
            background: #339af0;
        }

        .ank-3 .ank-footer {
            background: #fab005;
        }

        .ank-4 .ank-footer {
            background: #ae3ec9;
        }

        .ank-5 .ank-footer {
            background: #f76707;
        }

        .ank-6 .ank-footer {
            background: #e64980;
        }

        .ank-7 .ank-footer {
            background: #4c6ef5;
        }

        .ank-8 .ank-footer {
            background: #ff3b7f;
        }

        .ank-9 .ank-footer {
            background: #20c997;
        }

        /* 5 cards per row system */
.ank-row {
  display: flex;
  flex-wrap: wrap;
}

.ank-col {
  width: 20%;
  padding: 0.75rem;
}

/* Responsive fallback */
@media (max-width: 992px) {
  .ank-col { width: 33.333%; }
}

@media (max-width: 576px) {
  .ank-col { width: 50%; }
}

    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        <x-admin-navbar />
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <x-admin-sidebar />

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row g-3">

                        <!-- LEFT DASHBOARD CARD -->
                        <div class="col-lg-6 col-12">
                            <div class="card shadow-sm border-0 dashboard-card h-100">

                                <div class="dashboard-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1 fw-bold text-primary">Welcome Back !</h5>
                                        <p class="mb-0 text-muted">Admin Dashboard</p>
                                    </div>
                                    <img src="https://cdn-icons-png.flaticon.com/128/3648/3648264.png"
                                        class="header-illustration" alt="">
                                </div>

                                <div class="card-body">
                                    <div class="row align-items-center">

                                        <div class="col-md-4 text-center text-md-start">
                                            <img src="https://cdn-icons-png.flaticon.com/128/3135/3135715.png"
                                                class="rounded-circle profile-img mb-2" alt="">
                                            <h6 class="mb-0 fw-bold">{{ $loggedInAdmin->username }}</h6>
                                            <small class="text-muted">Admin</small>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <h4 class="fw-bold mb-1">{{ $totalUsers-$approvedUsers }}</h4>
                                                    <p class="text-muted mb-0">Unapproved<br>Users</p>
                                                </div>
                                                <div class="col-6">
                                                    <h4 class="fw-bold mb-1">{{ $approvedUsers }}</h4>
                                                    <p class="text-muted mb-0">Approved<br>Users</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- RIGHT METRIC CARDS -->
                        <!-- RIGHT SIDE -->
                        <div class="col-lg-6 col-12">
                            <div class="row g-3">

                                <!-- METRIC CARDS -->
                                <div class="col-md-4 col-12">
                                    <div class="card metric-card h-100">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-1 text-muted">Users</p>
                                                <h4 class="fw-bold mb-0">{{ $totalUsers }}</h4>
                                            </div>
                                            <div class="metric-icon"><i class="fas fa-user"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="card metric-card h-100">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-1 text-muted">Games</p>
                                                <h4 class="fw-bold mb-0">{{ $totalGames }}</h4>
                                            </div>
                                            <div class="metric-icon"><i class="fas fa-gamepad"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="card metric-card h-100">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-1 text-muted">Bid Amount</p>
                                                <h4 class="fw-bold mb-0">{{ $last24HourBidAmount }}</h4>
                                            </div>
                                            <div class="metric-icon"><i class="fas fa-tag"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ✅ TOTAL BIDS BLOCK (MISSING ONE) -->
                                <div class="col-12 ml-2">
                                    <div class="card border-0 shadow-sm total-bid-card">
                                        <div class="card-body">

                                            <h6 class="fw-bold mb-3">
                                                Total Bids On Single Ank Of Date 25 Dec 2025
                                            </h6>

                                            <div class="row align-items-end g-3">

                                                <div class="col-md-5 col-12">
                                                    <label class="form-label">Game Name</label>
                                                    <select class="form-select">
                                                        <option>
                                                            MADHUR NIGHT (08:25 PM - 10:20 PM)
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-md-4 col-12">
                                                    <label class="form-label">Market Time</label>
                                                    <select class="form-select">
                                                        <option>Close Market</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3 col-12">
                                                    <button class="btn btn-primary w-100">
                                                        Get
                                                    </button>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>

                    <!-- ================= MARKET BID DETAILS ROW ================= -->
                    <div class="row g-4 mt-2">

                        <!-- LEFT: MARKET BID DETAILS -->
                        <div class="col-lg-4 col-12">
                            <div class="card shadow-sm border-0 market-card h-100">
                                <div class="card-body">

                                    <h6 class="fw-bold mb-4">Market Bid Details</h6>

                                    <div class="mb-3">
                                        <label class="form-label">Game Name</label>
                                        <select class="form-select">
                                            <option selected disabled>- Select Game Name -</option>
                                        </select>
                                    </div>

                                    <div class="mt-4">
                                        <h4 class="fw-bold mb-1">N/A</h4>
                                        <p class="text-muted mb-0">Market Amount</p>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- RIGHT: ANK CARDS -->
                        <!-- RIGHT: ANK CARDS -->
                        <div class="col-lg-8 col-12">
                            <div class="row g-3 ank-row">

                                <!-- Ank 0 -->
                                <div class="ank-col">
                                    <div class="ank-card ank-0">
                                        <p class="ank-title">Total Bids 0</p>
                                        <h3 class="ank-value">0</h3>
                                        <p class="ank-sub">Total Bid Amount</p>
                                        <div class="ank-footer">Ank 0</div>
                                    </div>
                                </div>

                                <!-- Ank 1 -->
                                <div class="ank-col">
                                    <div class="ank-card ank-1">
                                        <p class="ank-title">Total Bids 0</p>
                                        <h3 class="ank-value">0</h3>
                                        <p class="ank-sub">Total Bid Amount</p>
                                        <div class="ank-footer">Ank 1</div>
                                    </div>
                                </div>

                                <!-- Ank 2 -->
                                <div class="ank-col">
                                    <div class="ank-card ank-2">
                                        <p class="ank-title">Total Bids 0</p>
                                        <h3 class="ank-value">0</h3>
                                        <p class="ank-sub">Total Bid Amount</p>
                                        <div class="ank-footer">Ank 2</div>
                                    </div>
                                </div>

                                <!-- Ank 3 -->
                                <div class="ank-col">
                                    <div class="ank-card ank-3">
                                        <p class="ank-title">Total Bids 0</p>
                                        <h3 class="ank-value">0</h3>
                                        <p class="ank-sub">Total Bid Amount</p>
                                        <div class="ank-footer">Ank 3</div>
                                    </div>
                                </div>

                                <!-- Ank 4 -->
                                <div class="ank-col">
                                    <div class="ank-card ank-4">
                                        <p class="ank-title">Total Bids 0</p>
                                        <h3 class="ank-value">0</h3>
                                        <p class="ank-sub">Total Bid Amount</p>
                                        <div class="ank-footer">Ank 4</div>
                                    </div>
                                </div>

                                <!-- Ank 5 -->
                                <div class="ank-col">
                                    <div class="ank-card ank-5">
                                        <p class="ank-title">Total Bids 0</p>
                                        <h3 class="ank-value">0</h3>
                                        <p class="ank-sub">Total Bid Amount</p>
                                        <div class="ank-footer">Ank 5</div>
                                    </div>
                                </div>

                                <!-- Ank 6 -->
                                <div class="ank-col">
                                    <div class="ank-card ank-6">
                                        <p class="ank-title">Total Bids 0</p>
                                        <h3 class="ank-value">0</h3>
                                        <p class="ank-sub">Total Bid Amount</p>
                                        <div class="ank-footer">Ank 6</div>
                                    </div>
                                </div>

                                <!-- Ank 7 -->
                                <div class="ank-col">
                                    <div class="ank-card ank-7">
                                        <p class="ank-title">Total Bids 0</p>
                                        <h3 class="ank-value">0</h3>
                                        <p class="ank-sub">Total Bid Amount</p>
                                        <div class="ank-footer">Ank 7</div>
                                    </div>
                                </div>

                                <!-- Ank 8 -->
                                <div class="ank-col">
                                    <div class="ank-card ank-8">
                                        <p class="ank-title">Total Bids 0</p>
                                        <h3 class="ank-value">0</h3>
                                        <p class="ank-sub">Total Bid Amount</p>
                                        <div class="ank-footer">Ank 8</div>
                                    </div>
                                </div>

                                <!-- Ank 9 -->
                                <div class="ank-col">
                                    <div class="ank-card ank-9">
                                        <p class="ank-title">Total Bids 0</p>
                                        <h3 class="ank-value">0</h3>
                                        <p class="ank-sub">Total Bid Amount</p>
                                        <div class="ank-footer">Ank 9</div>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>

                     <div class="row">
                        <div class="col-12">


                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h3 class="card-title">Fund Request Auto Deposit History</h3>
                                </div>

                                <div class="card-body">
                                    <table class="table table-bordered table-striped" id="fundTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Username</th>
                                                <th>Amount</th>
                                                <th>Request No.</th>
                                                <th>Txn Id</th>
                                                <th>Reject Mark</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <tr>
    <td colspan="9" class="text-center">No records found</td> 
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                         
                         



                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>


                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>

    <script>
        $(function() {
            $("#fundTable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#fundTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>
