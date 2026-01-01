<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Matka Play | Fund History</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
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

        /* ✅ MAIN SCROLLABLE AREA */
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

        /* ✅ FUND HISTORY CARD STYLE */
        .fund-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.05);
            padding: 15px 18px;
            margin-bottom: 15px;
        }

        .fund-card .date {
            color: #007bff;
            font-weight: 600;
            font-size: 14px;
        }

        .fund-card .status {
            color: #b5a400;
            font-weight: 600;
            float: right;
            font-size: 14px;
        }

        .fund-card .fund-id {
            font-size: 13px;
            color: #333;
            margin: 5px 0;
        }

        .fund-card .amount {
            color: #007bff;
            font-weight: 600;
            font-size: 15px;
        }

        .fund-card .request {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 8px;
        }

        .fund-card .request i {
            background: #007bff;
            color: #fff;
            border-radius: 50%;
            padding: 8px;
            font-size: 14px;
        }

        .fund-card .request-type {
            font-size: 13px;
            color: #777;
        }

        .fund-card .request-type strong {
            color: #000;
            display: block;
        }
    </style>
</head>

<body>

    <div class="app-layout">
        <div class="left-area">
            <div class="top-bar">
                <i class="fa-solid fa-angle-left" id="backBtn" onclick="goBack()"></i>
                <h5 class="m-0 fw-bold text-primary">All Fund History</h5>
                @include('components.walletinfo')
            </div>

            <div class="home-content">
                <!-- ✅ FUND HISTORY CARD 1 -->
                <div class="fund-card">
                    <div class="d-flex justify-content-between">
                        <span class="date">2025/10/24</span>
                        <span class="status">In Process</span>
                    </div>
                    <div class="fund-id">
                        FUND ID : Payment ID (TXN1761327130470)
                    </div>
                    <div class="amount">₹300</div>
                    <div class="request">
                        <i class="fa fa-wallet"></i>
                        <div class="request-type">
                            Request Type <br>
                            <strong>Deposite</strong>
                        </div>
                    </div>
                </div>

                <!-- ✅ FUND HISTORY CARD 2 -->
                <div class="fund-card">
                    <div class="d-flex justify-content-between">
                        <span class="date">2025/10/20</span>
                        <span class="status">In Process</span>
                    </div>
                    <div class="fund-id">
                        FUND ID : Payment ID (TXN1760951112220)
                    </div>
                    <div class="amount">₹300</div>
                    <div class="request">
                        <i class="fa fa-wallet"></i>
                        <div class="request-type">
                            Request Type <br>
                            <strong>Deposite</strong>
                        </div>
                    </div>
                </div>
            </div>

            @include('components.bottombar')
        </div>

        @include('components.rightside')
    </div>

    <!-- Bootstrap JS -->
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
