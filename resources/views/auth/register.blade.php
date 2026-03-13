<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ $title ?? 'MPL Matka' }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

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
            background: #fff;
            padding: 30px;
            box-shadow: 4px 0 18px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            width: 100%;
            max-width: 600px;
            /* keeps login form limited in width on large screens */
        }

        /* RIGHT AREA (fills remaining space) */
        .right-area {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a, #1e40af, #2563eb);
            color: white;
            padding: 60px;
        }

        .page-title {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 6px;
        }

          .logo {
            width: 110px;
            display: block;
            margin: 0 auto 25px auto;
            margin-bottom:60px;
        }

        .page-sub {
            color: #6b7280;
            margin-bottom: 25px;
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
        .mpin-card {
            /* background: #fff; */
            /* padding: 36px; */
            border-radius: 18px;
            /* box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06); */
            width: 100%;
            max-width: 420px;
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

        .mpin-inputs {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin-top: 20px;
            margin-bottom: 25px;
        }

        .mpin-input:hover {
            border-color: #cbd5f1;
        }

        .input-wrapper {
            position: relative;
        }

        .mpin-input {
            width: 100%;
            height: 54px;
            padding: 0 44px 0 16px;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            font-size: 15px;
            transition: all .2s ease;
        }

        .mpin-input::placeholder {
            color: #9ca3af;
        }

        .mpin-input:focus {
            background: #ffffff;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 16px;
            cursor: pointer;
            transition: .2s;
        }

        .input-icon:hover {
            color: #2563eb;
        }



        .input-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: gray;
            font-size: 18px;
            cursor: pointer;
        }

        .login-btn {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            font-weight: 600;
            font-size: 16px;
            transition: .2s;
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

        .login-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(37, 99, 235, .3);
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9rem;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .app-layout {
                flex-direction: column;
            }

            .left-area {
                width: 100%;
                box-shadow: none;
                border-bottom: 1px solid #eee;
                height: 100vh;
            }

            .right-area {
                display: none;
            }

        }
    </style>
</head>

<body>

    <div class="app-layout">

        <!-- LEFT: MPIN Section -->
        <div class="left-area">
            
            <div class="mpin-card">

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



                <form id="registerForm">
                    @csrf
                    <div class="mpin-inputs">
                        <div class="input-wrapper">
                            <input type="text" class="mpin-input" id="name" name="name"
                                placeholder="Full Name" required />
                            <i class="fa-solid fa-user input-icon"></i>
                        </div>
                        <div class="input-wrapper">
                            <input type="email" class="mpin-input" id="email" name="email" placeholder="Email"
                                required />
                            <i class="fa-solid fa-envelope input-icon"></i>
                        </div>

                        <div class="input-wrapper">
                            <input type="password" class="mpin-input" id="password" name="password"
                                placeholder="Password" required>
                            <i class="fa-solid fa-eye toggle-password input-icon" data-target="password"></i>
                        </div>

                        <div class="input-wrapper">
                            <input type="password" class="mpin-input" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirm Password" required>
                            <i class="fa-solid fa-eye toggle-password input-icon"
                                data-target="password_confirmation"></i>
                        </div>
                    </div>

                    <button type="submit" class="login-btn" id="registerBtn">Create Account</button>
                </form>



                <p class="login-link">Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
            </div>
        </div>

        <!-- RIGHT: Branding Section -->
        <div class="right-area">
            <div class="brand-card">
                <img src="{{ asset('https://cdn-icons-png.flaticon.com/128/5977/5977575.png') }}" alt="Logo">
                <h3>Welcome to MPL Matka</h3>
                <p>Play smart, win big! Enjoy the best Matka gaming experience built for you.</p>
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            $('.toggle-password').each(function() {

                const icon = $(this);
                const target = $('#' + icon.data('target'));

                /* HOVER → preview password */

                icon.on('mouseenter', function() {

                    if (target.attr('type') === 'password') {
                        target.attr('type', 'text');
                    }

                });

                icon.on('mouseleave', function() {

                    if (!icon.hasClass('active')) {
                        target.attr('type', 'password');
                    }

                });

                /* CLICK → toggle permanent */

                icon.on('click', function() {

                    icon.toggleClass('active');

                    if (icon.hasClass('active')) {
                        target.attr('type', 'text');
                        icon.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        target.attr('type', 'password');
                        icon.removeClass('fa-eye-slash').addClass('fa-eye');
                    }

                });

            });
            /* Toggle password visibility */

            // $('.toggle-password').on('click', function() {

            //     let target = $(this).data('target');
            //     let input = $('#' + target);

            //     if (input.attr('type') === 'password') {
            //         input.attr('type', 'text');
            //         $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            //     } else {
            //         input.attr('type', 'password');
            //         $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            //     }

            // });


            /* Register form submit */

            $('#registerForm').on('submit', function(e) {

                e.preventDefault();

                let password = $('#password').val();
                let confirmPassword = $('#password_confirmation').val();

                // first check email is valid or not 
                let email = $('#email').val();
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {

                    $('#registerBtn')
                        .prop('disabled', false)
                        .text('Create Account');

                    Toastify({
                        text: "Please enter a valid email address",
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red"
                    }).showToast();

                    return;
                }

                // now check password and confirm password is greather than 8
                    if (password.length < 8) {
    
                        $('#registerBtn')
                            .prop('disabled', false)
                            .text('Create Account');
    
                        Toastify({
                            text: "Password must be at least 8 characters",
                            duration: 3000,
                            gravity: "top",
                            position: "center",
                            backgroundColor: "red"
                        }).showToast();
    
                        return;
                    }

                


                if (password !== confirmPassword) {

                    $('#registerBtn')
                        .prop('disabled', false)
                        .text('Create Account');

                    Toastify({
                        text: "Passwords do not match",
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red"
                    }).showToast();

                    return;
                }
                /* Button loading */

                $('#registerBtn')
                    .prop('disabled', true)
                    .text('Creating...');

                $.ajax({

                    type: 'POST',
                    url: '{{ route('register') }}',
                    data: $(this).serialize(),

                    success: function(response) {


                        Toastify({
                            text: response.message,
                            duration: 2500,
                            gravity: "top",
                            position: "center",
                            backgroundColor: response.status === 'success' ? "green" :
                                "red"
                        }).showToast();

                        if (response.status === 'success') {

                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 1200);

                        } else {

                            $('#registerBtn')
                                .prop('disabled', false)
                                .text('Create Account');


                        }

                    },

                    error: function(error) {
                        // console.error(error);

                        $('#registerBtn')
                            .prop('disabled', false)
                            .text('Create Account');

                        Toastify({
                            text: error.responseJSON.message,
                            duration: 3000,
                            gravity: "top",
                            position: "center",
                            backgroundColor: "red"
                        }).showToast();

                    }

                });

            });
            $('#name').focus();

        });
    </script>

</body>

</html>
