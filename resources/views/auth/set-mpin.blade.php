<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ $title ?? 'Matka Play' }}</title>

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
            color: #565656;
        }

        .mpin-inputs {
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
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            outline: none;
            transition: box-shadow 0.3s ease;
        }

        .mpin-inputs input:focus {
            box-shadow: 0 0 0 2px #007bff inset;
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

            .mpin-inputs input {
                width: 60px;
                height: 50px;
                border-radius: 25px;

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

                    <label class="label">Confirm MPIN</label>
                    <div class="mpin-inputs">
                        <input type="text" maxlength="1" class="confirm-mpin-input" name="confirm_mpin[]" />
                        <input type="text" maxlength="1" class="confirm-mpin-input" name="confirm_mpin[]" />
                        <input type="text" maxlength="1" class="confirm-mpin-input" name="confirm_mpin[]" />
                        <input type="text" maxlength="1" class="confirm-mpin-input" name="confirm_mpin[]" />
                    </div>

                    <button type="submit" class="login-btn">Save MPIN</button>
                </form>

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

        const confirmInputs = document.querySelectorAll('.confirm-mpin-input');

        confirmInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                const value = e.target.value.replace(/[^0-9]/g, '');
                e.target.value = value;
                if (value && index < confirmInputs.length - 1) {
                    confirmInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    confirmInputs[index - 1].focus();
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        $(document).ready(function() {
            $('#mpinForm').on('submit', function(e) {
                e.preventDefault();

                // Combine inputs into single MPIN strings
                const mpin = $('.mpin-input').map(function() {
                    return this.value;
                }).get().join('');
                const confirmMpin = $('.confirm-mpin-input').map(function() {
                    return this.value;
                }).get().join('');

                if (mpin.length < 4 || confirmMpin.length < 4) {
                    Toastify({
                        text: "MPIN is required.",
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red",
                    }).showToast();
                    return;
                }

                if (mpin !== confirmMpin) {
                    Toastify({
                        text: "MPINs do not match.",
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red",
                    }).showToast();
                    return;
                }

                $.ajax({
                    url: "{{ route('set.mpin') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        mpin: mpin
                    },
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
                            setTimeout(function() {
                                window.location.href = response.redirect;
                            }, 2600);
                        } else if (response.status === 'error' && response.redirect) {
                            setTimeout(function() {
                                window.location.href = response.redirect;
                            }, 2600);
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
