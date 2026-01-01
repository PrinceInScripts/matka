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
    </style>

</head>

<body>

    {{-- <div class="overlay" id="overlay"></div> --}}

    <div class="app-layout">
        <!-- LEFT AREA -->
        <div class="left-area">
            @include('components.topbar');

            <div class="home-content">
                <div class="notice-box">
                    <span>Matka Play</span> ALL MARKET HAVE BEEN DECLARED AS HOLIDAY...<br>
                    {{-- We Wish You And Your Family A Very Happy <span>DIWALI</span>. --}}
                </div>

                <div class="contact-row">
                    <a href="https://wa.me/919694149535"><i class="fa-brands fa-whatsapp"></i>
                        <span>+919694149535</span></a>
                    <a href="https://wa.me/919694149535"><i class="fa-brands fa-whatsapp"></i>
                        <span>+919694149535</span></a>
                </div>

                <div class="other-card" onclick="window.location.href='/starline'">
                    <div class="design">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <h5>Play Starline </h5>
                    <div class="design">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
                <div class="other-card gali">
                    <div class="design">
                        <i class="fa-solid fa-diamond-turn-right"></i>
                        <i class="fa-solid fa-diamond-turn-right"></i>
                        <i class="fa-solid fa-diamond-turn-right"></i>
                    </div>
                    <h5>Gali Disawar</h5>
                    <div class="design">
                        <i class="fa-solid fa-diamond-turn-right"></i>
                        <i class="fa-solid fa-diamond-turn-right"></i>
                        <i class="fa-solid fa-diamond-turn-right"></i>
                    </div>
                </div>


                {{-- <div class="market-card">
                    <div class="left-side">
                        <h5>KARNATAKA DAY </h5>
                        <small>***_**_***</small>
                        <div class="show">160-70-578</div>
                        <div class="running">Betting Is Running Now</div>
                        <div class="closed">Betting Is Closed For Today</div>
                        <div class="times">
                            <div>Last Bids Time Open: <span class="info">09:40 am</span></div>
                            <div>Last Bids Time Close: <span class="info">10:40 am</span></div>
                        </div>
                    </div>
                    <div class="right-side">
                        <button><i class="fa-solid fa-calendar-days"></i></button>
                        <button><i class="fa-solid fa-circle-play"></i></button>
                    </div>
                </div> --}}

                @foreach ($games as $game)
                    <div class="market-card">
                        <div class="left-side">
                            <h5>{{ $game->name }}</h5>
                            @if ($game->open_pana || $game->close_pana)
                                <div class="show">{{ $game->open_pana }} -
                                    {{ $game->open_digit }}{{ $game->close_digit }} - {{ $game->close_pana }}</div>
                            @else
                                <div class="show">***_**_***</div>
                            @endif

                            @if ($game->is_live)
                                <div class="running">Betting Is Running Now</div>
                            @else
                                <div class="closed">{{ $game->user_message }}</div>
                            @endif

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
                            <button class="calendar-btn" data-game="{{ $game->name }}">
                                <i class="fa-solid fa-calendar-days"></i></button>
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
        const chartModal = new bootstrap.Modal(document.getElementById('chartModal'));

        // When user clicks Calendar
        document.querySelectorAll('.calendar-btn').forEach(btn => {
            btn.addEventListener('click', () => {

                chartModal.show();
            });
        });


       

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
