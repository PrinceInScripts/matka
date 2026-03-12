@php $user = Auth::user(); $balance = $user && $user->wallet ? $user->wallet->balance : 0; @endphp
<style>
.topbar{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:white;box-shadow:0 2px 10px rgba(0,0,0,.05);position:sticky;top:0;z-index:1000;height:56px;}
.topbar-right{display:flex;align-items:center;gap:16px;}
.menu-toggle{font-size:20px;cursor:pointer;color:#2563eb;}
.wallet-box{display:flex;align-items:center;gap:6px;font-weight:600;color:#2563eb;font-size:14px;}
.notification-wrapper{position:relative;}
.notification-icon{position:relative;cursor:pointer;font-size:18px;color:#2563eb;margin-right:10px;}
#notification-count{position:absolute;top:-6px;right:-8px;background:#ef4444;color:white;font-size:10px;padding:2px 5px;border-radius:50%;min-width:18px;text-align:center;display:none;}
.notification-dropdown{position:absolute;right:0;top:40px;width:300px;background:white;border-radius:14px;box-shadow:0 10px 40px rgba(0,0,0,.15);display:none;overflow:hidden;z-index:9999;}
.notif-header{padding:12px 14px;font-weight:700;border-bottom:1px solid #f1f1f1;display:flex;justify-content:space-between;align-items:center;font-size:14px;}
.notif-list{max-height:280px;overflow-y:auto;}
.notif-item{padding:10px 14px;border-bottom:1px solid #f8f8f8;cursor:pointer;}
.notif-item:hover{background:#f9fafb;}
.notif-item.unread{background:#eff6ff;border-left:3px solid #2563eb;}
.notif-title{font-size:13px;font-weight:600;}
.notif-msg{font-size:12px;color:#64748b;margin-top:2px;}
.notif-time{font-size:10px;color:#94a3b8;margin-top:3px;}
.notif-empty{padding:24px;text-align:center;color:#94a3b8;}
.notif-empty i{font-size:28px;display:block;margin-bottom:8px;color:#cbd5e1;}
.notif-footer{padding:10px;border-top:1px solid #f1f5f9;text-align:center;}
.notif-footer a{font-size:13px;color:#2563eb;font-weight:600;text-decoration:none;}
</style>
<div class="topbar">
  <div><i class="fa fa-bars menu-toggle" id="menuBtn"></i></div>
  <div style="font-size:22px;" class="fw-bold text-primary">Matka Play</div>
  <div class="topbar-right">
    <div class="notification-wrapper">
      <div class="notification-icon" id="notificationBtn">
        <i class="fa fa-bell"></i>
        <span id="notification-count">0</span>
        <div class="notification-dropdown" id="notificationDropdown">
          <div class="notif-header">
            <span>Notifications</span>
            <span id="unreadBadge" style="font-size:11px;background:#eff6ff;color:#2563eb;padding:2px 8px;border-radius:20px;"></span>
          </div>
          <div id="notificationList" class="notif-list">
            <div class="notif-empty"><i class="fa fa-bell-slash"></i><p>No notifications</p></div>
          </div>
          <div class="notif-footer"><a href="{{ route('notifications.page') }}">View All Notifications →</a></div>
        </div>
      </div>
    </div>
    <div class="wallet-box"><i class="fa fa-wallet"></i><span>₹{{ number_format($balance,2) }}</span></div>
  </div>
</div>
<script>
(function(){
  var dropdown=document.getElementById('notificationDropdown');
  var btn=document.getElementById('notificationBtn');

  function timeSince(dateStr){
    var d=new Date(dateStr), now=new Date();
    var sec=Math.floor((now-d)/1000);
    if(sec<60)return sec+'s ago';
    if(sec<3600)return Math.floor(sec/60)+'m ago';
    if(sec<86400)return Math.floor(sec/3600)+'h ago';
    return Math.floor(sec/86400)+'d ago';
  }

  function typeIcon(t){
    var icons={'wallet':'fa-wallet text-success','result':'fa-trophy text-warning','bet':'fa-gamepad text-primary','notice':'fa-bullhorn text-info'};
    return icons[t]||'fa-bell text-secondary';
  }

  function loadCount(){
    fetch('/notifications/count').then(r=>r.json()).then(d=>{
      var b=document.getElementById('notification-count');
      if(d.count>0){b.style.display='inline-block';b.innerText=d.count;}else{b.style.display='none';}
      document.getElementById('unreadBadge').innerText=d.count>0?d.count+' new':'';
    });
  }

  function loadNotifications(){
    fetch('/notifications').then(r=>r.json()).then(data=>{
      var list=document.getElementById('notificationList');
      if(!data.length){list.innerHTML='<div class="notif-empty"><i class="fa fa-bell-slash"></i><p>No notifications yet</p></div>';return;}
      var top5=data.slice(0,5);
      var html=top5.map(n=>`
        <div class="notif-item ${n.is_read?'':'unread'}">
          <div class="notif-title"><i class="fa ${typeIcon(n.type)} mr-1"></i>${n.title}</div>
          <div class="notif-msg">${n.message}</div>
          <div class="notif-time">${timeSince(n.created_at)}</div>
        </div>`).join('');
      if(data.length>5) html+=`<div style="padding:8px;text-align:center;font-size:12px;color:#64748b">+${data.length-5} more notifications</div>`;
      list.innerHTML=html;
    });
  }

  function markRead(){
    fetch('/notifications/read',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}})
    .then(()=>{document.getElementById('notification-count').style.display='none';document.getElementById('unreadBadge').innerText='';});
  }

  btn.onclick=function(e){
    e.stopPropagation();
    if(dropdown.style.display==='block'){dropdown.style.display='none';}
    else{
      dropdown.style.display='block';
      document.getElementById('notificationList').innerHTML='<div class="notif-empty">Loading...</div>';
      loadNotifications();
      markRead();
    }
  };

  document.addEventListener('click',function(e){if(!btn.contains(e.target))dropdown.style.display='none';});
  loadCount();
  setInterval(loadCount,60000);
})();
</script>
