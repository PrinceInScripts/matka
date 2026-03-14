@php
  use App\Models\Wallet;
  $user = Auth::user();
  $userWallet = $user ? Wallet::where('user_id', $user->id)->first() : null;
@endphp
<a href="{{ route('wallet') }}" style="display:flex;align-items:center;gap:5px;background:#eff6ff;border-radius:20px;padding:4px 10px;text-decoration:none;">
  <i class="fa fa-wallet" style="font-size:12px;color:#2563eb;"></i>
  <span style="font-weight:700;font-size:13px;color:#1d4ed8;">₹{{ number_format($userWallet->balance ?? 0, 2) }}</span>
</a>
