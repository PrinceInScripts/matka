@php
use App\Models\Wallet;
    use Illuminate\Support\Facades\Auth;
    
    $user=Auth::user();
    $userWallet=Wallet::where('user_id',$user->id)->first();
@endphp

<div class="wallet">
                    <i class="fa fa-wallet"></i>
                    <span>₹{{ $userWallet->balance }}   </span>
                </div>