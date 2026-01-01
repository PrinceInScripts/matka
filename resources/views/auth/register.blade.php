{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ $title ?? 'Matka Play' }}</title>

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
            background: linear-gradient(135deg, #007bff, #0048ff);
            color: #fff;
            padding: 40px;
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
            background: #fff;
            padding: 40px 30px;
            border-radius: 14px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
            width: 100%;
            /* max-width: 330px; */
            text-align: left;
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
            margin-bottom: 25px;
            gap: 15px;
        }

        .input-wrapper {
            position: relative;
        }

        .mpin-inputs input {
            width: 100%;
            padding: 12px 40px 12px 10px;
            border: none;
            border-radius: 24px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            outline: none;
            transition: box-shadow 0.3s ease;
        }

        .mpin-inputs input:focus {
            box-shadow: 0 0 0 2px #007bff inset;
        }

        .input-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: gray;
            /* Icon color */
            font-size: 18px;
        }

        .login-btn {
            width: 100%;
            background: #007bff;
            color: white;
            font-size: 1.1rem;
            font-weight: 500;
            padding: 14px 0;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
            transition: background 0.3s;
        }

        .login-btn:hover {
            background: #005ce6;
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
            <h1>Sign Up</h1>
            <div class="mpin-card">
                <h3>Sign Up</h3>
                <p>Create your new account</p>



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
                    </div>

                    <button type="submit" class="login-btn">Continue</button>
                </form>



                <p class="login-link">Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
            </div>
        </div>

        <!-- RIGHT: Branding Section -->
        <div class="right-area">
            <div class="brand-card">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <h3>Welcome to Matka Play</h3>
                <p>Play smart, win big! Enjoy the best Matka gaming experience built for you.</p>
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();

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
                                "red",
                        }).showToast();

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
        });
    </script>

</body>

</html>
