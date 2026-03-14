@php
  use App\Models\Setting;
  $user = Auth::user();
  $balance = $user && $user->wallet ? $user->wallet->balance : 0;
  $siteName = Setting::get('site_name') ?? 'Matka Play';
  $siteLogo = Setting::get('site_logo');
@endphp
<style>
.topbar{display:flex;align-items:center;justify-content:space-between;padding:0 14px;background:white;box-shadow:0 2px 10px rgba(0,0,0,.07);position:fixed;top:0;left:0;right:0;max-width:500px;margin:auto;z-index:1000;height:56px;}
.topbar-left{display:flex;align-items:center;gap:12px;}
.topbar-brand{display:flex;align-items:center;gap:8px;text-decoration:none;}
.topbar-logo{height:34px;width:34px;object-fit:contain;border-radius:8px;}
.topbar-logo-placeholder{height:34px;width:34px;border-radius:8px;background:linear-gradient(135deg,#2563eb,#1d4ed8);display:flex;align-items:center;justify-content:center;color:white;font-weight:900;font-size:14px;}
.topbar-name{font-size:16px;font-weight:800;color:#1e40af;letter-spacing:.3px;line-height:1;}
.topbar-right{display:flex;align-items:center;gap:12px;}
.wallet-chip{display:flex;align-items:center;gap:5px;background:#eff6ff;border-radius:20px;padding:5px 12px;font-weight:700;color:#1d4ed8;font-size:13px;cursor:pointer;text-decoration:none;}
.wallet-chip i{font-size:13px;}
.notif-wrap{position:relative;}
.notif-icon{position:relative;cursor:pointer;font-size:18px;color:#2563eb;}
#notification-count{position:absolute;top:-7px;right:-8px;background:#ef4444;color:white;font-size:9px;padding:2px 4px;border-radius:50%;min-width:16px;height:16px;line-height:12px;text-align:center;display:none;font-weight:700;}
.notif-dropdown{position:absolute;right:-10px;top:42px;width:290px;background:white;border-radius:14px;box-shadow:0 10px 40px rgba(0,0,0,.18);display:none;overflow:hidden;z-index:9999;}
.notif-head{padding:11px 14px;font-weight:700;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;font-size:13px;background:#f8faff;}
.notif-list{max-height:260px;overflow-y:auto;}
.notif-item{padding:10px 13px;border-bottom:1px solid #f8f8f8;cursor:pointer;transition:.1s;}
.notif-item:hover{background:#f9fafb;}
.notif-item.unread{background:#eff6ff;border-left:3px solid #2563eb;}
.notif-title{font-size:12px;font-weight:700;color:#1e293b;}
.notif-msg{font-size:11px;color:#64748b;margin-top:2px;}
.notif-time{font-size:10px;color:#94a3b8;margin-top:2px;}
.notif-empty{padding:24px;text-align:center;color:#94a3b8;}
.notif-empty i{font-size:26px;display:block;margin-bottom:8px;}
.notif-foot{padding:9px;border-top:1px solid #f1f5f9;text-align:center;}
.notif-foot a{font-size:12px;color:#2563eb;font-weight:700;text-decoration:none;}
</style>
<div class="topbar">
  <div class="topbar-left">
     <i class="fa fa-bars" id="menuBtn" style="font-size:20px;cursor:pointer;color:#2563eb;"></i>

  {{-- Center: Logo + Name --}}
  <a href="{{ route('home') }}" class="topbar-brand">
    @if($siteLogo)
      <img src="{{ asset('storage/'.$siteLogo) }}" class="topbar-logo" alt="{{ $siteName }}">
    @else
      <div class="topbar-logo-placeholder">{{ strtoupper(substr($siteName,0,1)) }}</div>
    @endif
    <span class="topbar-name">{{ $siteName }}</span>
  </a>
  </div>
  {{-- Left: Hamburger --}}
  

  {{-- Right: Wallet + Notifications --}}
  <div class="topbar-right">
    {{-- Notifications --}}
    <div class="notif-wrap">
      <div class="notif-icon" id="notifBtn">
        <i class="fa fa-bell"></i>
        <span id="notification-count">0</span>
        <div class="notif-dropdown" id="notifDropdown">
          <div class="notif-head">
            <span>Notifications</span>
            <span id="unreadBadge" style="font-size:10px;background:#eff6ff;color:#2563eb;padding:2px 8px;border-radius:20px;"></span>
          </div>
          <div id="notifList" class="notif-list">
            <div class="notif-empty"><i class="fa fa-bell-slash"></i><p style="font-size:12px">No notifications</p></div>
          </div>
          <div class="notif-foot"><a href="{{ route('notifications.page') }}">View All →</a></div>
        </div>
      </div>
    </div>
    {{-- Wallet balance chip --}}
    <a href="{{ route('wallet') }}" class="wallet-chip">
      <i class="fa fa-wallet"></i>
      <span>₹{{ number_format($balance,2) }}</span>
    </a>
  </div>
</div>

<script>
(function(){
  var dropdown=document.getElementById('notifDropdown');
  var btn=document.getElementById('notifBtn');

  function timeSince(d){
    var sec=Math.floor((new Date()-new Date(d))/1000);
    if(sec<60)return sec+'s ago';
    if(sec<3600)return Math.floor(sec/60)+'m ago';
    if(sec<86400)return Math.floor(sec/3600)+'h ago';
    return Math.floor(sec/86400)+'d ago';
  }
  function typeIcon(t){
    var m={'wallet':'fa-wallet text-success','result':'fa-trophy text-warning','bet':'fa-gamepad text-primary','notice':'fa-bullhorn text-info'};
    return m[t]||'fa-bell text-secondary';
  }
  function loadCount(){
    fetch('/notifications/count').then(r=>r.json()).then(d=>{
      var b=document.getElementById('notification-count');
      if(d.count>0){b.style.display='flex';b.style.alignItems='center';b.style.justifyContent='center';b.innerText=d.count;}
      else b.style.display='none';
      document.getElementById('unreadBadge').innerText=d.count>0?d.count+' new':'';
    }).catch(()=>{});
  }
  function loadNotifs(){
    fetch('/notifications').then(r=>r.json()).then(data=>{
      var el=document.getElementById('notifList');
      if(!data.length){el.innerHTML='<div class="notif-empty"><i class="fa fa-bell-slash"></i><p style="font-size:12px">No notifications yet</p></div>';return;}
      var top=data.slice(0,5);
      var html=top.map(n=>'<div class="notif-item '+(n.is_read?'':'unread')+'" onclick="markRead()">'+
        '<div class="notif-title"><i class="fa '+typeIcon(n.type)+' mr-1"></i>'+n.title+'</div>'+
        '<div class="notif-msg">'+n.message+'</div>'+
        '<div class="notif-time">'+timeSince(n.created_at)+'</div></div>').join('');
      if(data.length>5)html+='<div style="padding:7px;text-align:center;font-size:11px;color:#64748b">+'+( data.length-5)+' more</div>';
      el.innerHTML=html;
    }).catch(()=>{});
  }
  function markRead(){
    fetch('/notifications/read',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}})
    .then(()=>{document.getElementById('notification-count').style.display='none';document.getElementById('unreadBadge').innerText='';})
    .catch(()=>{});
  }

  btn.onclick=function(e){
    e.stopPropagation();
    if(dropdown.style.display==='block'){dropdown.style.display='none';}
    else{
      dropdown.style.display='block';
      document.getElementById('notifList').innerHTML='<div class="notif-empty"><i class="fa fa-spinner fa-spin"></i></div>';
      loadNotifs();
      setTimeout(markRead,1000);
    }
  };
  document.addEventListener('click',function(e){if(!btn.contains(e.target))dropdown.style.display='none';});
  loadCount();
  setInterval(loadCount,60000);
})();
</script>
