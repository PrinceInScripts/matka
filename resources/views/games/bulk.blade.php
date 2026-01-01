

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Madhur Morning | Matka Play</title>

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

        .game-section {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .form-control,
        select {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        /* Keypad */
        .keypad {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 15px;

        }

        .keypad button {
            position: relative;
            background: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 18px;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: 0.2s;
        }

        .keypad button:hover {
            background: #007bff;
            color: #fff;
        }

        .keypad .point-tag {
            position: absolute;
            top: 13px;
            right: 0;
            left: 0;
            text-align: center;
            font-size: 10px;
            color: #007bff;
            font-weight: 600;
            transform: translateY(-70%);
        }

        /* Submit area */
        .submit-area {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        .submit-area div {
            text-align: center;
            color: #007bff;
            font-weight: 600;
        }

        .submit-area div span {
            color: #000;
            display: block;
            font-size: 14px;
            font-weight: 500;
        }

        .submit-area button {
            background: #007bff;
            color: #fff;
            font-weight: 600;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
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

            <div class="home-content">
                <div class="game-section">
                    <div class="row mb-3">
                        <div class="col-6">
                            <input type="date" class="form-control" value="2025-10-24">
                        </div>
                        <div class="col-6">
                            <select class="form-select">
                                <option>OPEN</option>
                                <option>CLOSE</option>
                            </select>
                        </div>
                    </div>

                    <input type="number" id="pointsInput" class="form-control mb-4 w-50" placeholder="Enter points">

                    <!-- Keypad -->
                    {{-- <div class="keypad" id="keypad">
                        <button data-num="1">1</button>
                        <button data-num="2">2</button>
                        <button data-num="3">3</button>
                        <button data-num="4">4</button>
                        <button data-num="5">5</button>
                        <button data-num="6">6</button>
                        <button data-num="7">7</button>
                        <button data-num="8">8</button>
                        <button data-num="9">9</button>
                        <button data-num="0" style="grid-column: 2;">0</button>
                    </div> --}}

                    {{-- <div class="keypad" id="keypad">
                    @foreach ($numbers as $number)
                        <button data-num="{{ $number }}">{{ $number }}</button>
                    @endforeach
                    </div> --}}

                    <div class="keypad" id="keypad">
                        @foreach ($numbers as $index => $number)
                            @php
                                $isLast = $loop->last;
                                $isSingleInLastRow = $isLast && $loop->count % 3 === 1;
                            @endphp

                            <button data-num="{{ $number }}"
                                @if ($isSingleInLastRow) style="grid-column: 2;" @endif>
                                {{ $number }}
                            </button>
                        @endforeach
                    </div>


                    <table class="table table-bordered text-center mt-3">
                        <thead>
                            <tr>
                                <th>Digit</th>
                                <th>Points</th>
                                <th>Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="bidTableBody">
                            <tr>
                                <td colspan="4" class="text-muted">No Bids Added</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="submit-area">
                        <div><strong id="bidCount">0</strong><span>Bids</span></div>
                        <div><strong id="pointCount">0</strong><span>Points</span></div>
                        <button id="submitBid">Submit BID</button>
                    </div>
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
                alert("Enter valid points first!");
                return;
            }

            // Add or update bid
            bids[digit] = {
                points,
                session
            };

            updateKeypadPoints();
            updateTable();
        });

        function updateKeypadPoints() {
            document.querySelectorAll(".keypad button").forEach(btn => {
                const num = btn.dataset.num;
                const existingTag = btn.querySelector(".point-tag");
                if (bids[num]) {
                    if (!existingTag) {
                        const tag = document.createElement("div");
                        tag.classList.add("point-tag");
                        tag.textContent = bids[num].points;
                        btn.appendChild(tag);
                    } else {
                        existingTag.textContent = bids[num].points;
                    }
                } else if (existingTag) {
                    existingTag.remove();
                }
            });
        }

        function updateTable() {
            const keys = Object.keys(bids);
            if (keys.length === 0) {
                bidTable.innerHTML = `<tr><td colspan="4" class="text-muted">No Bids Added</td></tr>`;
            } else {
                bidTable.innerHTML = keys.map(num => `
          <tr>
            <td>${num}</td>
            <td>${bids[num].points}</td>
            <td style="color:#3FDD3F" class="game-types">${bids[num].session}</td>
            <td><button class="btnn" onclick="removeBid('${num}')">X</button></td>
          </tr>`).join("");
            }

            bidCount.textContent = keys.length;
            pointCount.textContent = keys.reduce((sum, n) => sum + bids[n].points, 0);
        }

        function removeBid(num) {
            delete bids[num];
            updateKeypadPoints();
            updateTable();
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
                    updateTable();
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
