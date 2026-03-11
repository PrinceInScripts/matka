<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Matka Play | My Bids</title>

    <!-- Bootstrap + Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: "Poppins", sans-serif;
            background: #f5f6fa;
            overflow: hidden;
            /* ✅ keep this to prevent double scrollbars */
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
            z-index: 100;
            height: 100vh;
            overflow: hidden;
            /* ✅ keep this */
        }

        /* ✅ add this new section */
        .home-content {
            flex: 1;
            overflow-y: auto;
            /* 👈 allows scrolling */
            padding: 60px 15px 100px;
            /* 👈 gives space below for bottom bar */
            background: #f5f6fa;
        }

        /* Optional: smooth scrolling */
        .home-content::-webkit-scrollbar {
            width: 6px;
        }

        .home-content::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
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

        /* .home-content {
            padding: 70px 15px 90px;
            max-width: 500px;
            margin: 0 auto;
        } */

        .filter-form {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.08);
            padding: 12px 15px;
            margin-bottom: 18px;
        }

        .filter-form input,
        .filter-form select {
            border-radius: 8px !important;
        }

        .statement-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.06);
            padding: 15px 18px;
            margin-bottom: 14px;
            transition: 0.2s;
        }

        .statement-card:hover {
            transform: scale(1.01);
        }

        .date {
            color: #007bff;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .particular {
            font-size: 14px;
            line-height: 1.4;
        }

        .amounts {
            margin-top: 10px;
            font-size: 13px;
        }

        .amounts .label {
            font-weight: 500;
            color: #555;
        }

        .amounts .value {
            float: right;
            font-weight: 600;
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

        .pagination {
            justify-content: center;
            margin-top: 15px;
        }

        .btn-sm {
            border-radius: 8px;
            padding: 4px 12px;
        }

        @media(max-width: 576px) {
            .filter-form .row>div {
                margin-bottom: 8px;
            }
        }

        .quick-filters {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 6px;
        }

        .filter-chip {
            background: #f1f5f9;
            border: none;
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 12px;
            white-space: nowrap;
        }

        .filter-chip.active {
            background: #2563eb;
            color: white;
        }

        .bid-card {
            background: white;
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 14px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, .05);
        }

        .bid-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .bid-market {
            font-weight: 700;
            font-size: 14px;
            color: #2563eb;
        }

        .bid-status {
            font-size: 12px;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .status-win {
            background: #dcfce7;
            color: #16a34a;
        }

        .status-loss {
            background: #fee2e2;
            color: #dc2626;
        }

        .status-pending {
            background: #e0f2fe;
            color: #0284c7;
        }

        .bid-body {
            font-size: 13px;
        }

        .bid-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .bid-number {
            font-size: 16px;
            font-weight: 700;
        }

        .bid-amount {
            color: #2563eb;
            font-weight: 700;
        }

        .bid-footer {
            margin-top: 8px;
            font-size: 12px;
            color: #64748b;
        }

        .empty-bids {
            text-align: center;
            padding: 30px;
            color: #888;
        }

        .bid-filter{
background:white;
padding:12px;
border-radius:14px;
box-shadow:0 6px 12px rgba(0,0,0,.05);
margin-bottom:16px;
}


/* MARKET TABS */

.market-tabs{
display:flex;
gap:6px;
overflow-x:auto;
margin-bottom:10px;
}

.market-tab{
border:none;
background:#f1f5f9;
padding:6px 14px;
border-radius:20px;
font-size:12px;
white-space:nowrap;
}

.market-tab.active{
background:#2563eb;
color:white;
}


/* DATE CHIPS */

.date-filters{
display:flex;
gap:6px;
}

.date-chip{
border:none;
background:#eef2ff;
padding:6px 12px;
border-radius:16px;
font-size:12px;
}

.date-chip.active{
background:#2563eb;
color:white;
}


/* ADVANCED FILTER */

.advanced-filter{
display:none;
margin-top:10px;
border-top:1px solid #eee;
padding-top:10px;
}

.filter-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:10px;
}

.filter-item label{
font-size:11px;
color:#64748b;
}

.filter-actions{
display:flex;
justify-content:space-between;
margin-top:10px;
}
    </style>
</head>

<body>
    <div class="app-layout">
        <!-- ✅ Top Bar -->
        <div class="left-area">
            <div class="top-bar">
                <i class="fa-solid fa-angle-left fs-5 text-primary" onclick="window.history.back()"></i>
                <h6 class="m-0 fw-semibold text-primary">My Bids</h6>
                @include('components.walletinfo')
            </div>

            <!-- ✅ Page Content -->
            <div class="home-content">

                <!-- Filter Form -->
               <div class="bid-filter">

<!-- MARKET TABS -->
<div class="market-tabs">

<button class="market-tab active" data-market="">
All
</button>

<button class="market-tab" data-market="main_market">
Main Market
</button>

