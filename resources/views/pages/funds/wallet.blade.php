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

        /* ✅ SCROLLABLE CONTENT ONLY */
        .wallet-page {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .wallet-balance-card {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 20px;
            border-radius: 16px;
            text-align: center;
        }

        .balance-title {
            font-size: 14px;
            opacity: .9;
        }

        .balance-amount {
            font-size: 32px;
            font-weight: 700;
            margin: 6px 0 12px;
        }

        .wallet-actions {
            display: flex;
            gap: 10px;
        }

        .wallet-btn {
            flex: 1;
            padding: 10px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
        }

        .deposit-btn {
            background: #22c55e;
            color: white;
        }

        .withdraw-btn {
            background: #ef4444;
            color: white;
        }

        .wallet-stats {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
        }

        .stat-card {
            background: white;
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
        }

        .stat-card span {
            font-size: 12px;
            color: #777;
        }

        .wallet-options {
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }

        .wallet-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px;
            border-bottom: 1px solid #eee;
            text-decoration: none;
            color: #333;
        }

        .wallet-option i {
            color: #2563eb;
        }

        .wallet-option .arrow {
            margin-left: auto;
        }

        .recent-transactions {
            background: white;
            border-radius: 12px;
            padding: 15px;
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .transaction-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            /* border-bottom: 1px solid #eee; */
        }

        .transaction-row:not(:last-child) {
            border-bottom: 1px solid #eee;
        }

        .credit {
            color: #22c55e;
            font-weight: 600;
        }

        .debit {
            color: #ef4444;
            font-weight: 600;
        }

        .transaction-date {
            display: block;
            font-size: 11px;
            color: #777;
        }

        .empty-transactions {
            text-align: center;
            padding: 25px 10px;
            color: #888;
        }

        .empty-transactions i {
            font-size: 28px;
            color: #2563eb;
            margin-bottom: 8px;
            display: block;
        }

        .empty-transactions p {
            margin: 0;
            font-size: 14px;
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
                <div class="wallet-page">

                    <!-- BALANCE CARD -->
                    <div class="wallet-balance-card">

                        <div class="balance-title">
                            Current Balance
                        </div>

                        <div class="balance-amount">
                            ₹{{ $wallet->balance ?? 0 }}
                        </div>

                        <div class="wallet-actions">

                            <a href="{{ route('deposit.funds.manual') }}" class="wallet-btn deposit-btn">
                                <i class="fa fa-plus"></i>
                                Deposit
                            </a>

                            <a href="{{ route('withdraw.funds') }}" class="wallet-btn withdraw-btn">
                                <i class="fa fa-arrow-up"></i>
                                Withdraw
                            </a>

                        </div>

                    </div>


                    <!-- WALLET STATS -->

                    <div class="wallet-stats">

                        <div class="stat-card">

                            <span>Total Deposit</span>
                            <h6>₹{{ $totalDeposit }}</h6>

                        </div>

                        <div class="stat-card">

                            <span>Total Withdraw</span>
                            <h6>₹{{ $totalWithdraw }}</h6>

                        </div>

                        <div class="stat-card">

                            <span>Today's Profit</span>
                            <h6>₹{{ $todayProfit }}</h6>

                        </div>

                    </div>


                    <!-- QUICK ACTIONS -->

                    <div class="wallet-options">

                        <a href="{{ route('deposit.history') }}" class="wallet-option">

                            <i class="fa fa-money-bill"></i>

                            Deposit History

                            <i class="fa fa-chevron-right arrow"></i>

                        </a>


                        <a href="{{ route('withdraw.history') }}" class="wallet-option">

                            <i class="fa fa-arrow-up"></i>

                            Withdraw History

                            <i class="fa fa-chevron-right arrow"></i>

                        </a>


                        <a href="{{ route('account.statement') }}" class="wallet-option">

                            <i class="fa fa-file-lines"></i>

                            Account Statement

                            <i class="fa fa-chevron-right arrow"></i>

                        </a>

                    </div>


                    <!-- RECENT TRANSACTIONS -->

                    <div class="recent-transactions">

                        <h6 class="section-title">
                            Recent Transactions
                        </h6>

                        @forelse ($transactions as $t)
                            <div class="transaction-row">

                                <div>

                                    <span class="transaction-type">
                                        {{ ucfirst($t->type) }}
                                    </span>

                                    <small class="transaction-date">
                                        {{ $t->created_at->format('d M Y') }}
                                    </small>

                                </div>

                                <div>

                                    @if ($t->type == 'deposit' || $t->type == 'win')
                                        <span class="credit">
                                            +₹{{ $t->amount }}
                                        </span>
                                    @else
                                        <span class="debit">
                                            -₹{{ $t->amount }}
                                        </span>
                                    @endif

                                </div>

                            </div>

                        @empty

                            <div class="empty-transactions">
                                <i class="fa-solid fa-receipt"></i>
                                <p>No transactions yet</p>
                            </div>
                        @endforelse

                    </div>
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




</body>

</html>
