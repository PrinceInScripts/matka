<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FundController extends Controller
{
    public function allFunds()
    {
        return view('pages.funds.all-funds');
    }

    public function wallet()
    {
        $wallet = Wallet::where('user_id',Auth::id())->first();

$totalDeposit = WalletTransactions::where('wallet_id',$wallet->id)
->where('type','deposit')
->sum('amount');

$totalWithdraw = WalletTransactions::where('wallet_id',$wallet->id)
->where('type','withdraw')
->sum('amount');

$todayProfit = WalletTransactions::where('wallet_id',$wallet->id)
->whereDate('created_at',today())
->where('type','win')
->sum('amount');

$transactions = WalletTransactions::where('wallet_id',$wallet->id)
->latest()
->limit(5)
->get();

        return view('pages.funds.wallet',compact(
'wallet',
'totalDeposit',
'totalWithdraw',
'todayProfit',
'transactions'
));
    }

    public function depositFundsAuto()
    {
//         sendNotification(
//     $user->id,
//     "Deposit Approved",
//     "₹{$amount} has been added to your wallet",
//     "wallet"
// );

// sendNotification(
//     $user->id,
//     "Withdrawal Requested",
//     "Your withdrawal request of ₹{$amount} is under review",
//     "wallet"
// );

// sendNotification(
//     $user->id,
//     "Withdrawal Approved",
//     "₹{$amount} has been sent to your account",
//     "wallet"
// );

// sendNotification(
//     $user->id,
//     "Withdrawal Rejected",
//     "Your withdrawal request was rejected",
//     "wallet"
// );
        return view('pages.funds.add_funds_auto');
    }

    public function depositFundsManual()
    {
        return view('pages.funds.add_funds_manual');
    }

    public function withdrawFunds()
    {
        return view('pages.funds.withdraw');
    }

    public function addBank()
    {
        return view('pages.funds.add_bank_details');
    }

    public function depositHistory()
    {
        return view('pages.funds.deposit_history');
    }

    public function withdrawHistory()
    {
        return view('pages.funds.withdraw_history');
    }


}
