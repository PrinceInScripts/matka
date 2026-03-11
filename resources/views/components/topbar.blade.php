@php
    $user = Auth::user();
    $balance = $user && $user->wallet ? $user->wallet->balance : 0;
@endphp

<style>
    .topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        position: sticky;
        top: 0;
        z-index: 1000;
        height: 56px;
    }

    .topbar-title {
        font-weight: 600;
        font-size: 60px;
        color: #2563eb;
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .menu-toggle {
        font-size: 20px;
        cursor: pointer;
        color: #2563eb;
    }

    .wallet-box {
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        color: #2563eb;
    }

    .notification-wrapper {
        position: relative;
    }

    .notification-icon {
        position: relative;
        cursor: pointer;
        font-size: 18px;
        /* color: #444; */
        color: #2563eb;
        margin-right: 10px;
    }

    #notification-count {
        position: absolute;
        top: -6px;
        right: -8px;
        background: #ef4444;
        color: white;
        font-size: 11px;
        padding: 2px 6px;
        border-radius: 50%;
    }

    .notification-dropdown {
        position: absolute;
        right: 0;
        top: 35px;
        width: 280px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .1);
        display: none;
        overflow: hidden;
    }

    .notification-header {
        padding: 12px;
        font-weight: 600;
        border-bottom: 1px solid #eee;
    }

    .notification-list {
        max-height: 300px;
        overflow-y: auto;
    }

    .notification-item {
        padding: 10px 12px;
        border-bottom: 1px solid #f1f1f1;
        cursor: pointer;
    }

    .notification-item:hover {
        background: #f9fafb;
    }

    .notification-title {
        font-size: 14px;
        font-weight: 600;
    }

    .notification-msg {
        font-size: 13px;
        color: #666;
    }

    .notification-empty {
        padding: 16px;
        text-align: center;
        color: #888;
    }

    .notification-empty {
        padding: 20px;
        text-align: center;
        color: #888;
    }

    .notification-empty i {
        font-size: 22px;
        margin-bottom: 6px;
        display: block;
        color: #bbb;
    }

    .notification-item {
        padding: 10px 12px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
    }

    .notification-item:hover {
        background: #f9fafb;
    }

    .notification-title {
        font-weight: 600;
        font-size: 14px;
    }

    .notification-msg {
        font-size: 13px;
        color: #666;
    }

    .notification-item.unread {
        background: #eff6ff;
        border-left: 3px solid #2563eb;
    }

    #notification-count.dot{
width:8px;
height:8px;
padding:0;
}
</style>


<div class="topbar">

    <div>
        <i class="fa fa-bars menu-toggle" id="menuBtn"></i>
    </div>

    <div style="font-size:26px;" class="fw-bold text-primary">
        Matka Play
    </div>

    <div class="topbar-right">

        <div class="notification-icon" id="notificationBtn">
            <i class="fa fa-bell"></i>
            <span id="notification-count">0</span>

            <div class="notification-dropdown" id="notificationDropdown">

                <div class="notification-header">
                    Notifications
                </div>

                <div id="notificationList">

                    <div class="notification-empty">
                        <i class="fa fa-bell-slash"></i>
                        <p>No notifications yet</p>
                    </div>

                </div>

            </div>

        </div>

        <div class="wallet">
            <i class="fa fa-wallet"></i>
            <span>₹{{ $balance }}</span>
        </div>

    </div>

</div>
<script>
    (function() {

        let dropdown = document.getElementById("notificationDropdown");
        let btn = document.getElementById("notificationBtn");

        /* LOAD UNREAD COUNT */

        function loadNotificationCount() {

            fetch('/notifications/count')
                .then(res => res.json())
                .then(data => {

                    let badge = document.getElementById('notification-count');
                     badge.style.display = "inline-block";
                        badge.innerText = data.count;

                    // if (data.count > 0) {

                    //     badge.style.display = "inline-block";
                    //     badge.innerText = data.count;

                    // } 
                    // else {

                    //     badge.style.display = "none";
                    //     badge.innerText = ;

                    // }

                });

        }


        /* LOAD NOTIFICATIONS */

        function loadNotifications() {

            fetch('/notifications')
                .then(res => res.json())
                .then(data => {

                    let html = "";

                    if (data.length === 0) {

                        html = `
                        <div class="notification-empty">
                        <i class="fa fa-bell-slash"></i>
                        <p>No notifications yet</p>
                        </div>
                        `;

                    } else {

                        data.forEach(n => {

                            html += `
                            <div class="notification-item ${n.is_read ? '' : 'unread'}">

                            <div class="notification-title">
                            ${n.title}
                            </div>

                            <div class="notification-msg">
                            ${n.message}
                            </div>

                            </div>
                            `;

                        });

                    }

                    document.getElementById("notificationList").innerHTML = html;

                });

        }


        /* MARK AS READ */

        function markNotificationsRead() {

            fetch('/notifications/read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(res => res.json())
                .then(() => {

                    let badge = document.getElementById("notification-count");

                    // badge.style.display = "none";
                    // badge.innerText = "";
                     badge.style.display = "inline-block";
                        badge.innerText = data.count;

                });

        }


        /* CLICK BELL */

        btn.onclick = function() {

            if (dropdown.style.display === "block") {

                dropdown.style.display = "none";

            } else {

                dropdown.style.display = "block";

                document.getElementById("notificationList").innerHTML =
                    '<div class="notification-empty">Loading...</div>';

                loadNotifications();
                markNotificationsRead();

            }

        };


        /* LOAD COUNT WHEN PAGE LOAD */

        loadNotificationCount();


    })();

    document.addEventListener("DOMContentLoaded", function(){
loadNotificationCount();
});
</script>
