<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MPL Matka | Home</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    {{-- <link href="https://pro.fontawesome.com/releases/v6.5.2/css/all.css" rel="stylesheet"> --}}

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />


    <style>
        /* ✅ SCROLLABLE CONTENT ONLY */
        .home-content {
            flex: 1;
            overflow-y: auto;
            background: #f5f6fa;
            padding: 20px 15px 90px 15px;
            /* extra padding for fixed bars */
            height: calc(100dvh - 140px);
            -webkit-overflow-scrolling: touch;
            box-sizing: border-box;
        }

        /* .notice-box {
            background: #fff;
            border-left: 6px solid #007bff;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .notice-box span {
            color: #007bff;
            font-weight: 700;
        } */

        .announcement {
            background: #fff;
            border-left: 5px solid #2563eb;
            padding: 14px 16px;
            border-radius: 12px;
            font-weight: 600;
            margin-bottom: 14px;
            padding: 15px;
            text-align: center;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .announcement .brand {
            color: #2563eb;
            font-weight: 700;
            margin-right: 6px;
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


        .quick-actions {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }

        .action-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            color: white;
        }

        .deposit {
            background: #22c55e;
        }

        .withdraw {
            background: #ef4444;
        }

        .support-box {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            background: white;
            border-radius: 12px;
            margin-bottom: 16px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, .05);
        }

        .support-box a {
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            font-weight: 600;
            color: #22c55e;
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
            /* color: #007BFF; */
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

        .game-section {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 16px;
        }

        .game-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            padding: 14px;
            border-radius: 14px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .05);
            text-decoration: none;
            transition: .2s;
        }

        .game-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
        }

        .game-icon {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #e0edff;
            color: #2563eb;
            font-size: 18px;
        }

        .game-info {
            flex: 1;
            margin-left: 12px;
        }

        .game-info h4 {
            margin: 0;
            font-weight: 600;
            font-size: 16px;
            color: #333;
        }

        .game-info p {
            margin: 0;
            font-size: 13px;
            color: #777;
        }

        .game-play {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
        }

        .other-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
            padding: 15px 20px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }

        .other-card .design {
            display: flex;
            align-items: center;
            gap: 3px;

        }

        .other-card .design i {
            font-size: 20px;
            color: #007bff;
        }



        .other-card h5 {
            font-weight: 700;
            color: #333;
            margin-bottom: 0px;
            font-size: 22px;
        }

        .other-card .fa-calendar-days {
            font-size: 20px;
            color: #007bff;
            margin-right: 8px;
        }

        .play-btn[data-live="0"] {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .market-status{
font-weight:600;
margin-top:4px;
}

.running{
color:#28a745;
}

.waiting{
color:#ff9800;
}

.closed{
color:#dc3545;
}
    </style>

</head>

<body>

    {{-- <div class="overlay" id="overlay"></div> --}}

    <div class="app-layout">
        <!-- LEFT AREA -->
        <div class="left-area">
            @include('components.topbar')

            <div class="home-content">
                {{-- <div class="announcement">
                    <span class="brand">MPL Matka</span>
                    ALL MARKET HAVE BEEN DECLARED AS HOLIDAY...
                </div> --}}

                @if ($announcement)
                    <div class="announcement">

                        <span class="brand">{{ $announcement->title }}</span>

                        {{ $announcement->message }}

                    </div>
                @endif

                <div class="support-box">

                    <a href="https://wa.me/919694149535" target="_blank">
                        <i class="fa-brands fa-whatsapp"></i>
                        +91 9694149535
                    </a>

                    <a href="https://wa.me/919694149535" target="_blank">
                        <i class="fa-brands fa-whatsapp"></i>
                        +91 9694149535
                    </a>

                </div>

                <div class="quick-actions">

                    <a href="/deposit-funds" class="action-btn deposit">
                        <i class="fa fa-plus-circle"></i>
                        <span>Deposit</span>
                    </a>

                    <a href="/withdraw-funds" class="action-btn withdraw">
                        <i class="fa fa-arrow-up"></i>
                        <span>Withdraw</span>
                    </a>

                </div>

                <div class="game-section">

                    <a href="/starline" class="game-card starline">

                        <div class="game-icon">
                            <i class="fa fa-star"></i>
                        </div>

                        <div class="game-info">
                            <h4>Starline</h4>
                            <p>Fast result market</p>
                        </div>

                        <div class="game-play">
                            <i class="fa fa-play"></i>
                        </div>

                    </a>


                    <a href="/galidisawar" class="game-card gali">

                        <div class="game-icon">
                            <i class="fa fa-diamond"></i>
                        </div>

                        <div class="game-info">
                            <h4>Gali Disawar</h4>
                            <p>Classic matka market</p>
                        </div>

                        <div class="game-play">
                            <i class="fa fa-play"></i>
                        </div>

                    </a>

                </div>



                @foreach ($games as $game)
                    <div class="market-card">
                        <div class="left-side">
                            <h5>{{ $game->name }}</h5>
                            @if ($game->open_pana || $game->close_pana)
                                <div class="show">
                                    {{ $game->open_pana ?? '***' }}-
                                    {{ $game->open_digit ?? '*' }}
                                    {{ $game->close_digit ?? '*' }}-
                                    {{ $game->close_pana ?? '***' }}
                                </div>
                            @else
                                <div class="show">***-*-*-***</div>
                            @endif

                            <div class="market-status {{ $game->status_class }}">
                                {{ $game->user_message }}
                            </div>

                            <div class="times">
                                <div>
                                    Last Bids Time Open:
                                    <span class="info">
                                        {{ $game->today_open_time ? date('h:i A', strtotime($game->today_open_time)) : '--' }}
                                    </span>
                                </div>
                                <div>
                                    Last Bids Time Close:
                                    <span class="info">
                                        {{ $game->today_close_time ? date('h:i A', strtotime($game->today_close_time)) : '--' }}
                                    </span>
                                </div>
                            </div>

                        </div>
                        <div class="right-side">
                            <a href="{{ route('chart', ['market_type' => 'main', 'slug' => $game->slug]) }}"
                                class="calendar-btn"
                                style="display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:32px">
                                <i class="fa-solid fa-calendar-days"></i></a>
                            <button class="play-btn" data-live="{{ $game->is_live ? 1 : 0 }}"
                                data-message="{{ $game->user_message }}" data-slug="{{ $game->slug }}">
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

                    <div class="chart-option d-flex justify-content-between align-items-center p-3 rounded-3 shadow-sm">
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
        // const chartModal = new bootstrap.Modal(document.getElementById('chartModal'));

        // When user clicks Calendar
        // document.querySelectorAll('.calendar-btn').forEach(btn => {
        //     btn.addEventListener('click', () => {

        //         chartModal.show();
        //     });
        // });




        $(document).on('click', '.play-btn', function() {
            let isLive = $(this).data('live');
            let message = $(this).data('message');
            let slug = $(this).data('slug');

            if (!isLive) {
                Swal.fire({
                    icon: 'info',
                    title: 'Betting Unavailable',
                    text: message
                });
                return;
            }

            // allowed
            window.location.href = '/market/' + slug;
        });
    </script>


</body>

</html>
