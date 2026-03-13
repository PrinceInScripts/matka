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


        .info-page{
display:flex;
flex-direction:column;
gap:15px;
}

.page-title{
text-align:center;
font-weight:600;
margin-bottom:5px;
}

.info-card{
background:white;
border-radius:12px;
padding:15px;
box-shadow:0 2px 8px rgba(0,0,0,.05);
}

.info-card h6{
font-weight:600;
margin-bottom:10px;
color:#2563eb;
}

.game-rule{
border-bottom:1px solid #eee;
padding:8px 0;
}

.play-steps{
padding-left:18px;
}

.play-steps li{
margin-bottom:6px;
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
               <div class="info-page">

<h5 class="page-title">
Terms & Conditions
</h5>

<div class="info-card">

<h6>Account Rules</h6>

<ul>

<li>Only one account per user is allowed.</li>

<li>Users must provide correct information.</li>

<li>Accounts found abusing the system may be suspended.</li>

</ul>

</div>


<div class="info-card">

<h6>Betting Rules</h6>

<ul>

<li>All bets are final once placed.</li>

<li>Company is not responsible for user mistakes.</li>

<li>Results declared by the system are final.</li>

</ul>

</div>


<div class="info-card">

<h6>Wallet & Transactions</h6>

<ul>

<li>Minimum recharge and withdraw limits apply.</li>

<li>Withdraw requests are processed within working hours.</li>

<li>Fraudulent transactions will lead to account suspension.</li>

</ul>

</div>


<div class="info-card">

<h6>Support</h6>

<p>
For any issues contact support through WhatsApp listed in the Support section.
</p>

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
