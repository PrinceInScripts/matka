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

        .game-rate-page{
display:flex;
flex-direction:column;
gap:15px;
}

.page-title{
font-weight:600;
text-align:center;
}

.rate-tabs{
display:flex;
justify-content:space-between;
background:white;
border-radius:10px;
padding:5px;
}

.rate-tabs .nav-link{
flex:1;
border-radius:8px;
text-align:center;
font-size:18px;
color:#555;
font-weight:800;

}

.rate-tabs .nav-link.active{
background:#2563eb;
color:white;
/* font-weight:900; */
}

.rate-card{
background:white;
border-radius:12px;
padding:15px;
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:10px;
box-shadow:0 2px 8px rgba(0,0,0,.05);
}

.rate-name{
font-weight:600;
display:flex;
align-items:center;
gap:8px;
}

.rate-value{
font-weight:700;
color:#2563eb;
}

.color-dot{
width:10px;
height:10px;
border-radius:50%;
display:inline-block;
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
                <div class="game-rate-page">

<h5 class="page-title">
Game Rates
</h5>

<ul class="nav nav-pills rate-tabs" id="rateTabs">

<li class="nav-item">
<button class="nav-link active" data-bs-toggle="pill" data-bs-target="#main">
Main Market
</button>
</li>

<li class="nav-item">
<button class="nav-link" data-bs-toggle="pill" data-bs-target="#starline">
Starline
</button>
</li>

<li class="nav-item">
<button class="nav-link" data-bs-toggle="pill" data-bs-target="#gali">
Gali Disawar
</button>
</li>

</ul>


<div class="tab-content">

<!-- MAIN MARKET -->

<div class="tab-pane fade show active" id="main">

@foreach($mainRates as $game)

<div class="rate-card">

<div class="rate-name">

<span class="color-dot"
style="background:{{$game->color}}"></span>

{{$game->name}}

</div>

<div class="rate-value">

10 : {{ intval($game->payout_rate * 10) }}

</div>

</div>

@endforeach

</div>


<!-- STARLINE -->

<div class="tab-pane fade" id="starline">

@foreach($starlineRates as $game)

<div class="rate-card">

<div class="rate-name">

<span class="color-dot"
style="background:{{$game->color}}"></span>

{{$game->name}}

</div>

<div class="rate-value">

10 : {{ intval($game->payout_rate * 10) }}

</div>

</div>

@endforeach

</div>


<!-- GALI DISAWAR -->

<div class="tab-pane fade" id="gali">

@foreach($galiRates as $game)

<div class="rate-card">

<div class="rate-name">

<span class="color-dot"
style="background:{{$game->color}}"></span>

{{$game->name}}

</div>

<div class="rate-value">

10 : {{ intval($game->payout_rate * 10) }}

</div>

</div>

@endforeach

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
