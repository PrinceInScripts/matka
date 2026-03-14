@php
  use App\Models\Setting;
  $siteName = Setting::get('site_name') ?? 'Matka Play';
  $siteLogo = Setting::get('site_logo');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ $title ?? 'MPL Matka' }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        :root {
            --left-width: 400px;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            font-family: "Poppins", sans-serif;
            background: #f5f6fa;
        }

        /* Layout */
        .app-layout {
            display: flex;
            min-height: 100vh;
        }

        /* LEFT AREA (always visible) */
        .left-area {
            width: var(--left-width);
            /* background: #fff; */
            /* padding: 30px; */
            /* box-shadow: 4px 0 18px rgba(0, 0, 0, 0.05); */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            /* padding: 40px 20px; */
            width: 100%;
            max-width: 600px;
            /* keeps login form limited in width on large screens */
        }

        /* RIGHT AREA (fills remaining space) */
        /* .right-area {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #007bff, #0048ff);
      color: #fff;
      padding: 40px;
    } */

        .right-area {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background:  #1e40af;
            color: white;
            padding: 60px;
        }

        .brand-card p {
            color: #cbd5f5;
        }

        .brand-card {
            text-align: center;
            max-width: 480px;
        }

        .brand-card img {
            width: 140px;
            margin-bottom: 18px;
        }

        .brand-card h3 {
            font-size: 28px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .brand-card p {
            color: #d8e1f0;
            line-height: 1.5;
        }

        /* MPIN Card */
        /* .mpin-card {
      background: #fff;
      padding: 40px 30px;
      border-radius: 14px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.08);
      width: 100%;
      text-align: left;
    } */

        .mpin-card {
            background: #fff;
            padding: 42px 32px;
            border-radius: 18px;
            /* box-shadow: 0 18px 45px rgba(0, 0, 0, 0.08); */
            width: 100%;
            max-width: 400px;
        }

        .mpin-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0066ff;
            margin-bottom: 5px;
        }

        .mpin-card p {
            color: #666;
            margin-bottom: 20px;
        }

        .label {
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        /* .mpin-inputs {
      display: flex;
      justify-content: space-between;
      margin-bottom: 25px;
    }

    .mpin-inputs input {
      width: 80px;
      height: 60px;
      text-align: center;
      font-size: 24px;
      border: none;
      border-radius: 24px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
      outline: none;
      transition: box-shadow 0.3s ease;
    }

    .mpin-inputs input:focus {
      box-shadow: 0 0 0 2px #007bff inset;
    } */

        .mpin-inputs {
            display: flex;
            justify-content: center;
            gap: 35px;
            margin: 25px 0;
        }

        .mpin-input {
            width: 56px;
            height: 56px;
            text-align: center;
            font-size: 22px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            outline: none;
            font-weight: 600;
            transition: all .2s ease;
        }

        .mpin-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        /* .login-btn {
      width: 100%;
      background: #007bff;
      color: white;
      font-size: 1.1rem;
      font-weight: 500;
      padding: 14px 0;
      border: none;
      border-radius: 30px;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(0,123,255,0.3);
      transition: background 0.3s;
    }

    .login-btn:hover {
      background: #005ce6;
    } */

        .login-btn {
            width: 100%;
            height: 52px;
            border-radius: 12px;
            border: none;
            background: #2563eb;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            transition: all .2s ease;
        }

        @keyframes shake {
            0% {
                transform: translateX(0)
            }

            25% {
                transform: translateX(-6px)
            }

            50% {
                transform: translateX(6px)
            }

            75% {
                transform: translateX(-6px)
            }

            100% {
                transform: translateX(0)
            }
        }

        .shake {
            animation: shake .3s;
        }

        .login-btn:hover {
            background: #1d4ed8;
        }

        /* Responsive */
        @media (max-width:991px) {

            .right-area {
                display: none;
            }

            .left-area {
                width: 100%;
                max-width: 420px;
                margin: auto;
            }

            .mpin-input {
                width: 50px;
                height: 50px;
            }
        }
    </style>
</head>

<body>

    <div class="app-layout">

        <!-- LEFT: MPIN Section -->
        <div class="left-area">
            <div class="mpin-card">
                <h3>MPIN</h3>
                <p>Enter MPIN for login</p>
                <form id="mpinForm">
                    @csrf
                    <label class="label">Enter MPIN</label>
                    <div class="mpin-inputs">
                        <input type="text" maxlength="1" class="mpin-input" name="mpin[]" />
                        <input type="text" maxlength="1" class="mpin-input" name="mpin[]" />
                        <input type="text" maxlength="1" class="mpin-input" name="mpin[]" />
                        <input type="text" maxlength="1" class="mpin-input" name="mpin[]" />
                    </div>

                    <button type="submit" class="login-btn">Login</button>
                </form>
            </div>
        </div>

        <!-- RIGHT: Branding Section -->
        <div class="right-area">
            <div class="brand-card">
                <img src="{{ asset('https://cdn-icons-png.flaticon.com/128/5977/5977575.png') }}" alt="Logo">
                <h3>Welcome to {{ $siteName }} </h3>
                <p>Play smart, win big! Enjoy the best Matka gaming experience built for you.</p>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-focus MPIN input logic
        const inputs = document.querySelectorAll('.mpin-input');

        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                const value = e.target.value.replace(/[^0-9]/g, '');
                e.target.value = value;
                if (value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        $(document).ready(function() {

            const inputs = document.querySelectorAll('.mpin-input');

            /* Focus first input when page loads */
            if (inputs.length) {
                inputs[0].focus();
            }

            /* INPUT CONTROL */
            inputs.forEach((input, index) => {

                input.addEventListener('input', function(e) {

                    let value = e.target.value.replace(/[^0-9]/g, '');
                    e.target.value = value;

                    if (value && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }

                    /* Auto submit when last digit entered */
                    if (index === inputs.length - 1 && value) {
                        document.getElementById("mpinForm").requestSubmit();
                    }

                });

                input.addEventListener('keydown', function(e) {

                    if (e.key === "Backspace" && !input.value && index > 0) {
                        inputs[index - 1].focus();
                    }

                });

            });


            /* FORM SUBMIT */
            $('#mpinForm').on('submit', function(e) {

                e.preventDefault();

                const mpin = $('.mpin-input').map(function() {
                    return this.value;
                }).get().join('');

                if (mpin.length < 4) {

                    $('.login-btn')
                        .prop('disabled', false)
                        .text('Unlock');

                    Toastify({
                        text: "Please enter your MPIN",
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red"
                    }).showToast();

                    return;
                }

                /* Button loading */
                $('.login-btn')
                    .prop('disabled', true)
                    .text('Checking...');


                $.ajax({

                    url: "{{ route('authenticate.mpin') }}",
                    type: "POST",

                    data: {
                        _token: "{{ csrf_token() }}",
                        mpin: mpin
                    },

                    success: function(response) {

                        Toastify({
                            text: response.message,
                            duration: 2500,
                            gravity: "top",
                            position: "center",
                            backgroundColor: response.status === "success" ? "green" :
                                "red"
                        }).showToast();


                        if (response.status === "success") {

                            setTimeout(function() {
                                window.location.href = response.redirect;
                            }, 1200);

                        } else {

                            /* Shake animation */
                            $('.mpin-inputs').addClass('shake');

                            setTimeout(function() {
                                $('.mpin-inputs').removeClass('shake');
                            }, 300);

                            /* Clear inputs */
                            $('.mpin-input').val('');
                            inputs[0].focus();

                            $('.login-btn')
                                .prop('disabled', false)
                                .text('Unlock');

                        }

                    },

                    error: function() {

                        $('.login-btn')
                            .prop('disabled', false)
                            .text('Unlock');

                        Toastify({
                            text: "Server error. Try again.",
                            duration: 3000,
                            gravity: "top",
                            position: "center",
                            backgroundColor: "red"
                        }).showToast();

                    }

                });

            });

        });
    </script>

</body>

</html>
