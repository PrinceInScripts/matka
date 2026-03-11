@php
    $isStarline = $game->type === 'starline';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Matka Play | Home</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">



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
            border-bottom: 1px solid #eee;
            background: #fff;
            z-index: 10;
        }

        .menu-toggle {
            font-size: 22px;
            color: #007bff;
            cursor: pointer;
        }

        .wallet {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #007bff;
            cursor: pointer;
        }

        .wallet i {
            font-size: 20px;
        }

        .home-content {
            flex: 1;
            overflow-y: auto;
            background: #f5f6fa;
            padding: 80px 15px 90px;
            height: calc(100dvh - 140px);
            -webkit-overflow-scrolling: touch;
            box-sizing: border-box;
        }

        .fa-sidebar {
            font-size: 22px;
            color: #007bff;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 50%;
        }

        .top-bar i {
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 20px;
            background: #007bff;
            color: #fff;
        }



        /* .game-section {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .game-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .game-header h5 {
            color: #007bff;
            font-weight: 700;
            margin: 0;
        }

        .bid-form input,
        .bid-form select {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .bid-form .form-group {
            margin-bottom: 12px;
        }

        .add-bid-btn,
        .submit-bid-btn {
            width: 40%;
            background: #007bff;
            color: #fff;
            font-weight: 600;
            border: none;
            padding: 12px;
            border-radius: 25px;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
            transition: 0.3s;
        }

        .add-bid-btn:hover,
        .submit-bid-btn:hover {
            background: #0056d2;
        }

        .bid-table {
            margin-top: 15px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }

        .bid-table th,
        .bid-table td {
            text-align: center;
            font-size: 14px;
            padding: 8px;
        }

        .btn {
            display: flex;
            justify-content: flex-end;
            align-items: end;
            border: none;
            background: none;
            cursor: pointer;
        }

        .game-type {
            color: #3FDD3F;
            font-weight: 600;
            text-transform: uppercase;

        }

        .submit-btn {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        .submit-btn div {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-weight: 600;
            color: #333;
        }

        .submit-btn div span {
            font-size: 18px;
        }

        .submit-btn div:last-child {
            align-items: center;
        }

        .submit-btn div .digit {
            color: #007bff;
        }

        .btnn {
            border: none;
            background: none;
            cursor: pointer;

        }

        .btnn i {
            color: #fff;
            background: #007bff;
            border-radius: 50%;
            padding: 5px 8px;
            cursor: pointer;
        } */

        .game-section {
            background: #ffffff;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        }

        .game-header h5 {
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 15px;
        }

        /* INPUT GRID */

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #666;
        }

        .bid-form input,
        .bid-form select {
            height: 48px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 0 12px;
            font-size: 14px;
            background: #fafafa;
            transition: 0.2s;
        }

        .bid-form input:focus,
        .bid-form select:focus {
            background: #fff;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        }

        /* ADD BID BUTTON */

        .add-bid-btn {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 12px;
            background: #2563eb;
            color: white;
            font-weight: 600;
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: .2s;
        }

        .add-bid-btn:hover {
            background: #1d4ed8;
        }

        /* BID LIST */

        .bid-list {
            margin-top: 18px;
        }

        .bid-list-header {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .bid-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fafc;
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 8px;
        }

        .bid-number {
            font-weight: 700;
            color: #111;
        }

        .bid-points {
            font-weight: 600;
            color: #2563eb;
        }

        .delete-bid {
            background: #ef4444;
            color: white;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* SUMMARY */

        .submit-panel {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .bid-summary {
            display: flex;
            gap: 20px;
        }

        .summary-value {
            font-size: 18px;
            font-weight: 700;
            color: #2563eb;
        }

        .summary-label {
            font-size: 12px;
            color: #777;
            display: block;
        }

        .submit-bid-btn {
            flex: 1;
            height: 48px;
            border: none;
            border-radius: 12px;
            background: #22c55e;
            color: white;
            font-weight: 700;
        }

        .submit-bid-btn:hover {
            background: #16a34a;
        }

        .empty-bids {
            text-align: center;
            color: #888;
            padding: 15px;
            font-size: 13px;
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

        .bid-form select#digit{
height:48px;
border-radius:10px;
border:1px solid #e5e7eb;
padding:0 10px;
font-size:14px;
background:#fafafa;
}

.ts-wrapper{
width:100%;
}

/* Tom Select Fix */

.ts-wrapper.single .ts-control{
height:48px;
min-height:48px;
border-radius:10px;
border:1px solid #e5e7eb;
background:#fafafa;

display:flex;
align-items:center;

padding:0 12px;
font-size:14px;
box-shadow:none;
}

.ts-wrapper.single .ts-control .item{
line-height:1;
}

/* Search input alignment */

.ts-wrapper.single .ts-control input{
height:100%;
line-height:48px;
padding:0;
margin:0;
}

/* Focus state */

.ts-wrapper.single .ts-control.focus{
border-color:#2563eb;
box-shadow:0 0 0 2px rgba(37,99,235,0.1);
background:#fff;
}
.ts-dropdown{
border-radius:10px;
border:1px solid #e5e7eb;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button{
-webkit-appearance:none;
margin:0;
}
    </style>

</head>

<body>


    <div class="app-layout">
        <!-- LEFT AREA -->
        <div class="left-area">
            <div class="top-bar">
                <!-- Back Button -->
                <i class="fa-solid fa-angle-left" id="backBtn" onclick="goBack()"></i>

                <h5 class="m-0 fw-bold text-primary">{{ $game->name }}</h5>

                @include('components.walletinfo')
            </div>


            <div class="home-content">
                {{-- <div class="game-section">
                    <div class="game-header">
                       <h5>Place Your Bid</h5>
                    </div>
                   @php
                        $today_date = date('Y-m-d');
                    @endphp

                    <form class="bid-form">
                        <div class="row">
                            <div class="col-6 form-group">
                                <label>Date</label>
                                <input id="date" name="date" type="date" value="{{ $today_date }}">
                            </div>
                            <div class="col-6 form-group">
                                <label>Session</label>
                                <select id="session" name="session">
                                    <option>OPEN</option>
                                    <option>CLOSE</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 form-group">
                                <input type="text" id="digit"
                                   
                                    name="digit" placeholder="{{ $gameType->name }}">
                            </div>
                            <div class="col-6 form-group">
                                <input type="number" id="points" name="points" placeholder="Enter points">
                            </div>
                        </div>

                        <div class="btn">
                            <button type="button" class="add-bid-btn mb-3">ADD BID</button>
                        </div>

                        <table class="table table-bordered bid-table">
                            <thead>
                                <tr>
                                    <th>Pana</th>
                                    <th>Points</th>
                                    <th>Game Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No Bids Added</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="submit-btn">
                            <div>
                                <span class="digit">0</span>
                                <span class="ms-2">Points</span>
                            </div>
                            <div>
                                <span class="digit">0</span>
                                <span class="ms-2">Bids</span>
                            </div>
                            <button type="button" class="submit-bid-btn mt-2">SUBMIT BID</button>
                        </div>
                    </form>
                </div> --}}
                <div class="game-section">

                    <div class="game-header">
                        <h5>Place Your Bid</h5>
                    </div>

                    @php
                        $today_date = date('Y-m-d');
                    @endphp

                    <form class="bid-form">

                        <div class="form-row">

                            <div class="form-group">
                                <label>Date</label>
                                <input id="date" name="date" type="date" value="{{ $today_date }}">
                            </div>

                            @if (!$isStarline)
                                <div class="form-group">
                                    <label>Session</label>
                                    <select id="session" name="session">
                                        <option>OPEN</option>
                                        <option>CLOSE</option>
                                    </select>
                                </div>
                            @endif

                        </div>


                        <div class="form-row">

                          <div class="form-group">
<label>{{ $gameType->name }}</label>

<select id="digit" name="digit">

<option value="" disabled selected>Select {{ $gameType->name }}</option>

@foreach($numbers as $number)
<option value="{{ $number }}">{{ $number }}</option>
@endforeach

</select>

</div>

                            <div class="form-group">
                                <label>Points</label>
                                <input type="number" id="points" name="points" placeholder="Enter points">
                            </div>

                        </div>

                        <button type="button" class="add-bid-btn">
                            <i class="fa fa-plus"></i>
                            Add Bid
                        </button>

                    </form>

                    <div class="bid-list">

                        <div class="bid-list-header">
                            Added Bids
                        </div>

                        <div class="bid-attribute">
                            {{ $gameType->name }}
                        </div>

                        <div class="bid-columns">
                            <span>Digit</span>
                            <span>Points</span>

                            @if (!$isStarline)
                                <span>Session</span>
                            @endif

                            <span></span>
                        </div>

                        <div class="bid-items">

                            <div class="empty-bids">
                                No bids added
                            </div>

                        </div>

                    </div>

                    <div class="submit-panel">

                        <div class="bid-summary">

                            <div>
                                <span class="summary-value total-points">0</span>
                                <span class="summary-label">Points</span>
                            </div>

                            <div>
                                <span class="summary-value total-bids">0</span>
                                <span class="summary-label">Bids</span>
                            </div>

                        </div>

                        <button class="submit-bid-btn">
                            Submit Bid
                        </button>

                    </div>

                </div>
            </div>

            @include('components.bottombar')
        </div>


        <!-- RIGHT AREA (Main Content) -->
        @include('components.rightside')

    </div>


    <!-- Bootstrap JS Bundle (Required for Modals, Toasts, Dropdowns, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    {{-- jq --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    

    <script>
        new TomSelect("#digit",{
create:false,
sortField:"text",
maxOptions:500
});
        function goBack() {
            window.history.back();
        }
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const addBidBtn = document.querySelector(".add-bid-btn");
            const submitBidBtn = document.querySelector(".submit-bid-btn");
            const bidContainer = document.querySelector(".bid-items");

            let totalPoints = 0;
            let totalBids = 0;

            const inputs = {
                date: document.getElementById("date"),
                digit: document.getElementById("digit"),
                points: document.getElementById("points"),
                @if (!$isStarline)
                    session: document.getElementById("session"),
                @endif
            };

            const validNumbers = @json($numbers);
            const digitsLimit = {{ $digitsLimit }};

            inputs.digit.addEventListener("input", () => {
                checkDigit(inputs.digit);
            });


            // ADD BID
            addBidBtn.addEventListener("click", () => {

                const digit = inputs.digit.value.trim();
                const points = parseInt(inputs.points.value) || 0;
                @if (!$isStarline)
                    const session = inputs.session.value;
                @endif

                if (!digit || points <= 0) {
                    Toastify({
                        text: "Enter valid number and points",
                        duration: 2500,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#ff6b6b",
                    }).showToast();
                    return;
                }

                if (digit.length !== digitsLimit) {
                    Toastify({
                        text: `Number must be ${digitsLimit} digits`,
                        duration: 2500,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#ff6b6b",
                    }).showToast();
                    return;
                }

                if (!validNumbers.includes(digit)) {
                    Toastify({
                        text: "Invalid number",
                        duration: 2500,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#ff6b6b",
                    }).showToast();
                    return;
                }


                // REMOVE EMPTY MESSAGE
                const empty = bidContainer.querySelector(".empty-bids");
                if (empty) empty.remove();


                // CREATE BID ITEM
                const bidItem = document.createElement("div");

                bidItem.className = "bid-item";

               bidItem.innerHTML = `
<div class="bid-number">${digit}</div>
<div class="bid-points">${points}</div>

@if(!$isStarline)
<div class="bid-session">${session}</div>
@endif

<button class="delete-bid"><i class="fa fa-xmark"></i></button>
`;

                bidContainer.appendChild(bidItem);


                // UPDATE TOTALS
                totalPoints += points;
                totalBids++;

                updateTotals();


                // RESET INPUTS
                inputs.digit.value = "";
                inputs.points.value = "";
                inputs.digit.style.borderColor = "";


                // DELETE BID
                bidItem.querySelector(".delete-bid").addEventListener("click", () => {

                    totalPoints -= points;
                    totalBids--;

                    bidItem.remove();

                    if (bidContainer.children.length === 0) {
                        bidContainer.innerHTML = `<div class="empty-bids">No bids added</div>`;
                    }

                    updateTotals();

                });

            });



            // SUBMIT BIDS
            submitBidBtn.addEventListener("click", () => {

                if (totalBids === 0) {
                    Toastify({
                        text: "No bids to submit",
                        duration: 2500,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#ff6b6b",
                    }).showToast();
                    return;
                }

                const bids = [];

                document.querySelectorAll(".bid-item").forEach(item => {

                    bids.push({
                        digits: item.querySelector(".bid-number").innerText,
                        points: parseInt(item.querySelector(".bid-points").innerText),
                        @if (!$isStarline)
                            session: item.querySelector(".bid-session").innerText,
                        @endif
                    });

                });


                const payload = {
                    date: inputs.date.value,
                    market_id: "{{ $game->id ?? '' }}",
                    market_type: "{{ $game->type ?? 'main' }}",
                    game_id: "{{ $game->id ?? '' }}",
                    game_type_id: "{{ $gameType->id ?? '' }}",
                    bids: bids,
                    game_type: "{{ $game_type ?? 'main' }}"
                };


                $.ajax({

                    url: "{{ route('place.bids') }}",
                    type: "POST",
                    data: JSON.stringify(payload),
                    contentType: "application/json",

                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },

                    success: function() {

                        Toastify({
                            text: "Bids submitted successfully",
                            duration: 2500,
                            gravity: "top",
                            position: "center",
                            backgroundColor: "#28a745",
                        }).showToast();


                        // RESET UI
                        bidContainer.innerHTML = `<div class="empty-bids">No bids added</div>`;

                        totalPoints = 0;
                        totalBids = 0;

                        updateTotals();

                    },

                    error: function(xhr) {

                        let message = "Failed to submit bids";

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Toastify({
                            text: message,
                            duration: 2500,
                            gravity: "top",
                            position: "center",
                            backgroundColor: "#ff6b6b",
                        }).showToast();

                    }

                });

            });



            // UPDATE TOTAL DISPLAY
            function updateTotals() {

                document.querySelector(".total-points").textContent = totalPoints;
                document.querySelector(".total-bids").textContent = totalBids;

            }



            // VALIDATE DIGIT INPUT
            function checkDigit(input) {

                let val = input.value.trim();

                if (!val) {
                    input.style.borderColor = "";
                    return;
                }

                if (val.length > digitsLimit) {
                    input.value = val.slice(0, digitsLimit);
                    return;
                }

                if (val.length < digitsLimit) {
                    input.style.borderColor = "#ffaa00";
                    return;
                }

                if (!validNumbers.includes(val)) {
                    input.style.borderColor = "red";
                } else {
                    input.style.borderColor = "green";
                }

            }

        });
    </script>



</body>

</html>
