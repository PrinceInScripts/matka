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

<link href="https://pro.fontawesome.com/releases/v6.5.2/css/all.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />


    <style>
       


        /* ✅ SCROLLABLE CONTENT ONLY */
        .home-content {
            flex: 1;
            overflow-y: auto;
            background: #f5f6fa;
            padding: 60px 15px 90px 15px;
            /* extra padding for fixed bars */
            height: calc(100dvh - 140px);
            -webkit-overflow-scrolling: touch;
            box-sizing: border-box;
        }

        .notice-box {
            background: #fff;
            border-left: 6px solid #007bff;
            border-radius: 12px;
            padding: 4px 15px;
            text-align: center;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .notice-box span {
            color: #007bff;
            font-weight: 700;
        }

        .contact-row {
            display: flex;
            justify-content: space-around;

            gap: 15px;
            margin-bottom: 20px;
        }

        .contact-row i {
            font-size: 20px;
            margin-right: 8px;
            color: #25d366
        }

        .contact-row span {
            font-size: 18px;
            font-weight: 600;
            color: #0048ff;
        }

        .contact-row a {
            color: #25d366;
            font-weight: 600;
            text-decoration: none;
        }

        /* MARKET CARD */
        .market-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
            padding: 15px 20px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .market-card .left-side {
            max-width: 80%;
        }

        .market-card .right-side {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 10px;
            align-items: flex-end;
        }

        .market-card .right-side button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .market-card .right-side button i {
            font-size: 34px;
            color: #007bff;

        }

        .market-card .right-side .fa-circle-play {
            font-size: 40px;
            border: 2px solid #007bff;
            border-radius: 50%;
            padding: 6px;

        }

        .market-card .left-side .times {
            margin-top: 6px;
            line-height: 1.4;
            display: flex;
            flex-direction: column;
        }

        .market-card .left-side .times span {
            min-width: auto;
            color: #007bff;
            font-weight: 700;
        }



        .market-card h5 {
            font-weight: 700;
            color: #333;
            margin-bottom: 0px;
            font-size: 18px;
        }

        .market-card small {
            color: #999;
        }

        .market-card .running {
            color: #008000;
            font-weight: 600;
            margin-top: 2px;
        }

        .market-card .show {
            color: #007BFF;
            font-size: 16px;
            font-weight: 600;
        }

        .market-card .closed {
            color: #007BFF;
            font-weight: 600;
            margin-top: 5px;
        }

        .market-card .times {
            font-size: 14px;
            margin-top: 6px;
        }

        .market-card .times span {
            display: inline-block;
            min-width: 130px;
            color: #555;
        }

        .info {
            color: #007bff;
        }

        .market-card .icon-btn {
            float: right;
            color: #007bff;
            font-size: 20px;
        }

        .history-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 10px;
        }

        .history-buttons button {
            flex: 1;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 0;
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            cursor: pointer;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .top-bar i{
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 20px;
            background: #007bff;
            color: #fff;
        }




    </style>

</head>

<body>

    <div class="overlay" id="overlay"></div>

    <div class="app-layout">
        <!-- LEFT AREA -->
        <div class="left-area">
             <div class="top-bar">
                <!-- Back Button -->
                <i class="fa-solid fa-angle-left" id="backBtn" onclick="goBack()"></i>

                <h5 class="m-0 fw-bold text-primary">Play Starline</h5>

                @include('components.walletinfo')
            </div>
            <div class="home-content" style="padding-top: 80px">
                <div class="notice-box">
                    <span>Single Digit : </span> 10-100
                </div>
                <div class="notice-box">
                    <span>Single Panna : </span> 10-1600
                </div>
                <div class="notice-box">
                    <span>Double Panna : </span> 10-3200
                </div>
                <div class="notice-box">
                    <span>Triple Panna : </span> 10-700
                </div>

                <div class="history-buttons ">
                   <button><i class="fa-solid fa-history"></i>
                        <span>Bid History</span></button>
                    <button><i class="fa-solid fa-trophy"></i>
                        <span>Win History</span></button>
                </div>

               
              

                

                @foreach ($games as $game)
<div class="market-card">
    <div class="left-side">
        <h5>{{ $game->name }}</h5>

        <div class="show">
            {{ $game->open_pana ?: '***' }} -
            {{ $game->open_digit ?? '**' }}{{ $game->close_digit ?? '**' }} -
            {{ $game->close_pana ?: '***' }}
        </div>

        <div class="{{ $game->is_live ? 'running' : 'closed' }}">
            {{ $game->user_message }}
        </div>

        <div class="times">
            <div>Last Bids Open:
                <span class="info">{{ $game->open_time_format }}</span>
            </div>
            <div>Last Bids Close:
                <span class="info">{{ $game->close_time_format }}</span>
            </div>
        </div>
    </div>

    <div class="right-side">
        <button class="calendar-btn">
            <i class="fa-solid fa-calendar-days"></i>
        </button>

        <button class="play-btn"
            data-live="{{ $game->is_live }}"
            data-message="{{ $game->user_message }}"
            data-slug="{{ $game->slug }}">
            <i class="fa-solid fa-circle-play"></i>
        </button>
    </div>
</div>
@endforeach

            </div>

            @include('components.bottombar')

            <!-- SIDEBAR -->
            @include('components.sidebar')

        </div>

        <!-- RIGHT AREA (Main Content) -->
        @include('components.rightside')

      
      </div>


        <!-- Chart Modal -->
        <div class="modal fade" id="chartModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 rounded-4 shadow-sm">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">CHART INFO</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body pb-4">
                        <!-- Chart Buttons -->
                        <div
                            class="chart-option d-flex justify-content-between align-items-center p-3 mb-3 rounded-3 shadow-sm">
                            <span class="fw-semibold">Jodi Chart</span>
                            <i class="fa fa-angle-right text-secondary"></i>
                        </div>

                        <div
                            class="chart-option d-flex justify-content-between align-items-center p-3 rounded-3 shadow-sm">
                            <span class="fw-semibold">Pana Chart</span>
                            <i class="fa fa-angle-right text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Bootstrap JS Bundle (Required for Modals, Toasts, Dropdowns, etc.) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        {{-- jquery --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            const chartModal = new bootstrap.Modal(document.getElementById('chartModal'));

            // When user clicks Calendar
            document.querySelectorAll('.calendar-btn').forEach(btn => {
                btn.addEventListener('click', () => {

                    chartModal.show();
                });
            });


            // When user clicks Play
           $(document).on('click', '.play-btn', function () {

    const isLive  = $(this).data('live');
    const message = $(this).data('message');
    const slug    = $(this).data('slug');

    if (!isLive) {
        Swal.fire({
            icon: 'warning',
            title: 'Betting Closed',
            text: message
        });
        return;
    }

    // Allowed → redirect
    window.location.href = '/starline/' + slug;
});


              function goBack() {
            window.history.back();
        }

        </script>


</body>

</html>
