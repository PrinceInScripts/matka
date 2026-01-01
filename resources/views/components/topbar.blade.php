
@php
use App\Models\Wallet;
    use Illuminate\Support\Facades\Auth;
    
    $user=Auth::user();
    $userWallet=Wallet::where('user_id',$user->id)->first();
@endphp

<div class="top-bar">
    <i class="fa fa-bars menu-toggle" id="menuBtn"></i>
    <h5 class="m-0 fw-bold text-primary">Matka Play</h5>
    <div class="wallet">
        <i class="fa fa-wallet"></i>
        {{-- <span>₹{{ $userWallet->balance }}</span> --}}
        <span>₹ 100 </span>
    </div>
</div>
