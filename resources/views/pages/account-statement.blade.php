<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Matka Play | Account Statement</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: #f5f6fa;
      margin: 0;
      padding: 0;
      overflow: hidden;
    }

    .left-area {
      background: #fff;
      width: 100%;
      max-width: 500px;
      margin: 0 auto;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      display: flex;
      flex-direction: column;
      position: relative;
      height: 100vh;
      overflow: hidden;
    }

    .top-bar {
      position: fixed;
      top: 0;
      width: 100%;
      max-width: 500px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 20px;
      background: #fff;
      border-bottom: 1px solid #eee;
      z-index: 999;
    }

    .home-content {
      flex: 1;
      overflow-y: auto;
      padding: 70px 15px 90px;
      background: #f5f6fa;
    }

    .filter-form {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.08);
      padding: 12px 15px;
      margin-bottom: 18px;
    }

    .statement-card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.05);
      padding: 15px 18px;
      margin-bottom: 15px;
      transition: 0.2s;
    }

    .statement-card:hover { transform: scale(1.01); }

    .date { color: #007bff; font-weight: 600; font-size: 13px; }

    .particular { font-size: 13px; font-weight: 500; margin-top: 3px; color: #333; }

    .amounts { margin-top: 10px; font-size: 13px; color: #444; }
    .amounts div { display: flex; justify-content: space-between; margin-bottom: 4px; }

    .value.positive { color: #28a745; }
    .value.negative { color: #dc3545; }
    .value.neutral { color: #007bff; }
  </style>
</head>

<body>
  <div class="app-layout">
    <div class="left-area">
      <!-- ✅ Top Bar -->
      <div class="top-bar">
        <i class="fa-solid fa-angle-left text-primary fs-5" onclick="window.history.back()"></i>
        <h6 class="m-0 fw-semibold text-primary">Account Statement</h6>
        @include('components.walletinfo')
      </div>

      <!-- ✅ Content -->
      <div class="home-content">

        <!-- ✅ Filter Form -->
        <form id="filterForm" class="filter-form">
          <div class="row g-2 align-items-center">

            <!-- Type -->
            <div class="col-6">
              <select name="type" class="form-select form-select-sm">
                <option value="">All Types</option>
                <option value="credit">Credit</option>
                <option value="debit">Debit</option>
              </select>
            </div>

            <!-- Reason -->
            <div class="col-6">
              <input type="text" name="reason" class="form-control form-control-sm" placeholder="Search Reason...">
            </div>

            <!-- Date From -->
            <div class="col-6">
              <input type="date" name="date_from" class="form-control form-control-sm">
            </div>

            <!-- Date To -->
            <div class="col-6">
              <input type="date" name="date_to" class="form-control form-control-sm">
            </div>

            <div class="col-12 text-center mt-2">
              <button type="submit" class="btn btn-primary btn-sm px-4">Apply</button>
              <button type="button" id="resetFilter" class="btn btn-secondary btn-sm px-4">Reset</button>
            </div>
          </div>
        </form>

        <!-- ✅ Transactions List -->
        <div id="transactionList">
          @include('pages.account-statement-partials-list', ['transactions' => $transactions])
        </div>

      </div>

      @include('components.bottombar')
    </div>

    @include('components.rightside')
  </div>

  <!-- ✅ Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  $(function() {

      // Apply filter
      $('#filterForm').on('submit', function(e) {
          e.preventDefault();
          loadTransactions(1);
      });

      // Reset filter
      $('#resetFilter').click(function() {
          $('#filterForm')[0].reset();
          loadTransactions(1);
      });

      // Pagination click
      $(document).on('click', '.pagination a', function(e) {
          e.preventDefault();
          let page = $(this).attr('href').split('page=')[1];
          loadTransactions(page);
      });

      // AJAX Load function
      function loadTransactions(page) {
          $.ajax({
              url: "{{ route('account.statement') }}" + "?page=" + page,
              method: 'GET',
              data: $('#filterForm').serialize(),
              beforeSend: function() {
                  $('#transactionList').html('<div class="text-center p-3 text-muted">Loading...</div>');
              },
              success: function(res) {
                  $('#transactionList').html(res.html);
              },
              error: function() {
                  $('#transactionList').html('<div class="text-center p-3 text-danger">Failed to load data.</div>');
              }
          });
      }

  });
  </script>
</body>
</html>
