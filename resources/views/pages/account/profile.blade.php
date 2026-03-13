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
        /* ✅ SCROLLABLE CONTENT ONLY */
        .home-content {
            flex: 1;
            overflow-y: auto;
            background: #f5f6fa;
            padding: 20px 15px 90px 15px;
            height: calc(100dvh - 140px);
            -webkit-overflow-scrolling: touch;
            box-sizing: border-box;
        }

        .profile-page {
            padding: 10px;
        }

        .profile-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .05);
            overflow: hidden;
        }

        .profile-header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            text-align: center;
            padding: 25px 15px;
        }

        .profile-header img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 3px solid white;
            margin-bottom: 10px;
        }

        .profile-header h5 {
            margin: 5px 0;
            font-weight: 600;
        }

        .profile-header p {
            margin: 0;
            font-size: 14px;
            opacity: .9;
        }

        .member-since {
            font-size: 12px;
            display: block;
            margin-top: 4px;
            opacity: .8;
        }

        .profile-body {
            padding: 15px;
        }

        .profile-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f1f1f1;
            font-size: 14px;
        }

        .profile-row span {
            color: #777;
        }

        .profile-row strong {
            color: #333;
        }

        .profile-actions {
            padding: 15px;
            display: flex;
            gap: 10px;
        }

        .profile-btn {
            flex: 1;
            border: none;
            background: #f1f5ff;
            color: #2563eb;
            padding: 10px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .profile-btn:hover {
            background: #2563eb;
            color: white;
        }

        .modal-content {
            border-radius: 14px;
            border: none;
        }

        .modal-header {
            border-bottom: 1px solid #eee;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .1);
        }

        .modal-header {
            border-bottom: 1px solid #f1f1f1;
            padding: 16px 20px;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-title {
            font-weight: 600;
            color: #2563eb;
        }

        .modal-input {
            width: 100%;
            height: 50px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            padding: 0 14px;
            font-size: 14px;
            margin-bottom: 12px;
            transition: .2s;
        }

        .modal-input:focus {
            background: #fff;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .15);
            outline: none;
        }

        .modal-btn {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            font-weight: 600;
            font-size: 15px;
            transition: .2s;
        }

        .modal-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(37, 99, 235, .3);
        }

        .mpin-inputs {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .mpin-input {
            width: 55px;
            height: 55px;
            border-radius: 10px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 20px;
            font-weight: 600;
        }

  
.btn-close{
opacity:.8;
}


@media (max-width:768px){

.modal-dialog{
margin:0;
position:fixed;
bottom:0;
width:100%;
}

.modal-content{
border-radius:16px 16px 0 0;
}

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

                <div class="profile-page">

                    <div class="profile-card">

                        <div class="profile-header">

                            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png">

                            <h5>{{ Auth::user()->name }}</h5>

                            <p>+91 {{ Auth::user()->phone }}</p>

                            <span class="member-since">
                                Member since {{ Auth::user()->created_at->format('d M Y') }}
                            </span>

                        </div>

                        <div class="profile-body">

                            <div class="profile-row">
                                <span>User ID</span>
                                <strong>#{{ Auth::user()->id }}</strong>
                            </div>

                            <div class="profile-row">
                                <span>Name</span>
                                <strong>{{ Auth::user()->name }}</strong>
                            </div>

                            <div class="profile-row">
                                <span>Phone</span>
                                <strong>+91 {{ Auth::user()->phone }}</strong>
                            </div>

                            <div class="profile-row">
                                <span>Email</span>
                                <strong>{{ Auth::user()->email ?? 'Not Added' }}</strong>
                            </div>

                            <div class="profile-row">
                                <span>Account Created</span>
                                <strong>{{ Auth::user()->created_at->format('d M Y') }}</strong>
                            </div>

                        </div>

                        <div class="profile-actions">

                            <button class="profile-btn" data-bs-toggle="modal" data-bs-target="#changePasswordModal">

                                <i class="fa fa-key"></i>
                                Change Password

                            </button>



                            <button class="profile-btn" data-bs-toggle="modal" data-bs-target="#verifyPasswordModal">

                                <i class="fa fa-lock"></i>
                                Change MPIN

                            </button>

                        </div>

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

    <div class="modal fade" id="changePasswordModal">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">
                    <h5>Change Password</h5>
                    <button type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close">
    </button>
                </div>

                <div class="modal-body">

                    <form id="changePasswordForm">
                        @csrf

                        <input type="password" name="old_password" class="form-control mb-3" placeholder="Old Password">

                        <input type="password" name="new_password" class="form-control mb-3" placeholder="New Password">

                        <input type="password" name="new_password_confirmation" class="form-control"
                            placeholder="Confirm Password">

                        <button class="btn btn-primary w-100 mt-3">
                            Update Password
                        </button>

                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="verifyPasswordModal">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5>Verify Password</h5>
                    <button type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close">
    </button>
                </div>

                <div class="modal-body">

                    <form id="verifyPasswordForm">
                        @csrf

                        <input type="password" name="password" class="form-control" placeholder="Enter Password">

                        <button class="btn btn-primary w-100 mt-3">
                            Continue
                        </button>

                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="changeMpinModal">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">
                    <h5>Change MPIN</h5>
                    <button type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close">
    </button>
                </div>

                <div class="modal-body">

                    <form id="changeMpinForm">
                        @csrf

                        <div class="mpin-inputs">

                            <input type="text" maxlength="1" class="mpin-input">
                            <input type="text" maxlength="1" class="mpin-input">
                            <input type="text" maxlength="1" class="mpin-input">
                            <input type="text" maxlength="1" class="mpin-input">

                        </div>

                        <button class="btn btn-primary w-100 mt-3">
                            Update MPIN
                        </button>

                    </form>

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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script>
        const mpinInputs = document.querySelectorAll('.mpin-input');

        mpinInputs.forEach((input, index) => {

            input.addEventListener('input', function() {

                this.value = this.value.replace(/[^0-9]/g, '');

                if (this.value && index < mpinInputs.length - 1) {
                    mpinInputs[index + 1].focus();
                }

                checkMpinComplete();

            });

            input.addEventListener('keydown', function(e) {

                if (e.key === "Backspace" && !this.value && index > 0) {
                    mpinInputs[index - 1].focus();
                }

            });

        });

        function checkMpinComplete() {

            let mpin = '';

            mpinInputs.forEach(input => mpin += input.value);

            if (mpin.length === 4) {

                $('#changeMpinForm').submit();

            }

        }
        $('#changePasswordForm').submit(function(e) {

            e.preventDefault();

            $.post("{{ route('change.password') }}",
                $(this).serialize(),

                function(res) {

                    Toastify({
                        text: res.message,
                        backgroundColor: res.status === 'success' ? 'green' : 'red'
                    }).showToast();

                    if (res.status === 'success') {
                        bootstrap.Modal.getInstance(document.getElementById('changePasswordModal')).hide();
                    }

                });

        });


        $('#verifyPasswordForm').submit(function(e) {

            e.preventDefault();

            $.post("{{ route('verify.password') }}",
                $(this).serialize(),

                function(res) {

                    if (res.status === 'success') {
                        $('#verifyPasswordForm')[0].reset();

                        bootstrap.Modal.getInstance(document.getElementById('verifyPasswordModal')).hide();

                        new bootstrap.Modal(document.getElementById('changeMpinModal')).show();
                        $('.mpin-input').val('');
                        $('.mpin-input').first().focus();

                    } else {

                        Toastify({
                            text: res.message,
                            backgroundColor: 'red'
                        }).showToast();

                    }

                });

        });


        $('#changeMpinForm').submit(function(e) {

            e.preventDefault();

            let mpin = '';

            $('.mpin-input').each(function() {
                mpin += this.value;
            });

            $.post("{{ route('change.mpin') }}", {
                mpin: mpin
            }, function(res) {

                Toastify({
                    text: res.message,
                    backgroundColor: res.status === 'success' ? 'green' : 'red'
                }).showToast();

                if (res.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('changeMpinModal')).hide();
                    $('.mpin-input').val('');
                }

            });

        });
    </script>



</body>

</html>
