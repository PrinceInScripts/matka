<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Matka Play | Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        .top-bar {
            position: fixed;
            top: 0;
            width: 100%;
            max-width: 500px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 25px;
            background: #fff;
            border-bottom: 1px solid #eee;
            z-index: 10;
        }

        .menu-toggle {
            font-size: 22px;
            color: #007bff;
            cursor: pointer;
        }

        .top-bar i {
            background: #007bff;
            color: #fff;
            border-radius: 50%;
            padding: 8px 10px;
            cursor: pointer;
        }

        .wallet {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #007bff;
            font-weight: 600;
        }

        .wallet i {
            font-size: 20px;
        }

        /* .home-content {
            flex: 1;
            overflow-y: auto;
            padding: 80px 15px 100px;
            background: #f5f6fa;
        } */

        .home-content {
            flex: 1;
            overflow-y: auto;
            background: #f5f6fa;
            padding: 80px 15px 90px;
            /* extra padding for fixed bars */
            height: calc(100dvh - 140px);
            -webkit-overflow-scrolling: touch;
            box-sizing: border-box;
        }

        .btnn {
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 50%;
        }

        .game-types {
            color: #3FDD3F;
            font-weight: 600;
            text-transform: uppercase;
        }

        .bet-controls {
            background: #f8fafc;
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 18px;
        }

        .control-date input {
            width: 100%;
            height: 46px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 0 12px;
            font-size: 14px;
            background: white;
        }

        .control-row {
            display: flex;
            gap: 12px;
            margin-top: 10px;
        }

        .control-points input {
            flex: 1;
            height: 46px;
            width: 100%;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 0 12px;
        }

        .control-session select {
            width: 185px;
            height: 46px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 0 10px;
            background: white;
        }

        /* Keypad */
        .keypad {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 15px;
        }

        .keypad button {
            position: relative;
            background: white;
            border: 2px solid #e8edf6;
            border-radius: 14px;
            height: 70px;

            font-size: 20px;
            font-weight: 700;

            color: #1e293b;

            display: flex;
            align-items: center;
            justify-content: center;

            transition: .2s;
        }

        .keypad button:hover {
            border-color: #2563eb;
            background: #eff6ff;
        }

        .keypad button.active {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        .point-tag {
            position: absolute;
            top: 6px;
            right: 8px;

            background: #22c55e;
            color: white;

            font-size: 11px;
            padding: 2px 6px;
            border-radius: 6px;
        }

        .bid-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 12px;
            margin-top: 20px;
        }

        .bid-card-header {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .bid-row {
            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        .bid-digit {
            font-weight: 700;
            font-size: 16px;
        }

        .bid-points {
            color: #2563eb;
            font-weight: 600;
        }

        .remove-btn {
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 50%;
            width: 26px;
            height: 26px;
        }

        /* Submit area */
        .submit-area {
            display: flex;
            justify-content: space-between;
            align-items: center;

            background: white;
            border-radius: 12px;
            padding: 10px 12px;
            margin-top: 15px;
        }

        .submit-area button {
            background: #22c55e;
            border: none;
            color: white;
            font-weight: 700;

            height: 48px;
            padding: 0 25px;
            border-radius: 12px;
        }

         .bid-attribute {
            background: #2563eb;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 10px;
            display: inline-block;
        }

        .bid-columns {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #777;
            margin-bottom: 6px;
            padding: 0 6px;
        }
    </style>
</head>

<body>

    <div class="app-layout">
        <div class="left-area">
            <div class="top-bar">
                <!-- Back Button -->
                <i class="fa-solid fa-angle-left" id="backBtn" onclick="goBack()"></i>
                <h5 class="m-0 fw-bold text-primary">{{ $game->name }}</h5>
                @include('components.walletinfo')
            </div>
            @php
                $today_date = date('Y-m-d');
            @endphp


            <div class="home-content">
                <div class="bet-controls">

                    <div class="control-date">
                        <input type="date" id="dateInput" value="{{ $today_date }}">
                    </div>

                    <div class="control-row">

                        <div class="control-points">
                            <input type="number" id="pointsInput" placeholder="Enter Points">
                        </div>

                        <div class="control-session">
                            <select id="sessionSelect">
                                <option>OPEN</option>
                                <option>CLOSE</option>
                            </select>
                        </div>

                    </div>

                </div>
                <div class="keypad" id="keypad">
@foreach ($numbers as $index => $number)
@php
$isLast = $loop->last;
$isSingleInLastRow = $isLast && $loop->count % 3 === 1;
@endphp

<button data-num="{{ $number }}"
@if($isSingleInLastRow) style="grid-column:2;" @endif>
{{ $number }}
</button>

@endforeach
</div>

<div class="bid-card">

<div class="bid-card-header">
Added Bids
</div>

<div class="bid-attribute">
                            {{ $gameType->name }}
                        </div>

                        <div class="bid-columns">
                            <span>Digit</span>
                            <span>Points</span>

                            {{-- @if (!$isStarline) --}}
                                <span>Session</span>
                            {{-- @endif --}}

                            <span></span>
                        </div>
<div id="bidList">
<div style="text-align:center;color:#777;padding:10px;">
No bids added
</div>
</div>

</div>

<div class="submit-area">

<div>
<strong id="bidCount">0</strong>
<div style="font-size:12px;">Bids</div>
</div>

<div>
<strong id="pointCount">0</strong>
<div style="font-size:12px;">Points</div>
</div>

<button id="submitBid">
Submit BID
</button>

</div>
            </div>

            @include('components.bottombar')

        </div>


        <!-- RIGHT AREA (Main Content) -->
        @include('components.rightside')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        function goBack() {
            window.history.back();
        }

        const keypad = document.getElementById("keypad");
        const bidTable = document.getElementById("bidTableBody");
        const bidCount = document.getElementById("bidCount");
        const pointCount = document.getElementById("pointCount");
        const pointsInput = document.getElementById("pointsInput");
        const sessionSelect = document.querySelector("select");
        const submitBtn = document.getElementById("submitBid");

        let bids = {};

        keypad.addEventListener("click", e => {
            if (e.target.tagName !== "BUTTON") return;

            const digit = e.target.dataset.num;
            const points = parseInt(pointsInput.value);
            const session = sessionSelect.value;

            if (!points || points <= 0) {
                Toastify({
                    text: "Enter valid points first!",
                    duration: 2500,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#ff6b6b",
                }).showToast();
                return;
            }

            // Add or update bid
            bids[digit] = {
                points,
                session
            };

            updateKeypadPoints();
            updateBidList();

        });

        // function updateKeypadPoints() {
        //     document.querySelectorAll(".keypad button").forEach(btn => {
        //         const num = btn.dataset.num;
        //         const existingTag = btn.querySelector(".point-tag");
        //         if (bids[num]) {
        //             if (!existingTag) {
        //                 const tag = document.createElement("div");
        //                 tag.classList.add("point-tag");
        //                 tag.textContent = bids[num].points;
        //                 btn.appendChild(tag);
        //             } else {
        //                 existingTag.textContent = bids[num].points;
        //             }
        //         } else if (existingTag) {
        //             existingTag.remove();
        //         }
        //     });
        // }

        function updateKeypadPoints() {

            document.querySelectorAll(".keypad button").forEach(btn => {

                const num = btn.dataset.num;
                const existingTag = btn.querySelector(".point-tag");

                if (bids[num]) {

                    btn.classList.add("active");

                    if (!existingTag) {

                        const tag = document.createElement("div");
                        tag.classList.add("point-tag");
                        tag.textContent = bids[num].points;

                        btn.appendChild(tag);

                    } else {

                        existingTag.textContent = bids[num].points;

                    }

                } else {

                    btn.classList.remove("active");

                    if (existingTag) existingTag.remove();

                }

            });

        }

        function updateBidList() {

            const keys = Object.keys(bids);

            if (keys.length === 0) {

                document.getElementById("bidList").innerHTML =
                    `<div style="text-align:center;color:#777;padding:10px;">No bids added</div>`;

            } else {

                document.getElementById("bidList").innerHTML = keys.map(num => `
<div class="bid-row">

<div class="bid-digit">${num}</div>

<div class="bid-points">₹${bids[num].points}</div>

<div class="game-types">${bids[num].session}</div>

<button class="remove-btn" onclick="removeBid('${num}')">
<i class="fa fa-xmark"></i>
</button>

</div>
`).join("");

            }

            bidCount.textContent = keys.length;
            pointCount.textContent = keys.reduce((sum, n) => sum + bids[n].points, 0);

        }

        function removeBid(num) {
            delete bids[num];
            updateKeypadPoints();
            updateBidList();

        }

        submitBtn.addEventListener("click", async () => {
            // Build bids array from in-memory `bids` object
            const allBids = Object.keys(bids).map(num => ({
                digits: num,
                points: bids[num].points,
                session: bids[num].session
            }));

            if (allBids.length === 0) {
                Toastify({
                    text: "No bids to submit!",
                    duration: 2500,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#ff6b6b",
                }).showToast();
                return;
            }

            const payload = {
                date: document.querySelector("input[type='date']").value,
                market_id: "{{ $game->id ?? '' }}",
                market_type: "{{ $game->type ?? 'main' }}",
                game_id: "{{ $game->id ?? '' }}",
                game_type_id: "{{ $gameType->id ?? '' }}",
                bids: allBids,
                game_type: "{{ $game_type ?? 'main' }}"
            };

            // UI: disable button & show spinner text
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = "Submitting...";

            $.ajax({
                url: "{{ route('place.bids') }}",
                type: "POST",
                data: JSON.stringify(payload),
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                success: function(response) {
                    Toastify({
                        text: "Bids submitted successfully!",
                        duration: 2500,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#28a745",
                    }).showToast();

                    // ✅ Reset all data
                    bids = {};
                    updateKeypadPoints();
                    updateBidList();

                    pointsInput.value = "";

                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Toastify({
                        text: "Failed to submit bids!",
                        duration: 2500,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#ff6b6b",
                    }).showToast();

                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            });

        });
    </script>

</body>

</html>
