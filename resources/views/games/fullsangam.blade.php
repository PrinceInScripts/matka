
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

        .change-btn {
            background: #28a745;
            color: #fff;
            font-weight: 600;
            border: none;
            padding: 10px;
            border-radius: 25px;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
            transition: 0.3s;
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
                               {{-- change btn --}}
                               {{-- <button type="button" class="change-btn w-100 mt-4">Change</button> --}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 form-group">
                                <input type="text" id="open-panna" name="open-panna" placeholder="Enter Open Panna">
                                
                            </div>
                            <div class="col-6 form-group">
                                <input type="text" id="close-panna" name="close-panna" placeholder="Enter Close Panna" >
                            </div>
                        </div>

                        <div class="row">
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const addBidBtn = document.querySelector(".add-bid-btn");
            const submitBidBtn = document.querySelector(".submit-bid-btn");
            const bidTableBody = document.querySelector(".bid-table tbody");

            let totalPoints = 0;
            let totalBids = 0;


            const inputs = {
        openPanna: document.getElementById("open-panna"),
        closePanna: document.getElementById("close-panna"),
        points: document.getElementById("points")
    };


     // 🟨 LIVE INPUT VALIDATION
    function limitDigits(input, limit, label) {
        input.addEventListener("input", () => {
            let val = input.value.replace(/\D/g, ""); // only numbers
            if (val.length > limit) {
                input.value = val.slice(0, limit);
                Toastify({
                    text: `Only ${limit} digits allowed for ${label}.`,
                    duration: 2500,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#ff6b6b",
                }).showToast();
            } else {
                input.value = val;
            }

            // color feedback
            if (input.value.length === limit) {
                input.style.borderColor = "green";
            }else {
                input.style.borderColor = "";
            }
        });
    }

    // apply to all inputs
    limitDigits(inputs.openPanna, 3, "Panna");
    limitDigits(inputs.closePanna, 3, "Panna");



       

            // 🟩 Add Bid
            addBidBtn.addEventListener("click", () => {
        let openPanna = inputs.openPanna.value.trim();
        let closePanna = inputs.closePanna.value.trim();
        let points = parseInt(inputs.points.value.trim()) || 0;

        if (!openPanna || !closePanna || points <= 0) {
            Toastify({
                text: "Please fill all fields with valid values!",
                duration: 2500,
                gravity: "top",
                position: "center",
                backgroundColor: "#ff6b6b",
            }).showToast();
            return;
        }

        // Validation
        if (openPanna.length !== 3 || isNaN(openPanna)) {
            Toastify({
                text: "Open Panna must be exactly 3 numbers!",
                duration: 2500,
                gravity: "top",
                position: "center",
                backgroundColor: "#ff6b6b",
            }).showToast();
            return;
        }
        if (closePanna.length !== 3 || isNaN(closePanna)) {
            Toastify({
                text: "Close Panna must be exactly 3 numbers!",
                duration: 2500,
                gravity: "top",
                position: "center",
                backgroundColor: "#ff6b6b",
            }).showToast();
            return;
        }

        // ✅ Passed all validation — add the bid
        const noBidRow = bidTableBody.querySelector(".text-muted");
        if (noBidRow) noBidRow.parentElement.remove();

        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td>${openPanna}-${closePanna}</td>
            <td>${points}</td>
            <td><button class="btnn"><i class="fa-solid fa-xmark"></i></button></td>
        `;
        bidTableBody.appendChild(newRow);

        totalBids++;
        totalPoints += points;
        updateDisplay();

        // Reset inputs
        inputs.openPanna.value = "";
        inputs.closePanna.value = "";
        inputs.points.value = "";

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


            // 🟩 Submit Bid
           // 🟩 Submit Bid (via AJAX)
submitBidBtn.addEventListener("click", () => {
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

    // Build all bids from table
    const allBids = [];
    bidTableBody.querySelectorAll("tr").forEach(row => {
        const cols = row.querySelectorAll("td");
        if (cols.length === 3 && !cols[0].classList.contains("text-muted")) {
            const text = cols[0].innerText.trim(); // e.g. "123-456"
            const [open, close] = text.split("-");
            allBids.push({
                digits: `${open}-${close}`,   // backend expects one field "digits"
                points: parseInt(cols[1].innerText),
                session: "open"               // 🔹 you can set "open" or "close" or dynamic later
            });
        }
    });

    if (allBids.length === 0) {
        Toastify({
            text: "No valid bids found!",
            duration: 2500,
            gravity: "top",
            position: "center",
            backgroundColor: "#ff6b6b",
        }).showToast();
        return;
    }

    const payload = {
        date: document.getElementById("date").value,
        market_id: "{{ $game->id ?? '' }}",
        market_type: "{{ $marketType ?? 'open' }}", // required by backend
        game_id: "{{ $game->id ?? '' }}",
        game_type_id: "{{ $gameType->id ?? '' }}",
        bids: allBids,
        game_type: "{{ $game_type ?? 'main' }}"  // new field for backend
    };

    // Disable button + show loader
    const originalText = submitBidBtn.textContent;
    submitBidBtn.disabled = true;
    submitBidBtn.textContent = "Submitting...";

    $.ajax({
        url: "{{ route('place.bids') }}",
        type: "POST",
        data: JSON.stringify(payload),
        contentType: "application/json",
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        success: function (response) {
            Toastify({
                text: "Bids submitted successfully!",
                duration: 2500,
                gravity: "top",
                position: "center",
                backgroundColor: "#28a745",
            }).showToast();

            // Reset
            bidTableBody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">No Bids Added</td></tr>`;
            totalBids = 0;
            totalPoints = 0;
            updateDisplay();
            document.querySelectorAll(".bid-form input").forEach(i => i.value = "");

            submitBidBtn.disabled = false;
            submitBidBtn.textContent = originalText;
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Toastify({
                text: "Failed to submit bids! Please try again.",
                duration: 2500,
                gravity: "top",
                position: "center",
                backgroundColor: "#ff6b6b",
            }).showToast();
            submitBidBtn.disabled = false;
            submitBidBtn.textContent = originalText;
        }
    });
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
