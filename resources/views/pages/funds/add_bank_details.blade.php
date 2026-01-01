<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Matka Play | Bank Details</title>

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

        .wallet {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #007bff;
        }

        .top-bar i {
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 20px;
            background: #007bff;
            color: #fff;
        }

        /* ✅ MAIN SCROLL AREA */
        .home-content {
            flex: 1;
            /* overflow-y: auto; */
            background: #f5f6fa;
            padding: 80px 15px 90px;
            /* extra padding for fixed bars */
            height: calc(100dvh - 140px);
            -webkit-overflow-scrolling: touch;
            box-sizing: border-box;
        }

        /* ✅ BANK DETAILS FORM STYLES */
        .bank-details-box {
            background: #fff;
            border-radius: 16px;
            padding: 25px 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            max-width: 480px;
            margin: 0 auto;
        }

        .bank-details-box h5 {
            font-weight: 700;
            color: #333;
            margin-bottom: 25px;
        }

        .form-control-custom {
            background: #f8f9fb;
            border: none;
            border-radius: 30px;
            padding: 12px 45px 12px 18px;
            font-size: 15px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
            width: 100%;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 18px;
        }

        .input-wrapper i {
            position: absolute;
            right: 18px;
            top: 12px;
            color: #999;
            font-size: 16px;
        }

        .submit-btn {
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

        .submit-btn:hover {
            background: #0056d2;
        }

        /* ✅ BOTTOM NAV BAR (placeholder demo) */
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
            <h5 class="m-0 fw-bold text-primary">Bank Details</h5>
            @include('components.walletinfo')
        </div>

        <div class="home-content">
            <div class="bank-details-box">
                <h5>Bank Details</h5>

                <form>
                    <div class="input-wrapper">
                        <input type="text" class="form-control-custom" placeholder="IFSC Code">
                        <i class="fa-solid fa-lock"></i>
                    </div>

                    <div class="input-wrapper">
                        <input type="text" class="form-control-custom" placeholder="Account number">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>

                    <div class="input-wrapper">
                        <input type="text" class="form-control-custom" placeholder="Bank name">
                        <i class="fa-solid fa-landmark"></i>
                    </div>

                    <div class="input-wrapper">
                        <input type="text" class="form-control-custom" placeholder="Account holder name">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <div class="input-wrapper">
                        <input type="text" class="form-control-custom" placeholder="Google Pay Number">
                        <i class="fa-brands fa-google-pay"></i>
                    </div>

                    <div class="input-wrapper">
                        <input type="text" class="form-control-custom" placeholder="PhonePe Number">
                        <i class="fa-solid fa-mobile-screen"></i>
                    </div>

                    <div class="input-wrapper">
                        <input type="text" class="form-control-custom" placeholder="Paytm Number">
                        <i class="fa-solid fa-wallet"></i>
                    </div>

                    <button type="submit" class="submit-btn">SUBMIT</button>
                </form>
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
