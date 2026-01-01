<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Matka Play | Account Statement</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

  <style>
    /* ✅ TOP BAR */
    .top-bar {
      position: fixed;
      top: 0;
      width: 100%;
      max-width: 500px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 15px 25px;
      border-bottom: 1px solid #eee;
      background: #fff;
      z-index: 10;
    }

    .wallet {
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 600;
      color: #007bff;
    }

    .wallet i {
      font-size: 20px;
    }

    /* ✅ SCROLLABLE CONTENT */
    .home-content {
      flex: 1;
      overflow-y: auto;
      background: #f5f6fa;
      padding: 80px 15px 90px;
      height: calc(100dvh - 140px);
      box-sizing: border-box;
    }

    .top-bar i {
      cursor: pointer;
      padding: 10px 15px;
      border-radius: 20px;
      background: #007bff;
      color: #fff;
    }

    /* ✅ ACCOUNT STATEMENT CARD */
    .statement-card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.05);
      padding: 15px 18px;
      margin-bottom: 15px;
    }

    .statement-card .date {
      color: #007bff;
      font-weight: 600;
      font-size: 14px;
    }

    .statement-card .particular {
      font-size: 13px;
      color: #333;
      margin-top: 4px;
      font-weight: 500;
    }

    .statement-card .amounts {
      margin-top: 10px;
      font-size: 13px;
      color: #444;
    }

    .statement-card .amounts div {
      display: flex;
      justify-content: space-between;
      margin-bottom: 4px;
    }

    .amounts span.label {
      font-weight: 500;
    }

    .amounts span.value {
      font-weight: 600;
    }

    .value.positive {
      color: #28a745;
    }

    .value.negative {
      color: #dc3545;
    }

    .value.neutral {
      color: #007bff;
    }
  </style>
</head>

<body>

  <div class="app-layout">
    <div class="left-area">
      <div class="top-bar">
        <i class="fa-solid fa-angle-left" id="backBtn" onclick="goBack()"></i>
        <h5 class="m-0 fw-bold text-primary">Fund Request</h5>
        @include('components.walletinfo')
      </div>

      <div class="home-content">

        <!-- ✅ ACCOUNT STATEMENT CARD 1 -->
        <div class="statement-card">
          <div class="date">Oct 14, 2025</div>
          <div class="particular">Welcome Bonus</div>

          <div class="amounts mt-2">
            <div>
              <span class="label">Previous Amount:</span>
              <span class="value neutral">₹0</span>
            </div>
            <div>
              <span class="label">Transaction Amount:</span>
              <span class="value positive">+₹5</span>
            </div>
            <div>
              <span class="label">Current Amount:</span>
              <span class="value neutral">₹5</span>
            </div>
          </div>
        </div>

        <!-- ✅ SAMPLE SECOND CARD -->
        <div class="statement-card">
          <div class="date">Oct 15, 2025</div>
          <div class="particular">Game Win Reward</div>

          <div class="amounts mt-2">
            <div>
              <span class="label">Previous Amount:</span>
              <span class="value neutral">₹5</span>
            </div>
            <div>
              <span class="label">Transaction Amount:</span>
              <span class="value positive">+₹50</span>
            </div>
            <div>
              <span class="label">Current Amount:</span>
              <span class="value neutral">₹55</span>
            </div>
          </div>
        </div>

      </div>

      @include('components.bottombar')
    </div>

    @include('components.rightside')
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>

  <script>
    function goBack() {
      window.history.back();
    }
  </script>

</body>
</html>
