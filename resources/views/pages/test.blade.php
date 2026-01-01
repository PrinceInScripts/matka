<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Matka Play | Home</title>

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

        .menu-toggle {
            font-size: 22px;
            color: #007bff;
            cursor: pointer;
        }

        .wallet {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #007bff;
            cursor: pointer;
        }

        .wallet i {
            font-size: 20px;
        }

        /* ✅ SCROLLABLE CONTENT ONLY */
        .home-content {
            flex: 1;
            overflow-y: auto;
            background: #f5f6fa;
            padding: 80px 15px 90px;
            /* extra padding for fixed bars */
            height: calc(100dvh - 140px);
            -webkit-overflow-scrolling: touch;
            box-sizing: border-box;
        }

        .fa-sidebar {
            font-size: 22px;
            color: #007bff;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 50%;
        }

        .top-bar i {
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 20px;
            background: #007bff;
            color: #fff;
        }
    </style>

</head>

<body>


    <div class="app-layout">
        <!-- LEFT AREA -->
        <div class="left-area">
            <div class="top-bar">
                <!-- Back Button -->
                <i class="fa-solid fa-angle-left" id="backBtn" onclick="goBack()"></i>

                <h5 class="m-0 fw-bold text-primary">Matka Game</h5>

               @include('components.walletinfo')
            </div>


            <div class="home-content">

            </div>

            @include('components.bottombar')
        </div>


        <!-- RIGHT AREA (Main Content) -->
        @include('components.rightside')

    </div>




    <!-- Bootstrap JS Bundle (Required for Modals, Toasts, Dropdowns, etc.) -->
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
