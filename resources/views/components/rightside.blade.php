 {{-- <div class="right-area">
            <h2>Welcome to {{ $siteName }} </h2>
            <p>Play smart, win big! Enjoy the best Matka gaming experience built for you.</p>
        </div> --}}

        @php
  use App\Models\Setting;
  $sName = Setting::get('site_name') ?? 'Matka Play';
  $sLogo = Setting::get('site_logo');
@endphp
<div class="right-area">
  @if($sLogo)
    <img src="{{ asset('storage/'.$sLogo) }}" style="height:80px;width:80px;object-fit:contain;border-radius:20px;background:rgba(255,255,255,.15);padding:10px;margin-bottom:20px;">
  @else
    <div style="width:80px;height:80px;border-radius:20px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:36px;font-weight:900;color:#fff">{{ strtoupper(substr($sName,0,1)) }}</div>
  @endif
  <h2>Welcome to {{ $sName }}</h2>
  <p>Play smart, win big! Enjoy the best Matka gaming experience built for you.</p>
  <div style="margin-top:30px;display:flex;gap:10px;justify-content:center;flex-wrap:wrap;">
    <div style="background:rgba(255,255,255,.15);border-radius:12px;padding:14px 20px;font-size:13px;font-weight:600;">
      <i class="fa fa-shield-halved" style="font-size:20px;display:block;margin-bottom:6px;"></i>100% Secure
    </div>
    <div style="background:rgba(255,255,255,.15);border-radius:12px;padding:14px 20px;font-size:13px;font-weight:600;">
      <i class="fa fa-bolt" style="font-size:20px;display:block;margin-bottom:6px;"></i>Instant Payout
    </div>
    <div style="background:rgba(255,255,255,.15);border-radius:12px;padding:14px 20px;font-size:13px;font-weight:600;">
      <i class="fa fa-headset" style="font-size:20px;display:block;margin-bottom:6px;"></i>24/7 Support
    </div>
  </div>
</div>
