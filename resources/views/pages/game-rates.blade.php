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
            height: calc(100dvh - 140px);
            -webkit-overflow-scrolling: touch;
            box-sizing: border-box;
        }

        .top-bar i {
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 20px;
            background: #007bff;
            color: #fff;
        }

        /* ✅ Table Section */
        .game-rates-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-top: 15px;
        }

        .game-rates-card h5 {
            text-align: center;
            font-weight: 700;
            margin-bottom: 20px;
            color: #222;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: #007bff;
            color: #fff;
        }

        table th,
        table td {
            padding: 10px 12px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }

        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        table tbody tr:hover {
            background: #eef4ff;
        }
    </style>
</head>

<body>

    <div class="app-layout">
        <div class="left-area">
            <div class="top-bar">
                <i class="fa-solid fa-angle-left" id="backBtn" onclick="goBack()"></i>
                <h5 class="m-0 fw-bold text-primary">Game Rates</h5>
                @include('components.walletinfo')
            </div>

            <!-- ✅ HOME CONTENT -->
            <div class="home-content">

                <div class="game-rates-card">
                    <h5>Main Game Win Ratio For All Bids</h5>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Win Ratio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Single Digit</td>
                                <td>10 KA 97</td>
                            </tr>
                            <tr>
                                <td>Jodi Digit</td>
                                <td>10 KA 970</td>
                            </tr>
                            <tr>
                                <td>Single Pana</td>
                                <td>10 KA 1600</td>
                            </tr>
                            <tr>
                                <td>Double Pana</td>
                                <td>10 KA 3200</td>
                            </tr>
                            <tr>
                                <td>Triple Pana</td>
                                <td>10 KA 10000</td>
                            </tr>
                            <tr>
                                <td>Half Sangam</td>
                                <td>10 KA 10000</td>
                            </tr>
                            <tr>
                                <td>Full Sangam</td>
                                <td>10 KA 100000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            @include('components.bottombar')
        </div>

        @include('components.rightside')
    </div>

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
