{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matka Play | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        /* Wrapper for entire page */
        .login-wrapper {
            display: flex;
            flex-wrap: wrap;
            height: 100vh;
            overflow: hidden;
        }

        /* Left login section */
        .login-left {
            background-color: #f9fafb;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            width: 100%;
            max-width: 600px;
            /* keeps login form limited in width on large screens */
        }

        .login-box {
            background-color: #fff;
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .login-box h2 {
            font-weight: 700;
            text-align: center;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .login-box p {
            text-align: center;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .login-box label {
            font-weight: 500;
            color: #333;
        }

        .login-box .form-control,
        .login-box .form-select {
            border-radius: 10px;
            padding: 10px 14px;
        }

        .btn-login {
            width: 100%;
            background-color: #007BFF;
            color: #fff;
            border-radius: 10px;
            padding: 12px;
            font-weight: 500;
            border: none;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        /* Right section (banner/logo area) */
        .login-right {
            flex: 1;
            background: linear-gradient(120deg, #11141a, #2c2f36);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-direction: column;
            padding: 40px;
        }

        .login-right img {
            width: 160px;
            margin-bottom: 20px;
        }

        .login-right h3 {
            font-weight: 600;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .login-right p {
            color: #ccc;
            font-size: 16px;
            max-width: 400px;
        }

        /* Responsive behavior */
        @media (max-width: 991px) {
            .login-wrapper {
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .login-left {
                width: 100%;
                max-width: 100%;
                height: 100vh;
            }

            .login-right {
                display: none;
                /* hide right section on mobile */
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">

        <!-- Left side: Login form (always visible) -->
        <div class="login-left">
            <div class="login-box">
                {{-- <h2>Matka Play</h2> --}}

                <form id="loginForm">
                    @csrf
                    <div class="mb-3">
                        <label style="font-size: 28px;color:#007BFF;font-weight:600" class="form-label">Enter
                            Number</label><br>
                        <label class="form-label">Enter your valid mobile number</label>
                        <div class="input-group">
                            <select class="form-select" style="max-width: 90px;" name="country_code">
                                <option selected>+91</option>
                                <option value="+1">+1</option>
                                <option value="+44">+44</option>
                                <option value="+971">+971</option>
                            </select>
                            <input type="text" id="phone" class="form-control" name="mobile" maxlength="10" placeholder="Enter your number">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-login mt-3">NEXT</button>
                </form>

            </div>
        </div>

        <!-- Right side: Logo/banner (hidden on small screens) -->
        <div class="login-right">
            <img src="{{ asset('images/logo.png') }}" alt="Matka Play Logo">
            <h3>Welcome to Matka Play</h3>
            <p>Play smart, win big! Enjoy the best Matka gaming experience built for you.</p>
        </div>

    </div>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                const phoneInput = $('#phone').val().trim();
                const phoneRegex = /^[0-9]{10,15}$/;

                if(phoneInput === '') {
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
                        text: "Please enter a valid mobile number.",
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red",
                    }).showToast();
                    return;
                }

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
                            duration: 2500,
                            gravity: "top",
                            position: "center",
                            backgroundColor: response.status === 'success' ? "green" : "red",
                            }).showToast();

                        // Optional: redirect or clear form
                        // window.location.href = '/dashboard';

                        if (response.status === 'success') {
                        setTimeout(() => {
                            window.location.href = response.redirect;
                        }, 1200);
                        } else {
                        setTimeout(() => {
                            window.location.href = response.redirect;
                        }, 2000);
                        }
                    },
                         error: function(xhr) {
                                Toastify({
                                text: "Something went wrong. Try again.",
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "red",
                                }).showToast();
                            }

                });
            });
        })
    </script>
</body>

</html>
