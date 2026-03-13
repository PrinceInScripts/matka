<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MPL Matka | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    {{-- fontawsoe --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f5f7fb;
        }

        /* Main layout */
        .login-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* LEFT SIDE (Login Area) */

        .login-left {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f7fb;
            padding: 40px 20px;
        }

        .login-box {
            width: 100%;
            max-width: 480px;
            {{-- background: #ffffff; --}}
            border-radius: 18px;
            {{-- padding: 40px 30px; --}}
            {{-- box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08); --}}
        }

        /* Logo */

        .logo {
            width: 110px;
            display: block;
            margin: 0 auto 25px auto;
            margin-bottom:60px;
        }

        /* Title */

        .title {
            text-align: center;
            font-weight: 600;
            font-size: 22px;
            margin-bottom: 28px;
        }

        /* Phone Input Layout */

        .phone-group {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        .ts-wrapper {
            width: 80px !important;
        }

        .ts-control {
            height: 52px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 10px;
            display: flex;
            align-items: center;
        }

        /* Country code */

        /* .country {
            width: 85px;
            height: 52px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 0 10px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: #fff;
        } */
        .country {
            width: 100px;
            height: 52px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            font-size: 14px;

        }

        /* Phone input */

        /* .phone-input {
            flex: 1;
            height: 52px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            font-size: 16px;
            padding: 0 14px;
        } */

        .phone-input {
            flex: 1;
            height: 52px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            font-size: 16px;
            padding: 0 14px;
            width: 100%;
        }

        .phone-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }
        .ts-wrapper.single .ts-control{
    background-image:none !important;
}

.ts-wrapper.single {
    --ts-pr-caret: 0;
}

        /* Button */

        .btn-login {
            width: 100%;
            height: 52px;
            border-radius: 12px;
            border: none;
            margin-top: 20px;
            background: #2563eb;
            color: white;
            font-size: 16px;
            font-weight: 600;
            transition: all .2s ease;
        }

        .btn-login:hover {
            background: #1d4ed8;
        }

        /* Help text */

        .help-text {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin-top: 15px;
        }

        /* RIGHT SIDE (Brand Panel) */

        .login-right {
            flex: 1;
            background: #1d4ed8;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 60px;
        }

        .login-right img {
            width: 170px;
            margin-bottom: 25px;
        }

        .login-right h3 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .login-right p {
            color: #cbd5f5;
            max-width: 420px;
            font-size: 16px;
        }


        .terms-box {
            margin-top: 14px;
            font-size: 13px;
            color: #555;
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }

        .terms-box input {
            margin-top: 3px;
        }

        .btn-login.loading {
            opacity: .8;
        }

        .title-box{
            display:flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;

        }

        .title-content{
            display:flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            gap: 6px;
            margin-bottom: 0 !important;
        }

        .title-content .title{
            color: #2563eb;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 0 !important;
        }

        .title-content .help-text{
            color: #64748b;
            font-size: 12px;
            margin-bottom: 0 !important ;
            margin-top: 0 !important ;
        }

        /* Mobile */

        @media (max-width:991px) {

            .login-wrapper {
                flex-direction: column;
            }

            .login-right {
                display: none;
            }

            .login-left {
                padding: 30px;
            }

        }
    </style>
</head>

<body>
    <div class="login-wrapper">

        <!-- Left side: Login form (always visible) -->
        <div class="login-left">
            <div class="login-box">
                {{-- <h2>MPL Matka</h2> --}}



                <div class="login-container">

                    <img src="{{ asset('https://cdn-icons-png.flaticon.com/128/5977/5977575.png') }}" class="logo"
                        alt="logo">

                     <div class="title-box">
                        <div class="title-content">
                             <h3 class="title">ENTER NUMBER</h3>
                        <p class="help-text">Enter your valid mobile number</p>   
                        </div>
                        {{-- mobile icon --}}
                        <div class="m-logo">
                          {{-- i tag mobile logo --}}
                            <i class="fa-solid fa-mobile-screen-button" style="font-size:40px;color:#2563eb;"></i>
                        </div>
                                    
                     </div>

                    <form id="loginForm">
                        @csrf

                        <div class="phone-group">
                            <select id="country_code" name="country_code" class="country">
                                <option value="+91" selected>🇮🇳 (+91)</option>
                                <option value="+1">🇺🇸 (+1)</option>
                                <option value="+44">🇬🇧 (+44)</option>
                                <option value="+971">🇦🇪 (+971)</option>
                                <option value="+61">🇦🇺 (+61)</option>
                            </select>

                            <input type="tel" id="phone" name="mobile" maxlength="10"
                                placeholder="Enter mobile number" class="phone-input">
                        </div>

                        <button type="submit" class="btn-login">
                            Continue
                        </button>

                        <div class="terms-box">
                            <input type="checkbox" id="terms" checked>
                            <label for="terms">
                                I agree to the <a href="#">Terms & Conditions</a>
                            </label>
                        </div>

                    </form>

                </div>

            </div>
        </div>

        <!-- Right side: Logo/banner (hidden on small screens) -->
        <div class="login-right">
            <img src="{{ asset('https://cdn-icons-png.flaticon.com/128/5977/5977575.png') }}" alt="MPL Matka Logo">
            <h3>Welcome to MPL Matka</h3>
            <p>Play smart, win big! Enjoy the best Matka gaming experience built for you.</p>
        </div>

    </div>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script>
        $(document).ready(function() {
            new TomSelect("#country_code", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
            $('#phone').focus();



            $('#loginForm').on('submit', function(e) {

                if (!$('#terms').is(':checked')) {
                    Toastify({
                        text: "Please accept Terms & Conditions",
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red"
                    }).showToast();
                    return;
                }
                e.preventDefault();

                const phoneInput = $('#phone').val().trim();
                const phoneRegex = /^[0-9]\d{9}$/;

                if (phoneInput === '') {
                    Toastify({
                        text: "Mobile number is required.",
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red",
                    }).showToast();
                    return;
                }


                if (!phoneRegex.test(phoneInput)) {
                    Toastify({
                        text: "Enter valid mobile number",
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red"
                    }).showToast();
                    return;
                }

                $('.btn-login').prop('disabled', true).text('Checking...');

                let formData = $(this).serialize();

                console.log(formData);

                $.ajax({
                    url: "{{ route('login') }}", // Your Laravel route
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        console.log(response);

                        Toastify({
                            text: response.message,
                            duration: 2000,
                            gravity: "top",
                            position: "center",
                            backgroundColor: response.status === "success" ? "green" :
                                "red"
                        }).showToast();

                        // Optional: redirect or clear form
                        // window.location.href = '/dashboard';

                        // if (response.status === 'success') {
                        // setTimeout(() => {
                        //     window.location.href = response.redirect;
                        // }, 1200);
                        // } else {
                        // setTimeout(() => {
                        //     window.location.href = response.redirect;
                        // }, 2000);
                        // }

                        if (response.status === "success") {
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 1200);
                        } else {
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 1200);
                            $('.btn-login').prop('disabled', false).text('Continue');
                        }
                    },


                    error: function(xhr) {

                        $('.btn-login').prop('disabled', false).text('Continue');
                        Toastify({
                            text: "Server error",
                            duration: 3000,
                            gravity: "top",
                            position: "center",
                            backgroundColor: "red"
                        }).showToast();



                        console.error(xhr);
                    }

                });
            });
        })
    </script>
</body>

</html>
