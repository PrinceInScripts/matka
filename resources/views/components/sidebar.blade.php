@php
    $user = Auth::user();
@endphp



<div class="sidebar" id="sidebar">

    <!-- PROFILE -->
    <div class="sidebar-header">

        <div class="user-info">
            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png">

            <div>
                <h6>{{ $user->name }}</h6>
                <small>+91 {{ $user->phone }}</small>
                {{-- <p>Since {{ $user->created_at->format('d M Y') }}</p> --}}
            </div>
        </div>

        <i class="fa fa-times close-btn" id="closebtn"></i>

    </div>


    <!-- ACCOUNT -->
    <div class="sidebar-section">

        <h6 class="section-title">Account</h6>

        <a href="{{ route('home') }}" class="menu-item">
            <i class="fa fa-home"></i> Home
        </a>

        <a href="{{ route('profile.index') }}" class="menu-item">
            <i class="fa fa-user"></i> Profile
        </a>

        <a href="{{ route('wallet') }}" class="menu-item">
            <i class="fa fa-wallet"></i> Wallet
        </a>

        <a href="{{ route('account.statement') }}" class="menu-item">
            <i class="fa fa-rotate-left"></i> Account Statement
        </a>

    </div>


    <!-- GAMES -->
    <div class="sidebar-section">

        <h6 class="section-title">Games</h6>

        <a href="{{ route('game.rates') }}" class="menu-item">
            <i class="fa fa-star"></i> Game Rates
        </a>

        {{-- <a href="#" class="menu-item">
            <i class="fa fa-dice"></i> All Markets
        </a> --}}

    </div>


    <!-- SUPPORT -->
    <div class="sidebar-section">

        <h6 class="section-title">Support</h6>

        <a href="support" class="menu-item">
            <i class="fa-brands fa-whatsapp"></i> Contact / WhatsApp
        </a>

        <a href="terms-conditions" class="menu-item">
            <i class="fa fa-question-circle"></i> Terms & Conditions
        </a>

        <a href="how-to-play" class="menu-item">
            <i class="fa fa-book"></i> How to Play
        </a>

    </div>


    <!-- SYSTEM -->
    <div class="sidebar-section">

        <h6 class="section-title">System</h6>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="menu-item logout-btn">
                <i class="fa fa-sign-out"></i> Logout
            </button>
        </form>

    </div>

</div>
