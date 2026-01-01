<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Matka Play | Add Fund UPI</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

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

        /* ✅ SCROLL AREA */
        .home-content {
            flex: 1;
            overflow-y: auto;
            background: #f5f6fa;
            padding: 90px 15px 100px;
            height: calc(100vh - 140px);
            box-sizing: border-box;
        }

        /* ✅ UPI FUND CARD */
        .upi-container {
            max-width: 480px;
            margin: 0 auto;
        }

        .upi-image {
            text-align: center;
            margin-top: 20px;
        }

        .upi-image img {
            width: 150px;
            max-width: 100%;
        }

        .wallet-card {
            background: #fff;
            border-radius: 16px;
            padding: 15px 20px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 25px;
        }

        .wallet-card i {
            font-size: 22px;
            color: #007bff;
        }

        .wallet-card h6 {
            font-weight: 700;
            margin: 0;
        }

        .wallet-card p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        /* ✅ INPUT FIELD */
        .input-label {
            margin-top: 25px;
            font-weight: 600;
            color: #333;
            font-size: 15px;
        }

        .input-wrapper {
            position: relative;
            margin-top: 10px;
            margin-bottom: 25px;
        }

        .form-control-custom {
            width: 100%;
            border: none;
            border-radius: 30px;
            background: #f8f9fb;
            padding: 12px 45px 12px 18px;
            font-size: 15px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .input-wrapper i {
            position: absolute;
            right: 18px;
            top: 12px;
            color: #999;
            font-size: 16px;
        }

        /* ✅ PAY BUTTON */
        .pay-btn {
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 25px;
            width: 100%;
            padding: 12px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 3px 6px rgba(0, 123, 255, 0.3);
            transition: 0.3s;
        }

        .pay-btn:hover {
            background: #0056d2;
        }

        /* ✅ BOTTOM NAV DEMO */
        .bottom-bar {
            position: fixed;
            bottom: 0;
            width: 100%;
            max-width: 500px;
            background: #fff;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
        }

        .bottom-bar a {
            color: #444;
            text-align: center;
            font-size: 13px;
            text-decoration: none;
        }

        .bottom-bar i {
            font-size: 18px;
            display: block;
        }
    </style>
</head>

<body>

    <div class="app-layout">
        <div class="left-area">
        <div class="top-bar">
            <i class="fa-solid fa-angle-left" onclick="goBack()"></i>
            <h5 class="m-0 fw-bold text-primary">Add Fund Upi</h5>
           @include('components.walletinfo')
        </div>

        <div class="home-content">
            <div class="upi-container">
             

                <div class="wallet-card">
                    <i class="fa-solid fa-wallet"></i>
                    <div>
                        <h6>₹ 5.00</h6>
                        <p>Total Wallet Balance</p>
                    </div>
                </div>

                <div class="input-label">Add Fund</div>
                <div class="input-wrapper">
                    <input type="number" class="form-control-custom" placeholder="Enter Points">
                    <i class="fa-solid fa-credit-card"></i>
                </div>

                <button class="pay-btn">Pay</button>
            </div>
        </div>

        <!-- Bottom Bar -->
        @include('components.bottombar')

        </div>

        @include('components.rightside')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    {{-- toastify --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>

</body>

</html>
