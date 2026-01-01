<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Matka Play | All Bids</title>

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

        /* ✅ SCROLLABLE CONTENT */
        .home-content {
            flex: 1;
            overflow-y: auto;
            background: #f9f9f9;
            padding: 80px 15px 90px;
            height: calc(100dvh - 140px);
            box-sizing: border-box;
        }

        /* ✅ CARD STYLING LIKE IN IMAGE */
        .history-card {
            background: #fff;
            padding: 14px 18px;
            border-radius: 12px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            cursor: pointer;
            transition: 0.2s;
        }

        .history-card:hover {
            background: #f1f5ff;
        }

        .history-card span {
            font-size: 15px;
            font-weight: 500;
            color: #333;
        }

        .history-card i {
            color: #007bff;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <div class="app-layout">
        <div class="left-area">
            <!-- ✅ Top Bar -->
            <div class="top-bar">
                <i class="fa-solid fa-angle-left" id="backBtn" onclick="goBack()"></i>
                <h5>All Bids</h5>
                @include('components.walletinfo')
            </div>

            <!-- ✅ Main Scrollable Section -->
            <div class="home-content">
                <div class="history-card" onclick="window.location.href='{{ route('my.bids') }}'">
                    <span>Bid History</span>
                    <i class="fa fa-chevron-right"></i>
                </div>

                <div class="history-card" onclick="window.location.href='{{ route('request.fund') }}'">
                    <span>Fund Request History</span>
                    <i class="fa fa-chevron-right"></i>
                </div>

                <div class="history-card" onclick="window.location.href='{{ route('approved.credit') }}'">
                    <span>Approved Credit History</span>
                    <i class="fa fa-chevron-right"></i>
                </div>

                <div class="history-card" onclick="window.location.href='{{ route('approved.debit') }}'">
                    <span>Approved Debit History</span>
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
            console.log('Opening page:', page);
            // Redirect logic here, e.g.:
            // window.location.href = `/user/${page}`;
        }
    </script>
</body>

</html>
