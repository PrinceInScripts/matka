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
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <style>
        .home-content {
            flex: 1;
            overflow-y: auto;
            background: #f5f6fa;
            padding: 20px 15px 90px 15px;
            height: calc(100dvh - 140px);
            -webkit-overflow-scrolling: touch;
            box-sizing: border-box;
        }

        .support-page {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .support-header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 20px;
            border-radius: 14px;
            text-align: center;
        }

        .support-header i {
            font-size: 28px;
            margin-bottom: 5px;
        }

        .support-header p {
            font-size: 13px;
            opacity: .9;
            margin: 0;
        }

        .support-card {
            background: white;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
        }

        .support-title {
            font-weight: 600;
            margin-bottom: 12px;
        }

        .support-number {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .chat-btn {
            background: #25D366;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            text-decoration: none;
        }

        .support-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
            text-decoration: none;
            color: #333;
        }

        .support-option i {
            color: #2563eb;
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
                <div class="support-page">

                    <!-- SUPPORT HEADER -->
                    <div class="support-header">
                        <i class="fa fa-headset"></i>
                        <h5>Support Center</h5>
                        <p>If you need help, contact our support team</p>
                    </div>

                    <!-- WHATSAPP SUPPORT -->
                    <div class="support-card">

                        <h6 class="support-title">
                            <i class="fa-brands fa-whatsapp"></i>
                            WhatsApp Support
                        </h6>

                        <div class="support-number">
                            {{ $whatsapp1 }}

                            <a href="https://wa.me/{{ $whatsapp1 }}" target="_blank" class="chat-btn">
                                Chat
                            </a>
                        </div>

                        <div class="support-number">
                            {{ $whatsapp2 }}

                            <a href="https://wa.me/{{ $whatsapp2 }}" target="_blank" class="chat-btn">
                                Chat
                            </a>
                        </div>

                    </div>


                    <!-- OTHER SUPPORT OPTIONS -->

                    <div class="support-card">

                        <h6 class="support-title">
                            More Support Options
                        </h6>

                       <a href="tel:{{ $phone }}" class="support-option">
<i class="fa fa-phone"></i>
Call Support
</a>

                      <a href="{{ $telegram }}" target="_blank" class="support-option">
<i class="fa-brands fa-telegram"></i>
Telegram Support
</a>

                    </div>


                    <!-- HELP & LEGAL -->

                    <div class="support-card">

                        <h6 class="support-title">
                            Help & Information
                        </h6>

                        <a href="{{ route('how.to.play') }}" class="support-option">
                            <i class="fa fa-gamepad"></i>
                            How To Play
                        </a>

                        <a href="{{ route('terms.conditions') }}" class="support-option">
                            <i class="fa fa-file-contract"></i>
                            Terms & Conditions
                        </a>

                    </div>

                </div>
            </div>



            @include('components.bottombar')

            <!-- SIDEBAR -->
            @include('components.sidebar')

        </div>

        <!-- RIGHT AREA (Main Content) -->
        @include('components.rightside')


    </div>




    <!-- Bootstrap JS Bundle (Required for Modals, Toasts, Dropdowns, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>




</body>

</html>
