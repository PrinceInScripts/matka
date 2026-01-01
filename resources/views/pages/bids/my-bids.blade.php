<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Matka Play | My Bids</title>

  <!-- Bootstrap + Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

  <style>
    body {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: "Poppins", sans-serif;
    background: #f5f6fa;
    overflow: hidden; /* ✅ keep this to prevent double scrollbars */
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
    z-index: 100;
    height: 100vh;
    overflow: hidden; /* ✅ keep this */
}

/* ✅ add this new section */
.home-content {
    flex: 1;
    overflow-y: auto;       /* 👈 allows scrolling */
    padding: 60px 15px 100px; /* 👈 gives space below for bottom bar */
    background: #f5f6fa;
}

/* Optional: smooth scrolling */
.home-content::-webkit-scrollbar {
    width: 6px;
}
.home-content::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}


    .top-bar {
      position: fixed;
      top: 0; width: 100%; max-width: 500px;
      display: flex; justify-content: space-between; align-items: center;
      padding: 15px 20px;
      background: #fff;
      border-bottom: 1px solid #eee;
      z-index: 999;
    }

    .home-content {
      padding: 70px 15px 90px;
      max-width: 500px;
      margin: 0 auto;
    }

    .filter-form {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0px 2px 6px rgba(0,0,0,0.08);
      padding: 12px 15px;
      margin-bottom: 18px;
    }

    .filter-form input, .filter-form select {
      border-radius: 8px !important;
    }

    .statement-card {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0px 2px 6px rgba(0,0,0,0.06);
      padding: 15px 18px;
      margin-bottom: 14px;
      transition: 0.2s;
    }

    .statement-card:hover {
      transform: scale(1.01);
    }

    .date {
      color: #007bff;
      font-size: 13px;
      font-weight: 600;
      margin-bottom: 6px;
    }

    .particular {
      font-size: 14px;
      line-height: 1.4;
    }

    .amounts {
      margin-top: 10px;
      font-size: 13px;
    }

    .amounts .label {
      font-weight: 500;
      color: #555;
    }

    .amounts .value {
      float: right;
      font-weight: 600;
    }

    .value.positive { color: #28a745; }
    .value.negative { color: #dc3545; }
    .value.neutral { color: #007bff; }

    .pagination {
      justify-content: center;
      margin-top: 15px;
    }

    .btn-sm {
      border-radius: 8px;
      padding: 4px 12px;
    }

    @media(max-width: 576px){
      .filter-form .row > div { margin-bottom: 8px; }
    }
  </style>
</head>

<body>
  <div class="app-layout">
    <!-- ✅ Top Bar -->
    <div class="left-area">
    <div class="top-bar">
      <i class="fa-solid fa-angle-left fs-5 text-primary" onclick="window.history.back()"></i>
      <h6 class="m-0 fw-semibold text-primary">My Bids</h6>
      @include('components.walletinfo')
    </div>

    <!-- ✅ Page Content -->
    <div class="home-content">

      <!-- Filter Form -->
      <form id="filterForm" class="filter-form">
        <div class="row g-2 align-items-center">
          <div class="col-4">
            <input type="text" name="market" class="form-control form-control-sm" placeholder="Market">
          </div>
          <div class="col-4">
            <input type="text" name="game_type" class="form-control form-control-sm" placeholder="Game Type">
          </div>
          <div class="col-4">
            <select name="status" class="form-select form-select-sm">
              <option value="">All</option>
              <option value="Pending">Pending</option>
              <option value="Won">Won</option>
              <option value="Lost">Lost</option>
            </select>
          </div>
          <div class="col-12 text-center mt-2">
            <button type="submit" class="btn btn-primary btn-sm px-4">Apply</button>
            <button type="button" id="resetFilter" class="btn btn-secondary btn-sm px-4">Reset</button>
          </div>
        </div>
      </form>

      <!-- Bids List -->
      <div id="bidList">
        @include('pages.bids.partials.bid-list', ['bids' => $bids])
      </div>

    </div>

    @include('components.bottombar')
    </div>
    @include('components.rightside')
  </div>

  <!-- ✅ Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
  <script>
  $(function() {
      // Handle Filter Submit
      $('#filterForm').on('submit', function(e){
          e.preventDefault();
          loadBids(1);
      });

      // Reset Filters
      $('#resetFilter').click(function(){
          $('#filterForm')[0].reset();
          loadBids(1);
      });

      // Handle Pagination
      $(document).on('click', '.pagination a', function(e){
          e.preventDefault();
          let page = $(this).attr('href').split('page=')[1];
          loadBids(page);
      });

      // Load Bids via AJAX
      function loadBids(page){
          $.ajax({
              url: "{{ route('my.bids') }}" + "?page=" + page,
              method: 'GET',
              data: $('#filterForm').serialize(),
              beforeSend: function(){
                  $('#bidList').html('<div class="text-center p-3 text-muted">Loading...</div>');
              },
              success: function(res){
                  $('#bidList').html(res.html);
              },
              error: function(){
                  $('#bidList').html('<div class="text-center p-3 text-danger">Failed to load data.</div>');
              }
          });
      }
  });
  </script>
</body>
</html>
