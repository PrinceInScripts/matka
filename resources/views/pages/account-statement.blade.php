@php
  use App\Models\Setting;
  $siteName = Setting::get('site_name') ?? 'Matka Play';
  $siteLogo = Setting::get('site_logo');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $siteName }} | Account Statement</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .left-area {
            background: #fff;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            position: relative;
            height: 100vh;
            overflow: hidden;
        }

        .top-bar {
            position: fixed;
            top: 0;
            width: 100%;
            max-width: 500px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: #fff;
            border-bottom: 1px solid #eee;
            z-index: 999;
        }

        .home-content {
            flex: 1;
            overflow-y: auto;
            padding: 70px 15px 90px;
            background: #f5f6fa;
        }

        .statement-filter {
            background: white;
            border-radius: 16px;
            padding: 14px;
            margin-bottom: 16px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.05);
        }


        /* quick filter chips */

        .quick-types {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 6px;
        }

        .type-chip {
            background: #f1f5f9;
            border: none;
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 12px;
            white-space: nowrap;
        }

        .type-chip.active {
            background: #2563eb;
            color: white;
        }

        .filter-open-btn {
            border: none;
            background: #111;
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
        }


        /* ADVANCED FILTER */

        .advanced-filter {
            position: fixed;
            bottom: -400px;
            left: 0;
            right: 0;
            background: white;
            border-radius: 18px 18px 0 0;
            padding: 16px;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.15);
            transition: .3s;
            z-index: 1000;
        }

        .advanced-filter.show {
            bottom: 0;
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .filter-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* search */

        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f8fafc;
            border-radius: 10px;
            padding: 8px 10px;
            margin-bottom: 10px;
        }

        .search-box input {
            border: none;
            outline: none;
            background: none;
            flex: 1;
            font-size: 13px;
        }


        /* date */

        .date-row {
            display: flex;
            gap: 10px;
        }

        .date-input {
            flex: 1;
            display: flex;
            flex-direction: column;
            font-size: 12px;
            color: #64748b;
        }

        .date-input input {
            height: 38px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0 8px;
        }


        /* actions */

        .filter-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 12px;
        }

        .apply-btn {
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 6px 20px;
            font-weight: 600;
        }

        .reset-btn {
            background: #e2e8f0;
            border: none;
            border-radius: 10px;
            padding: 6px 20px;
        }

        /* .filter-form {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.08);
      padding: 12px 15px;
      margin-bottom: 18px;
    } */

        .filter-form {
            background: white;
            padding: 14px;
            border-radius: 14px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 16px;
        }

        .filter-form button {
            height: 36px;
            border-radius: 8px;
        }

        /* .statement-card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.05);
      padding: 15px 18px;
      margin-bottom: 15px;
      transition: 0.2s;
    }

    .statement-card:hover { transform: scale(1.01); } */

        .statement-card {
            background: white;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 14px;

            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.05);
            transition: .2s;
        }

        .statement-card:hover {
            transform: translateY(-2px);
        }

        .statement-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .statement-left {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .statement-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 14px;
            color: white;
        }

        .icon-credit {
            background: #22c55e;
        }

        .icon-debit {
            background: #ef4444;
        }

        .statement-type {
            font-weight: 600;
            font-size: 14px;
        }

        .statement-date {
            font-size: 12px;
            color: #64748b;
        }

        .statement-amount {
            font-weight: 700;
            font-size: 16px;
        }

        .amount-credit {
            color: #22c55e;
        }

        .amount-debit {
            color: #ef4444;
        }

        .statement-body {
            margin-top: 8px;
            font-size: 13px;
            color: #475569;
        }

        .balance-row {
            display: flex;
            justify-content: space-between;
            margin-top: 6px;
            font-size: 13px;
        }

        .balance-row span:last-child {
            font-weight: 600;
            color: #2563eb;
        }

        .date {
            color: #007bff;
            font-weight: 600;
            font-size: 13px;
        }

        .particular {
            font-size: 13px;
            font-weight: 500;
            margin-top: 3px;
            color: #333;
        }

        .amounts {
            margin-top: 10px;
            font-size: 13px;
            color: #444;
        }

        .amounts div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .value.positive {
            color: #28a745;
        }

        .value.negative {
            color: #dc3545;
        }

        .value.neutral {
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="app-layout">
        <div class="left-area">
            <!-- ✅ Top Bar -->
            <div class="top-bar">
                <i class="fa-solid fa-angle-left text-primary fs-5" onclick="window.history.back()"></i>
                <h6 class="m-0 fw-semibold text-primary">Account Statement</h6>
                @include('components.walletinfo')
            </div>

            <!-- ✅ Content -->
            <div class="home-content">

                <!-- ✅ Filter Form -->
                <form id="filterForm" class="filter-form">
                    <div class="statement-filter">

                        <!-- TYPE QUICK FILTER -->
                        <div class="quick-types">

                            <button class="type-chip active" data-type="">
                                All
                            </button>

                            <button class="type-chip" data-type="credit">
                                Credit
                            </button>

                            <button class="type-chip" data-type="debit">
                                Debit
                            </button>

                           

                             {{-- <button class="type-chip" data-source="main_market_bid">Main Market</button> --}}

                            <button type="button" class="filter-open-btn">
                                <i class="fa fa-sliders"></i> Filter
                            </button>

                        </div>

                        <div class="advanced-filter" id="advancedFilter">

                            <div class="filter-header">
                                <span>Advanced Filters</span>
                                <button type="button" id="closeFilter">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>

                            <div class="filter-options">

                               <button class="type-chip" data-type="credit">
                                Credit
                            </button>

                            <button class="type-chip" data-type="debit">
                                Debit
                            </button>
                            

                                <button class="type-chip" data-source="deposit">Deposit</button>

                                <button class="type-chip" data-source="withdraw">Withdraw</button>

                                 <button class="type-chip" data-source="main_market_bid">
                                Bets
                            </button>

                            <button class="type-chip" data-source="main_market_bid">Main Market</button>
                                <button class="type-chip" data-source="starline_bid">Starline</button>

                                <button class="type-chip" data-source="gali_disawar_bid">Gali Disawar</button>

                                <button class="type-chip" data-source="win">Wins</button>

                                <button class="type-chip" data-source="loss">Loss</button>

                            </div>

                        </div>


                        <!-- SEARCH -->
                        <div class="search-row">

                            <div class="search-box">
                                <i class="fa fa-search"></i>
                                <input type="text" name="reason" placeholder="Search reason..." id="reasonSearch">
                            </div>

                        </div>


                        <!-- DATE FILTER -->
                        <div class="date-row">

                            <div class="date-input">
                                <label>From</label>
                                <input type="date" name="date_from" id="dateFrom">
                            </div>

                            <div class="date-input">
                                <label>To</label>
                                <input type="date" name="date_to" id="dateTo">
                            </div>

                        </div>


                        <!-- ACTIONS -->
                        <div class="filter-actions">

                            <button id="applyFilter" class="apply-btn">
                                <i class="fa fa-filter"></i> Apply
                            </button>

                            <button id="resetFilter" class="reset-btn">
                                Reset
                            </button>

                        </div>

                    </div>
                </form>

                <!-- ✅ Transactions List -->
                <div id="transactionList">
                    @include('pages.account-statement-partials-list', ['transactions' => $transactions])
                </div>

            </div>

            @include('components.bottombar')
        </div>

        @include('components.rightside')
    </div>

    <!-- ✅ Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

   <script>

$(document).ready(function(){

let filters = {
type: "",
source: "",
reason: "",
date_from: "",
date_to: ""
};

let currentPage = 1;


/* --------------------------
OPEN FILTER PANEL
--------------------------*/

$(".filter-open-btn").click(function(e){
e.preventDefault();
$("#advancedFilter").addClass("show");
});

$("#closeFilter").click(function(e){
e.preventDefault();
$("#advancedFilter").removeClass("show");
});


/* --------------------------
TYPE CHIPS (Quick Filters)
--------------------------*/

$(document).on("click",".type-chip",function(e){

e.preventDefault();

$(".type-chip").removeClass("active");
$(this).addClass("active");

filters.type   = $(this).data("type") || "";
filters.source = $(this).data("source") || "";

loadTransactions(1);

});


/* --------------------------
SEARCH INPUT (DEBOUNCE)
--------------------------*/

let searchTimer;

$("#reasonSearch").on("keyup",function(){

clearTimeout(searchTimer);

searchTimer = setTimeout(function(){

filters.reason = $("#reasonSearch").val();

loadTransactions(1);

},400);

});


/* --------------------------
DATE FILTER
--------------------------*/

$("#dateFrom, #dateTo").on("change",function(){

filters.date_from = $("#dateFrom").val();
filters.date_to   = $("#dateTo").val();

});


/* --------------------------
APPLY FILTER BUTTON
--------------------------*/

$("#applyFilter").on("click",function(e){

e.preventDefault();

filters.reason    = $("#reasonSearch").val();
filters.date_from = $("#dateFrom").val();
filters.date_to   = $("#dateTo").val();

$("#advancedFilter").removeClass("show");

loadTransactions(1);

});


/* --------------------------
RESET FILTER
--------------------------*/

$("#resetFilter").on("click",function(e){

e.preventDefault();

filters = {
type:"",
source:"",
reason:"",
date_from:"",
date_to:""
};

$("#reasonSearch").val("");
$("#dateFrom").val("");
$("#dateTo").val("");

$(".type-chip").removeClass("active");
$(".type-chip[data-type='']").addClass("active");

$("#advancedFilter").removeClass("show");

loadTransactions(1);

});


/* --------------------------
PAGINATION
--------------------------*/

$(document).on("click",".pagination a",function(e){

e.preventDefault();

let page = $(this).attr("href").split("page=")[1];

loadTransactions(page);

});


/* --------------------------
AJAX LOADER
--------------------------*/

function loadTransactions(page){

currentPage = page;

$.ajax({

url:"{{ route('account.statement') }}",
method:"GET",

data:{
page:page,
type:filters.type,
source:filters.source,
reason:filters.reason,
date_from:filters.date_from,
date_to:filters.date_to
},

beforeSend:function(){

$("#transactionList").html(`
<div style="text-align:center;padding:40px;color:#64748b">
<i class="fa fa-spinner fa-spin fa-lg"></i><br><br>
Loading transactions...
</div>
`);

},

success:function(res){

$("#transactionList").html(res.html);

},

error:function(){

$("#transactionList").html(`
<div style="text-align:center;padding:40px;color:#ef4444">
Failed to load transactions
</div>
`);

}

});

}


/* --------------------------
AUTO LOAD FIRST PAGE
--------------------------*/

loadTransactions(1);


});

</script>
</body>

</html>
