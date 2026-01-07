<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Contacts</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <x-admin-navbar />
        <!-- /.navbar -->

        <x-admin-sidebar />

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>User</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">View User</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="row">

                    <!-- LEFT : USER SUMMARY -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body box-profile">
                                <div class="d-flex justify-content-around align-items-center">
                                    <div class="text-center">
                                        <img class=" img-fluid img-circle w-40" src="../../dist/img/user1-128x128.jpg"
                                            alt="User profile picture" width="60">
                                    </div>
                                    <div class="mt-3 text-center">
                                        <h3 class="profile-username text-center">{{ $user->name }}</h3>

                                        <p class="text-muted text-center">
                                            {{ $user->phone }}
                                            <i class="fas fa-copy ml-1"></i>
                                            <i class="fab fa-whatsapp ml-1 text-success"></i>
                                        </p>
                                    </div>
                                </div>




                                <ul class="list-group list-group-unbordered mb-2">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <b>Active</b>
                                        <span class="badge badge-success">{{ $user->status==1? 'Yes' : 'No' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <b>Betting</b>
                                        <span class="badge badge-success">{{ $user->betting==1?'Yes':'No' }}</span>
                                    </li>
                                    {{-- <li class="list-group-item d-flex justify-content-between">
                                        <b>TP</b>
                                        <span class="badge badge-danger">No</span>
                                    </li> --}}
                                </ul>

                                <div class="mb-3">

                                    <div class="d-flex justify-content-between align-items-center">
                                        <label>Security Pin <strong>{{ $user->plain_mpin }}</strong></label>
                                        <button class="btn btn-sm btn-primary">Change</button>
                                    </div>
                                </div>

                                <hr>

                                <h5>Available Balance</h5>
                                <h3 class="text-bold">₹ {{ $user->wallet->balance ?? 0 }}</h3>

                                <div class="d-flex justify-content-between mt-3">
                                    <button class="btn btn-success btn-sm w-50 mr-1">Add Fund</button>
                                    <button class="btn btn-danger btn-sm w-50 ml-1">Withdraw Fund</button>
                                </div>

                                <div class="text-center mt-3">
                                    <button class="btn btn-warning btn-sm">Logout Now</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- RIGHT : USER DETAILS -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Personal Information</h3>
                            </div>

                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th width="30%">Full Name</th>
                                            <td>{{ $user->name }}</td>
                                            <th>Email</th>
                                            <td>{{ $user->email ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Mobile</th>
                                            <td>{{ $user->phone }}</td>
                                            <th>Password</th>
                                            <td>{{ $user->plain_mpin }}</td>
                                        </tr>
                                        <tr>
                                            <th>District</th>
                                            <td>N/A</td>
                                            <th>Flat / Plot</th>
                                            <td>N/A</td>
                                        </tr>
                                        <tr>
                                            <th>Address Lane 1</th>
                                            <td>N/A</td>
                                            <th>Address Lane 2</th>
                                            <td>N/A</td>
                                        </tr>
                                        <tr>
                                            <th>Area</th>
                                            <td>N/A</td>
                                            <th>Pin Code</th>
                                            <td>N/A</td>
                                        </tr>
                                        <tr>
                                            <th>State</th>
                                            <td>N/A</td>
                                            <th></th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>Created At</th>
                                            <td>{{ $user->created_at }}</td>
                                            <th>Last Seen</th>
                                            <td>{{ $user->updated_at ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- PAYMENT INFORMATION -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Payment Information</h3>
                            </div>

                            <div class="card-body p-0">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th width="20%">Bank Name</th>
                                            <td>N/A</td>
                                            <th width="20%">Branch Address</th>
                                            <td>N/A</td>
                                        </tr>
                                        <tr>
                                            <th>A/c Holder Name</th>
                                            <td>N/A</td>
                                            <th>A/c Number</th>
                                            <td>N/A</td>
                                        </tr>
                                        <tr>
                                            <th>IFSC Code</th>
                                            <td>N/A</td>
                                            <th></th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>PhonePe No.</th>
                                            <td>N/A</td>
                                            <th>Google Pay No.</th>
                                            <td>N/A</td>
                                        </tr>
                                        <tr>
                                            <th>Paytm No.</th>
                                            <td>N/A</td>
                                            <th></th>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Add Fund Request List</h3>
                            </div>

                            <div class="card-body">
                                <table id="addFundTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Request Amount</th>
                                            <th>Request No.</th>
                                            <th>Receipt Image</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                No data available in table
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Withdraw Fund Request List</h3>
                            </div>

                            <div class="card-body">
                                <table id="withdrawFundTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Request Amount</th>
                                            <th>Request No.</th>
                                            <th>Request Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                No data available in table
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header">
                                <h3 class="card-title">Bid History</h3>
                            </div>

                            <div class="card-body">
                                <table id="bidHistoryTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Game Name</th>
                                            <th>Game Type</th>
                                            <th>Session</th>
                                            <th>Digits</th>
                                            <th>Close Digits</th>
                                            <th>Points</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">
                                                No data available in table
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                              <div class="card-header">
                                <h3 class="card-title">Withdraw Transaction History</h3>
                            </div>

                            <div class="card-header p-0">
                                
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#wallet-all"
                                            role="tab">
                                            All
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#wallet-credit" role="tab">
                                            Credit
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#wallet-debit" role="tab">
                                            Debit
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <div class="tab-content">

                                    <!-- ALL -->
                                    <div class="tab-pane fade show active" id="wallet-all">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Amount</th>
                                                    <th>Transaction Note</th>
                                                    <th>Transfer Note</th>
                                                    <th>Date</th>
                                                    <th>Tx Req. No.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td class="text-success">+ ₹11</td>
                                                    <td>User Welcome Bonus</td>
                                                    <td>N/A</td>
                                                    <td>04 Jan 2026 05:42 PM</td>
                                                    <td>5383606</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- CREDIT -->
                                    <div class="tab-pane fade" id="wallet-credit">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Amount</th>
                                                    <th>Note</th>
                                                    <th>Date</th>
                                                    <th>Tx Req. No.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">
                                                        No credit transactions
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- DEBIT -->
                                    <div class="tab-pane fade" id="wallet-debit">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Amount</th>
                                                    <th>Note</th>
                                                    <th>Date</th>
                                                    <th>Tx Req. No.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">
                                                        No debit transactions
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <!-- HEADER -->
                            <div class="card-header">
                                <h3 class="card-title">Winning History Report</h3>
                            </div>

                            <!-- BODY -->
                            <div class="card-body">

                                <!-- FILTER ROW -->
                                <form method="GET" action="">
                                    <div class="row align-items-end mb-3">
                                        <div class="col-md-4">
                                            <label>Date</label>
                                            <input type="date" name="date" class="form-control"
                                                value="2026-01-07">
                                        </div>

                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <!-- TABLE -->
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Amount (₹)</th>
                                            <th>Game Name</th>
                                            <th>Tx Id</th>
                                            <th>Tx Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                No data available
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>


                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
</body>

</html>
