<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Matka Play | Wallet Management</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

  <style>
    /* ✅ FIXED TOP BAR */
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

    .top-bar h5 {
      margin: 0;
      color: #007bff;
      font-weight: 700;
    }

    .top-bar i {
      cursor: pointer;
      padding: 10px 15px;
      border-radius: 20px;
      background: #007bff;
      color: #fff;
    }

    .wallet {
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 600;
      color: #007bff;
    }

    .wallet i {
      font-size: 18px;
    }

    /* ✅ SCROLLABLE CONTENT AREA */
    .home-content {
      flex: 1;
      overflow-y: auto;
      background: #f9f9f9;
      padding: 80px 15px 90px;
      height: calc(100dvh - 140px);
      box-sizing: border-box;
    }

    /* ✅ CARD STYLE */
    .wallet-card {
      background: #fff;
      padding: 14px 18px;
      border-radius: 12px;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 12px;
      cursor: pointer;
      transition: 0.2s;
    }

    .wallet-card:hover {
      background: #f1f5ff;
    }

    .wallet-icon {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .color-bar {
      width: 4px;
      height: 40px;
      border-radius: 10px;
    }

    /* Color codes */
    .green {
      background: #25d366;
    }

    .yellow {
      background: #fbbf24;
    }

    .blue {
      background: #3b82f6;
    }

    .cyan {
      background: #06b6d4;
    }

    .purple {
      background: #8b5cf6;
    }

    /* Icon circle */
    .icon-circle {
      font-size: 18px;
      color: #fff;
      border-radius: 50%;
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .icon-green {
      background: #25d366;
    }

    .icon-yellow {
      background: #fbbf24;
    }

    .icon-blue {
      background: #3b82f6;
    }

    .icon-cyan {
      background: #06b6d4;
    }

    .icon-purple {
      background: #8b5cf6;
    }

    .wallet-card span {
      font-size: 15px;
      font-weight: 500;
      color: #333;
    }

    .wallet-card i.fa-chevron-right {
      color: #007bff;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <div class="app-layout">
    <div class="left-area">
      <!-- ✅ Top Bar -->
      <div class="top-bar">
        <i class="fa-solid fa-angle-left" id="backBtn" onclick="goBack()"></i>
        <h5>Wallet Management</h5>
        @include('components.walletinfo')
      </div>

      <!-- ✅ Wallet Management Page -->
      <div class="home-content">
        <div style="border-left: 5px solid #25d366" class="wallet-card" onclick="window.location.href='{{ route('deposit.funds.auto') }}'">
          <div class="wallet-icon">
            <div class="icon-circle icon-green"><i class="fa-solid fa-money-bill"></i></div>
            <span>Add Fund</span>
          </div>
          <i class="fa fa-chevron-right"></i>
        </div>

        <div style="border-left: 5px solid #fbbf24" class="wallet-card" onclick="window.location.href='{{ route('deposit.funds.manual') }}'">
          <div class="wallet-icon">
            <div class="icon-circle icon-yellow"><i class="fa-solid fa-upload"></i></div>
            <span>Manual Deposit Upload Image</span>
          </div>
          <i class="fa fa-chevron-right"></i>
        </div>

        <div style="border-left: 5px solid #3b82f6" class="wallet-card" onclick="window.location.href='{{ route('withdraw.funds') }}'">
          <div class="wallet-icon">
            <div class="icon-circle icon-blue"><i class="fa-solid fa-money-check-dollar"></i></div>
            <span>Withdraw Funds</span>
          </div>
          <i class="fa fa-chevron-right"></i>
        </div>

        <div style="border-left: 5px solid #06b6d4" class="wallet-card" onclick="window.location.href='{{ route('deposit.history') }}'">
          <div class="wallet-icon">
            <div class="icon-circle icon-cyan"><i class="fa-solid fa-calendar-days"></i></div>
            <span>Deposit History</span>
          </div>
          <i class="fa fa-chevron-right"></i>
        </div>

        <div style="border-left: 5px solid #3b82f6" class="wallet-card" onclick="window.location.href='{{ route('withdraw.history') }}'">
          <div class="wallet-icon">
            <div class="icon-circle icon-blue"><i class="fa-solid fa-rotate-left"></i></div>
            <span>Withdrawal History</span>
          </div>
          <i class="fa fa-chevron-right"></i>
        </div>

        <div style="border-left: 5px solid #8b5cf6" class="wallet-card" onclick="window.location.href='{{ route('add.bank') }}'">
          <div class="wallet-icon">
            <div class="icon-circle icon-purple"><i class="fa-solid fa-university"></i></div>
            <span>Add Bank Details</span>
          </div>
          <i class="fa fa-chevron-right"></i>
        </div>
      </div>

      @include('components.bottombar')
    </div>

    @include('components.rightside')
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function goBack() {
      window.history.back();
    }

    function openPage(page) {
      console.log("Opening:", page);
      // Example redirect: window.location.href = `/wallet/${page}`;
    }
  </script>
</body>

</html>
