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

    {{-- <link href="https://pro.fontawesome.com/releases/v6.5.2/css/all.css" rel="stylesheet"> --}}

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <style>
        .home-content {
            flex: 1;
            overflow-y: auto;
            background: #f5f6fa;
            padding: 20px 15px 90px 15px;
            height: calc(100dvh - 140px);
            -webkit-overflow-scrolling: touch;
            box-sizing: border-box;
        }

        .fund-card{
background:white;
border-radius:16px;
padding:16px;
box-shadow:0 6px 14px rgba(0,0,0,0.06);
}

.fund-header{
display:flex;
align-items:center;
gap:8px;
font-weight:700;
font-size:16px;
margin-bottom:12px;
color:#2563eb;
}

.wallet-info{
background:#f8fafc;
padding:10px;
border-radius:10px;
margin-bottom:14px;
font-size:13px;
display:flex;
justify-content:space-between;
}

.wallet-info strong{
color:#22c55e;
font-size:16px;
}

.input-group-box{
display:flex;
flex-direction:column;
gap:4px;
margin-bottom:12px;
}

.input-group-box input{
height:44px;
border-radius:10px;
border:1px solid #e2e8f0;
padding:0 12px;
}

.quick-amounts{
display:flex;
gap:8px;
margin-bottom:12px;
flex-wrap:wrap;
}

.amount-chip{
background:#f1f5f9;
border:none;
border-radius:20px;
padding:6px 12px;
font-size:12px;
}

.amount-chip:hover{
background:#2563eb;
color:white;
}

.payment-method select{
width:100%;
height:44px;
border-radius:10px;
border:1px solid #e2e8f0;
margin-bottom:14px;
padding:0 10px;
}

.fund-btn{
width:100%;
height:46px;
border:none;
border-radius:12px;
background:#22c55e;
color:white;
font-weight:700;
}
    
    </style>

</head>

<body>

    {{-- <div class="overlay" id="overlay"></div> --}}

    <div class="app-layout">
        <!-- LEFT AREA -->
        <div class="left-area">
            @include('components.topbar')
           <div class="home-content">

<div class="fund-card">

<div class="fund-header">
<i class="fa-solid fa-wallet"></i>
<span>Add Funds</span>
</div>

<div class="wallet-info">
Current Balance
<strong>₹{{ auth()->user()->wallet->balance }}</strong>
</div>

<form id="depositForm">

<div class="input-group-box">
<label>Enter Amount</label>
<input type="number" id="depositAmount" placeholder="Minimum ₹100">
</div>

<div class="quick-amounts">

<button type="button" class="amount-chip" data-amount="500">₹500</button>
<button type="button" class="amount-chip" data-amount="1000">₹1000</button>
<button type="button" class="amount-chip" data-amount="2000">₹2000</button>
<button type="button" class="amount-chip" data-amount="5000">₹5000</button>

</div>

<div class="payment-method">

<label>Select Payment</label>

<select id="paymentMethod">
<option value="upi">UPI</option>
<option value="qr">QR Code</option>
<option value="bank">Bank Transfer</option>
</select>

</div>

<button class="fund-btn" type="submit">
<i class="fa fa-arrow-down"></i>
Deposit
</button>

</form>

</div>

</div>



            @include('components.bottombar')

            <!-- SIDEBAR -->
            @include('components.sidebar')

        </div>

        <!-- RIGHT AREA (Main Content) -->
        @include('components.rightside')


    </div>




    <!-- Bootstrap JS Bundle (Required for Modals, Toasts, Dropdowns, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

<script>

$(function(){

/* quick amount */
$(".amount-chip").click(function(){

let amt = $(this).data("amount");

$("#depositAmount").val(amt);

});


/* submit deposit */

$("#depositForm").submit(function(e){

e.preventDefault();

let amount = $("#depositAmount").val();
let method = $("#paymentMethod").val();

if(!amount || amount < 100){

Toastify({
text:"Minimum deposit ₹100",
backgroundColor:"#ef4444",
duration:2500
}).showToast();

return;
}

$.ajax({

url:"{{ route('deposit.funds.store') }}",
method:"POST",

data:{
amount:amount,
method:method,
_token:"{{ csrf_token() }}"
},

beforeSend:function(){

$(".fund-btn").text("Processing...");

},

success:function(res){

Toastify({
text:"Deposit request submitted",
backgroundColor:"#22c55e",
duration:2500
}).showToast();

location.reload();

},

error:function(){

Toastify({
text:"Deposit failed",
backgroundColor:"#ef4444",
duration:2500
}).showToast();

$(".fund-btn").text("Deposit");

}

});

});

});

</script>


</body>

</html>
