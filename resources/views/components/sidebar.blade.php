@php $user = Auth::user(); @endphp
<div class="sidebar" id="sidebar">

  <!-- PROFILE -->
  <div class="sidebar-header">
    <div class="user-info">
      <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png">
      <div>
        <h6>{{ $user->name }}</h6>
        <small>+91 {{ $user->phone }}</small>
      </div>
    </div>
    <i class="fa fa-times close-btn" id="closebtn"></i>
  </div>

  <!-- ACCOUNT -->
  <div class="sidebar-section">
    <h6 class="section-title">Account</h6>
    <a href="{{ route('home') }}" class="menu-item"><i class="fa fa-home"></i> Home</a>
    <a href="{{ route('profile.index') }}" class="menu-item"><i class="fa fa-user"></i> Profile</a>
    <a href="{{ route('wallet') }}" class="menu-item"><i class="fa fa-wallet"></i> Wallet</a>
    <a href="{{ route('notifications.page') }}" class="menu-item"><i class="fa fa-bell"></i> Notifications</a>
    <a href="{{ route('account.statement') }}" class="menu-item"><i class="fa fa-rotate-left"></i> Account Statement</a>
  </div>

  <!-- FUNDS -->
  <div class="sidebar-section">
    <h6 class="section-title">Funds</h6>
    <a href="{{ route('deposit.funds') }}" class="menu-item"><i class="fa fa-plus-circle text-success"></i> Add Money</a>
    <a href="{{ route('withdraw.funds') }}" class="menu-item"><i class="fa fa-minus-circle text-danger"></i> Withdraw</a>
    <a href="{{ route('deposit.history') }}" class="menu-item"><i class="fa fa-arrow-down"></i> Deposit History</a>
    <a href="{{ route('withdraw.history') }}" class="menu-item"><i class="fa fa-arrow-up"></i> Withdraw History</a>
  </div>

  <!-- BIDS -->
  <div class="sidebar-section">
    <h6 class="section-title">Bids</h6>
    <a href="{{ route('my.bids') }}" class="menu-item"><i class="fa fa-receipt"></i> My Bids</a>
    {{-- <a href="{{ route('starline.bid.history') }}" class="menu-item"><i class="fa fa-star"></i> Starline Bid History</a>
    <a href="{{ route('starline.win.history') }}" class="menu-item"><i class="fa fa-trophy"></i> Starline Win History</a> --}}
  </div>

  <!-- GAMES -->
  <div class="sidebar-section">
    <h6 class="section-title">Games</h6>
    <a href="{{ route('game.rates') }}" class="menu-item"><i class="fa fa-star"></i> Game Rates</a>
    <a href="{{ route('how.to.play') }}" class="menu-item"><i class="fa fa-book"></i> How to Play</a>
  </div>

  <!-- SUPPORT -->
  <div class="sidebar-section">
    <h6 class="section-title">Support</h6>
    <a href="{{ route('support') }}" class="menu-item"><i class="fa-brands fa-whatsapp"></i> Contact / WhatsApp</a>
    <a href="{{ route('terms.conditions') }}" class="menu-item"><i class="fa fa-question-circle"></i> Terms & Conditions</a>
  </div>

  <!-- SYSTEM -->
  <div class="sidebar-section">
    <h6 class="section-title">System</h6>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="menu-item logout-btn"><i class="fa fa-sign-out"></i> Logout</button>
    </form>
  </div>

</div>
