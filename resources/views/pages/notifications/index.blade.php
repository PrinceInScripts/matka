@php
  use App\Models\Setting;
  $siteName = Setting::get('site_name') ?? 'Matka Play';
  $siteLogo = Setting::get('site_logo');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Notifications | {{ $siteName }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <style>
    .home-content{flex:1;overflow-y:auto;background:#f5f6fa;padding:70px 12px 100px;height:calc(100dvh - 56px);box-sizing:border-box;}
    .top-bar{position:fixed;top:0;width:100%;max-width:500px;display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid #eee;background:#fff;z-index:10;}
    .top-bar .back-btn{width:36px;height:36px;border-radius:50%;background:#2563eb;color:#fff;border:none;display:flex;align-items:center;justify-content:center;}
    .notif-card{background:#fff;border-radius:14px;padding:14px 16px;margin-bottom:10px;box-shadow:0 2px 8px rgba(0,0,0,.06);display:flex;gap:14px;align-items:flex-start;cursor:pointer;transition:.15s;}
    .notif-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.1);}
    .notif-card.unread{border-left:4px solid #2563eb;background:#fafcff;}
    .notif-icon-wrap{width:42px;height:42px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
    .notif-icon-wallet{background:#dcfce7;color:#16a34a;}
    .notif-icon-result{background:#fef3c7;color:#d97706;}
    .notif-icon-bet{background:#eff6ff;color:#2563eb;}
    .notif-icon-notice{background:#f0f9ff;color:#0284c7;}
    .notif-icon-system{background:#f5f3ff;color:#7c3aed;}
    .notif-icon-account{background:#fff1f2;color:#e11d48;}
    .notif-title{font-size:14px;font-weight:700;margin-bottom:3px;}
    .notif-msg{font-size:13px;color:#475569;line-height:1.4;}
    .notif-time{font-size:11px;color:#94a3b8;margin-top:4px;}
    .filter-tabs{display:flex;gap:8px;overflow-x:auto;padding-bottom:8px;margin-bottom:14px;}
    .filter-tab{border:none;background:#f1f5f9;border-radius:20px;padding:6px 14px;font-size:12px;font-weight:600;white-space:nowrap;color:#64748b;}
    .filter-tab.active{background:#2563eb;color:#fff;}
    .mark-all-btn{font-size:12px;color:#2563eb;background:none;border:none;font-weight:600;}
    .empty-state{text-align:center;padding:50px 20px;color:#94a3b8;}
    .empty-state i{font-size:48px;display:block;margin-bottom:14px;color:#cbd5e1;}
  </style>
</head>
<body>
<div class="app-layout">
  <div class="left-area">
    <div class="top-bar">
      <button class="back-btn" onclick="history.back()"><i class="fa fa-angle-left"></i></button>
      <h6 class="m-0 fw-bold">Notifications</h6>
      <button class="mark-all-btn" id="markAllBtn">Mark all read</button>
    </div>
    <div class="home-content">
      <div class="filter-tabs" id="filterTabs">
        <button class="filter-tab active" data-type="">All</button>
        <button class="filter-tab" data-type="wallet"><i class="fa fa-wallet me-1"></i>Wallet</button>
        <button class="filter-tab" data-type="result"><i class="fa fa-trophy me-1"></i>Results</button>
        <button class="filter-tab" data-type="bet"><i class="fa fa-gamepad me-1"></i>Bids</button>
        <button class="filter-tab" data-type="notice"><i class="fa fa-bullhorn me-1"></i>Notice</button>
        <button class="filter-tab" data-type="system"><i class="fa fa-cog me-1"></i>System</button>
      </div>

      <div id="notifContainer">
        <div class="empty-state"><i class="fa fa-spinner fa-spin"></i><p>Loading notifications...</p></div>
      </div>
    </div>
    @include('components.bottombar')
  </div>
  @include('components.rightside')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
var allNotifs=[], currentFilter='';
var iconMap={wallet:'fa-wallet notif-icon-wallet',result:'fa-trophy notif-icon-result',bet:'fa-gamepad notif-icon-bet',notice:'fa-bullhorn notif-icon-notice',system:'fa-cog notif-icon-system',account:'fa-user notif-icon-account'};

function timeSince(d){
  var sec=Math.floor((new Date()-new Date(d))/1000);
  if(sec<60)return sec+'s ago';if(sec<3600)return Math.floor(sec/60)+'m ago';
  if(sec<86400)return Math.floor(sec/3600)+'h ago';
  return new Date(d).toLocaleDateString('en-IN',{day:'2-digit',month:'short',year:'numeric'});
}

function renderNotifs(data){
  var container=document.getElementById('notifContainer');
  if(!data.length){
    container.innerHTML='<div class="empty-state"><i class="fa fa-bell-slash"></i><p>No notifications'+(currentFilter?' in this category':'')+'</p></div>';
    return;
  }
  container.innerHTML=data.map(n=>{
    var icon=iconMap[n.type]||'fa-bell notif-icon-system';
    var ic=icon.split(' ')[0], cls=icon.split(' ')[1]||'';
    return `<div class="notif-card ${n.is_read?'':'unread'}" onclick="markOne(${n.id},this)">
      <div class="notif-icon-wrap ${cls}"><i class="fa ${ic}"></i></div>
      <div style="flex:1">
        <div class="notif-title">${n.title}</div>
        <div class="notif-msg">${n.message}</div>
        <div class="notif-time">${timeSince(n.created_at)}</div>
      </div>
      ${!n.is_read?'<span style="width:8px;height:8px;border-radius:50%;background:#2563eb;display:block;flex-shrink:0;margin-top:6px"></span>':''}
    </div>`;
  }).join('');
}

function filterAndRender(){
  var filtered=currentFilter?allNotifs.filter(n=>n.type===currentFilter):allNotifs;
  renderNotifs(filtered);
}

fetch('/notifications').then(r=>r.json()).then(d=>{
  allNotifs=d;
  filterAndRender();
});

document.querySelectorAll('.filter-tab').forEach(t=>{
  t.addEventListener('click',function(){
    document.querySelectorAll('.filter-tab').forEach(x=>x.classList.remove('active'));
    this.classList.add('active');
    currentFilter=this.dataset.type;
    filterAndRender();
  });
});

document.getElementById('markAllBtn').addEventListener('click',function(){
  fetch('/notifications/read',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}})
  .then(()=>{ allNotifs=allNotifs.map(n=>({...n,is_read:1})); filterAndRender(); this.style.display='none'; });
});

function markOne(id,el){ el.classList.remove('unread'); var dot=el.querySelector('span[style*="border-radius:50%"]'); if(dot)dot.remove(); }
</script>
</body>
</html>
