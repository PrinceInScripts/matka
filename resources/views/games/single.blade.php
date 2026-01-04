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


    <style>
        /* ✅ FIXED TOP BAR */
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

        /* ✅ SCROLLABLE CONTENT ONLY */
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


        /* ---------- CUSTOM UI AREA ---------- */

        .game-section {
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
                <div class="game-section">
                    <div class="game-header">
                        <h5>Game Entry</h5>
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
                                   
                                    name="digit" {{-- maxlength="{{ $digitsLimit }}" --}} placeholder="{{ $gameType->name }}">
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

    <script>
        function goBack() {
            window.history.back();
        }
    </script>

    {{-- <script>
        document.addEventListener("DOMContentLoaded", () => {
            const addBidBtn = document.querySelector(".add-bid-btn");
            const submitBidBtn = document.querySelector(".submit-bid-btn");
            const bidTableBody = document.querySelector(".bid-table tbody");
            const pointsDisplay = document.querySelector(".submit-btn .digit:nth-child(1)");
            const bidsDisplay = document.querySelector(".submit-btn .digit:nth-child(3)");

            const inputs = {
                date: document.getElementById("date"),
                session: document.getElementById("session"),
                pana: document.getElementById("digit"),
                points: document.getElementById("points"),
            };

            let totalPoints = 0;
            let totalBids = 0;

            // 🟦 Add Bid
            addBidBtn.addEventListener("click", () => {
                const pana = inputs.pana.value.trim();
                const points = parseInt(inputs.points.value.trim()) || 0;
                const gameType = inputs.session.value;

                if (pana === "" || points <= 0) {
                    alert("Please enter a valid digit and points!");
                    return;
                }

                // Remove "No Bids Added" placeholder
                const noBidRow = bidTableBody.querySelector(".text-muted");
                if (noBidRow) noBidRow.parentElement.remove();

                // Create new row
                const newRow = document.createElement("tr");
                newRow.innerHTML = `
            <td>${pana}</td>
            <td>${points}</td>
            <td style="color:#3FDD3F;" class="game-type">${gameType}</td>
            <td><button class="btnn"><i class="fa-solid fa-xmark"></i></button></td>
        `;
                bidTableBody.appendChild(newRow);
                const digitInput = document.getElementById('digit');

                digitInput.style.borderColor = '';

                // Update totals
                totalBids++;
                totalPoints += points;
                updateDisplay();

                // Clear input fields
                inputs.pana.value = "";
                inputs.points.value = "";

                // Add delete handler
                newRow.querySelector(".btnn").addEventListener("click", () => {
                    totalPoints -= points;
                    totalBids--;
                    newRow.remove();
                    if (bidTableBody.children.length === 0) {
                        bidTableBody.innerHTML =
                            `<tr><td colspan="4" class="text-center text-muted">No Bids Added</td></tr>`;
                    }
                    updateDisplay();
                });
            });

            // 🟩 Submit Bid
            submitBidBtn.addEventListener("click", () => {
                if (totalBids === 0) {
                    alert("No bids to submit!");
                    return;
                }

                const bids = [];
                bidTableBody.querySelectorAll("tr").forEach(row => {
                    const cells = row.querySelectorAll("td");
                    if (cells.length === 4) {
                        bids.push({
                            pana: cells[0].innerText,
                            points: parseInt(cells[1].innerText),
                            gameType: cells[2].innerText,
                        });
                    }
                });

                console.log("🧾 Submitted Bids:", bids);

                alert(`You submitted ${totalBids} bids totaling ${totalPoints} points.`);

                // Reset table and totals
                bidTableBody.innerHTML =
                    `<tr><td colspan="4" class="text-center text-muted">No Bids Added</td></tr>`;
                totalBids = 0;
                totalPoints = 0;
                updateDisplay();
            });

            // 🔵 Update display numbers
            function updateDisplay() {
                document.querySelector(".submit-btn div:first-child .digit").textContent = totalPoints;
                document.querySelector(".submit-btn div:nth-child(2) .digit").textContent = totalBids;
            }
        });


        function checkDigit(validNumbers, digitsLimit) {
            const input = document.getElementById('digit');
            let val = input.value.trim();

            if (!val) {
                input.style.borderColor = '';
                return;
            }

            // Limit length
            if (val.length > digitsLimit) {
                input.value = val.slice(0, digitsLimit);
                Toastify({
                    text: `Only ${digitsLimit} digits allowed.`,
                    duration: 2500,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#ff6b6b",
                }).showToast();
                return;
            }

            if (val.length < digitsLimit) {
                input.style.borderColor = '#ffaa00'; // orange = typing in progress
                return;
            }


            // Validate number
            if (!validNumbers.includes(val)) {
                input.style.borderColor = 'red';
                Toastify({
                    text: `Invalid number! Please enter a valid one.`,
                    duration: 2500,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#ff6b6b",
                }).showToast();
            } else {
                input.style.borderColor = 'green';
            }
        }
    </script> --}}

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const addBidBtn = document.querySelector(".add-bid-btn");
            const submitBidBtn = document.querySelector(".submit-bid-btn");
            const bidTableBody = document.querySelector(".bid-table tbody");

            let totalPoints = 0;
            let totalBids = 0;

            const inputs = {
                date: document.getElementById("date"),
                session: document.getElementById("session"),
                pana: document.getElementById("digit"),
                points: document.getElementById("points"),
            }

            const validNumbers = @json($numbers);
            const digitsLimit = {{ $digitsLimit }};

            inputs.pana.addEventListener("input", () => {
                checkDigit(inputs.pana, validNumbers, digitsLimit);
            });

            // 🟦 Add Bid button click
            addBidBtn.addEventListener("click", () => {
                const pana = inputs.pana.value.trim();
                const points = parseInt(inputs.points.value.trim()) || 0;
                const gameType = inputs.session.value;

                // Validate fields before adding
                if (!pana || points <= 0) {
                    Toastify({
                        text: "Please enter a valid number and points!",
                        duration: 2500,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#ff6b6b",
                    }).showToast();
                    return;
                }

                if (pana.length !== digitsLimit) {
                    Toastify({
                        text: `Number must be exactly ${digitsLimit} digits long.`,
                        duration: 2500,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#ff6b6b",
                    }).showToast();
                    return;
                }

                if (!validNumbers.includes(pana)) {
                    Toastify({
                        text: "Invalid number! Please enter a valid one.",
                        duration: 2500,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#ff6b6b",
                    }).showToast();
                    inputs.pana.style.borderColor = 'red';
                    return;
                }

                // ✅ Passed all validation — add the bid
                const noBidRow = bidTableBody.querySelector(".text-muted");
                if (noBidRow) noBidRow.parentElement.remove();

                const newRow = document.createElement("tr");
                newRow.innerHTML = `
            <td>${pana}</td>
            <td>${points}</td>
            <td style="color:#3FDD3F;" class="game-type">${gameType}</td>
            <td><button class="btnn"><i class="fa-solid fa-xmark"></i></button></td>
        `;
                bidTableBody.appendChild(newRow);

                // Update totals
                totalBids++;
                totalPoints += points;
                updateDisplay();

                // Reset inputs
                inputs.pana.value = "";
                inputs.points.value = "";
                inputs.pana.style.borderColor = "";

                // Delete row handler
                newRow.querySelector(".btnn").addEventListener("click", () => {
                    totalPoints -= points;
                    totalBids--;
                    newRow.remove();

                    if (bidTableBody.children.length === 0) {
                        bidTableBody.innerHTML =
                            `<tr><td colspan="4" class="text-center text-muted">No Bids Added</td></tr>`;
                    }
                    updateDisplay();
                });
            });

            submitBidBtn.addEventListener("click", async () => {
                
                if (totalBids === 0) {
                    Toastify({
                        text: "No bids to submit!",
                        duration: 2500,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#ff6b6b",
                    }).showToast();
                    return;
                }

                // Collect all bids
                const bids = [];
                bidTableBody.querySelectorAll("tr").forEach(row => {
                    const cells = row.querySelectorAll("td");
                    if (cells.length === 4) {
                        bids.push({
                            digits: cells[0].innerText,
                            points: parseInt(cells[1].innerText),
                            session: cells[2].innerText,
                        });
                    }
                });

                console.log("🧾 Submitted Bids:", bids);


                // Prepare data for backend
                const payload = {
                    date: inputs.date.value,
                    market_id: "{{ $game->id ?? '' }}", // from blade
                    market_type: "{{ $game->type ?? 'main' }}",
                    game_id: "{{ $game->id ?? '' }}",
                    game_type_id: "{{ $gameType->id ?? '' }}",
                    bids: bids,
                    game_type: "{{ $game_type ?? 'main' }}"
                };

                try {
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

                            // Reset UI
                            $("#bidTableBody").html(
                                `<tr><td colspan="4" class="text-center text-muted">No Bids Added</td></tr>`
                            );
                            totalBids = 0;
                            totalPoints = 0;
                            updateDisplay();
                        },
                        error: function(xhr) {
                            let message = "Failed to submit bids!";
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

                } catch (err) {
                    console.error("Error submitting bids:", err);
                    Toastify({
                        text: "Network or server error!",
                        duration: 2500,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#ff6b6b",
                    }).showToast();
                }

                 bidTableBody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">No Bids Added</td></tr>`;
        totalBids = 0;
        totalPoints = 0;
        updateDisplay();
            });


            // 🔵 Helper: Update totals in footer
            function updateDisplay() {
                document.querySelector(".submit-btn div:first-child .digit").textContent = totalPoints;
                document.querySelector(".submit-btn div:nth-child(2) .digit").textContent = totalBids;
            }

            // 🔵 Validation Function
            function checkDigit(input, validNumbers, digitsLimit) {
                let val = input.value.trim();

                // Empty
                if (!val) {
                    input.style.borderColor = "";
                    return;
                }

                // Too long
                if (val.length > digitsLimit) {
                    input.value = val.slice(0, digitsLimit);
                    Toastify({
                        text: `Only ${digitsLimit} digits allowed.`,
                        duration: 2500,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#ff6b6b",
                    }).showToast();
                    return;
                }

                // Still typing
                if (val.length < digitsLimit) {
                    input.style.borderColor = "#ffaa00"; // yellow = in progress
                    return;
                }

                // Validate when fully typed
                if (!validNumbers.includes(val)) {
                    input.style.borderColor = "red";
                    Toastify({
                        text: `Invalid number! Please enter a valid one.`,
                        duration: 2500,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#ff6b6b",
                    }).showToast();
                } else {
                    input.style.borderColor = "green";
                }
            }

        });
    </script>



</body>

</html>
