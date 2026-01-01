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
            /* left: 50%;
    transform: translateX(-50%); */
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

        /* Game type grid */
        .game-type-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 16px;
            padding: 20px;
        }

        /* Game card */
        .game-card {
            background: #fff;
            border-radius: 10px;
            text-align: center;
            padding: 20px 10px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;

        }

        .game-card .icon {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin: 0 auto 12px;
            background: var(--icon-bg, #007bff);
            /* dynamic color from DB */
            /* border: 3px solid #fff;  */
            box-shadow: 0 0 0 3px currentColor;
            /* outer ring in same color */
        }

        .game-card .icon i {
            font-size: 32px;
            color: currentColor;
            /* use dynamic color value */
            background: #fff;
            /* white fill behind icon */
            /* border-radius: 50%; */
            /* padding: 2px 4px; */
            border: 2px solid #fff;
        }


        .game-card span {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .underline {
            width: 50%;
            height: 3px;
            border-radius: 2px;
            margin: 8px auto 0;
            background: currentColor;
        }

        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.12);
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

                <h5 class="m-0 fw-bold text-primary">{{ $game->name }}</h5>

               @include('components.walletinfo')
            </div>

            <div class="home-content">
                <div class="game-type-container">
                    @foreach ($gameTypes as $type)
                        <div class="game-card" onclick="window.location.href = '/{{ $game_type }}/{{ $game->slug }}/game/{{ $type->slug }}'"  style="color: {{ $type->color }}; --icon-bg: {{ $type->color }}">
                            <div class="icon">
                                @if ($type->handle_type == 'single')
                                    <i class="fa-solid fa-dice-one"></i>
                                @elseif($type->handle_type == 'double')
                                    <i class="fa-solid fa-dice-two"></i>
                                @elseif($type->handle_type == 'triple')
                                    <i class="fa-solid fa-dice-three"></i>
                                @elseif($type->handle_type == 'fifth')
                                    <i class="fa-solid fa-dice-five"></i>
                                @else
                                    <i class="fa-solid fa-dice-six"></i>
                                @endif
                            </div>
                            <span>{{ $type->name }}</span>
                            <div class="underline"></div>
                        </div>
                    @endforeach
                </div>
            </div>

            @include('components.bottombar')

        </div>

        <!-- RIGHT AREA (Main Content) -->
        @include('components.rightside')

    </div>




        <!-- Bootstrap JS Bundle (Required for Modals, Toasts, Dropdowns, etc.) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

        <script>
            function goBack() {
                window.history.back();
            }
        </script>


</body>

</html>