<button class="market-tab" data-market="starline">
Starline
</button>

<button class="market-tab" data-market="gali_disawar">
Gali Disawar
</button>

</div>


<!-- DATE FILTER -->
<div class="date-filters">

<button class="date-chip active" data-range="today">
Today
</button>

<button class="date-chip" data-range="week">
7 Days
</button>

<button class="date-chip" data-range="month">
30 Days
</button>

<button id="openAdvanced" class="date-chip">
More
<i class="fa fa-chevron-down"></i>
</button>

</div>


<!-- ADVANCED FILTER -->
<div id="advancedFilters" class="advanced-filter">

<div class="filter-grid">

<div class="filter-item">
<label>Status</label>
<select id="statusFilter" class="form-select form-select-sm">
<option value="">All</option>
<option value="pending">Pending</option>
<option value="won">Won</option>
<option value="lost">Lost</option>
</select>
</div>

<div class="filter-item">
<label>From</label>
<input type="date" id="dateFrom" class="form-control form-control-sm">
</div>

<div class="filter-item">
<label>To</label>
<input type="date" id="dateTo" class="form-control form-control-sm">
</div>

</div>

<div class="filter-actions">

<button id="applyFilters" class="btn btn-primary btn-sm">
Apply
</button>

<button id="resetFilters" class="btn btn-light btn-sm">
Reset
</button>

</div>

</div>

</div>

                <!-- Bids List -->
                <div id="bidList">
                    @include('pages.bids.partials.bid-list', ['bids' => $bids])
                </div>

            </div>

            @include('components.bottombar')
        </div>
        @include('components.rightside')
    </div>

    <!-- ✅ Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    {{-- <script>

      
        $(function() {
            // Handle Filter Submit
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                loadBids(1);
            });

            // Reset Filters
            $('#resetFilter').click(function() {
                $('#filterForm')[0].reset();
                loadBids(1);
            });

            // Handle Pagination
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                loadBids(page);
            });

            // Load Bids via AJAX
            function loadBids(page) {
                $.ajax({
                    url: "{{ route('my.bids') }}" + "?page=" + page,
                    method: 'GET',
                    data: $('#filterForm').serialize(),
                    beforeSend: function() {
                        $('#bidList').html('<div class="text-center p-3 text-muted">Loading...</div>');
                    },
                    success: function(res) {
                        $('#bidList').html(res.html);
                    },
                    error: function() {
                        $('#bidList').html(
                            '<div class="text-center p-3 text-danger">Failed to load data.</div>');
                    }
                });
            }
        });
    </script> --}}

    <script>
       $(function(){

let filters={
market:'',
range:'today',
status:'',
date_from:'',
date_to:''
};


/* MARKET TABS */

$(document).on("click",".market-tab",function(){

$(".market-tab").removeClass("active");
$(this).addClass("active");

filters.market=$(this).data("market");

loadBids(1);

});


/* DATE FILTER */

$(document).on("click",".date-chip[data-range]",function(){

$(".date-chip[data-range]").removeClass("active");
$(this).addClass("active");

filters.range=$(this).data("range");

loadBids(1);

});


/* OPEN ADVANCED */

$("#openAdvanced").click(function(){

$("#advancedFilters").slideToggle(150);

});


/* APPLY ADVANCED */

$("#applyFilters").click(function(){

filters.status=$("#statusFilter").val();
filters.date_from=$("#dateFrom").val();
filters.date_to=$("#dateTo").val();

filters.range="custom";

loadBids(1);

});


/* RESET */

$("#resetFilters").click(function(){

filters={
market:'',
range:'today',
status:'',
date_from:'',
date_to:''
};

$(".market-tab").removeClass("active");
$(".market-tab[data-market='']").addClass("active");

$(".date-chip").removeClass("active");
$(".date-chip[data-range='today']").addClass("active");

$("#statusFilter").val('');
$("#dateFrom").val('');
$("#dateTo").val('');

loadBids(1);

});


/* PAGINATION */

$(document).on("click",".pagination a",function(e){

e.preventDefault();

let page=$(this).attr("href").split("page=")[1];

loadBids(page);

});


/* AJAX LOAD */

function loadBids(page){

$.ajax({

url:"{{ route('my.bids') }}",
method:"GET",

data:{
page:page,
market:filters.market,
range:filters.range,
status:filters.status,
date_from:filters.date_from,
date_to:filters.date_to
},

beforeSend:function(){

$("#bidList").html(`
<div style="text-align:center;padding:30px;color:#64748b">
<i class="fa fa-spinner fa-spin"></i>
Loading bids...
</div>
`);

},

success:function(res){

$("#bidList").html(res.html);

},

error:function(){

$("#bidList").html(`
<div style="text-align:center;padding:30px;color:red">
Failed to load bids
</div>
`);

}

});

}

});
    </script>
</body>

</html>
