<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>User Management | Admin</title>
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
          <div class="col-sm-6"><h1>User Management</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">

        <!-- Summary row -->
        <div class="row mb-3">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner"><h3>{{ $users->count() }}</h3><p>Total Users</p></div>
              <div class="icon"><i class="fas fa-users"></i></div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner"><h3>{{ $users->where('status',1)->count() }}</h3><p>Active Users</p></div>
              <div class="icon"><i class="fas fa-user-check"></i></div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner"><h3>{{ $users->where('betting',1)->count() }}</h3><p>Betting Enabled</p></div>
              <div class="icon"><i class="fas fa-dice"></i></div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner"><h3>{{ $users->where('status',0)->count() }}</h3><p>Blocked Users</p></div>
              <div class="icon"><i class="fas fa-user-slash"></i></div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-user-friends mr-2"></i>All Users</h3>
          </div>
          <div class="card-body table-responsive p-0">
            <table id="example1" class="table table-bordered table-striped table-hover table-sm">
              <thead class="bg-dark text-white">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Registered</th>
                  <th>Balance</th>
                  <th>Betting</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td><strong>{{ $user->name }}</strong></td>
                  <td>{{ $user->phone }}</td>
                  <td>{{ $user->email ?: 'N/A' }}</td>
                  <td><small>{{ $user->created_at->format('d M Y') }}</small></td>
                  <td><strong class="text-success">₹{{ number_format($user->balance ?? 0, 2) }}</strong></td>
                  <td>
                    <span class="badge badge-{{ $user->betting ? 'success' : 'secondary' }}">
                      {{ $user->betting ? 'On' : 'Off' }}
                    </span>
                  </td>
                  <td>
                    <span class="badge badge-{{ $user->status ? 'success' : 'danger' }}">
                      {{ $user->status ? 'Active' : 'Blocked' }}
                    </span>
                  </td>
                  <td>
                    <a href="{{ route('admin.user.view', $user->id) }}"
                       class="btn btn-primary btn-xs" title="View User">
                      <i class="fas fa-eye"></i> View
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </section>
  </div>
  <footer class="main-footer"><strong>Copyright &copy; Matka Admin.</strong> All rights reserved.</footer>
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
$(function () {
  $("#example1").DataTable({
    responsive: true, autoWidth: false, order: [[4,'desc']],
    buttons: ["copy","csv","excel","pdf","print","colvis"],
    columnDefs: [{ orderable: false, targets: [8] }]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
});
</script>
</body>
</html>
