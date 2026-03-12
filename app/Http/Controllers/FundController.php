<?php
namespace App\Http\Controllers;
use App\Models\DepositRequest;
use App\Models\Wallet;
use App\Models\WalletTransactions;
use App\Models\WithdrawRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FundController extends Controller
{
    public function wallet()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();
        $totalDeposit  = WalletTransactions::where('wallet_id', $wallet->id)->where('source','deposit')->sum('amount');
        $totalWithdraw = WalletTransactions::where('wallet_id', $wallet->id)->where('source','withdraw')->sum('amount');
        $todayProfit   = WalletTransactions::where('wallet_id', $wallet->id)->whereDate('created_at', today())->where('source','win')->sum('amount');
        $transactions  = WalletTransactions::where('wallet_id', $wallet->id)->latest()->limit(5)->get();
        return view('pages.funds.wallet', compact('wallet','totalDeposit','totalWithdraw','todayProfit','transactions'));
    }

    public function depositFunds()
    {
        // Show deposit mode selector (manual + auto)
        return view('pages.funds.deposit');
    }

    public function depositFundsManual()
    {
        // Admin UPI/bank details from settings (fallback to env)
        $upiId   = config('app.admin_upi', '9999999999@upi');
        $qrImage = config('app.admin_qr', null);
        return view('pages.funds.add_funds_manual', compact('upiId','qrImage'));
    }

    public function depositFundsManualStore(Request $request)
    {
        $request->validate([
            'amount'         => 'required|numeric|min:100',
            'transaction_id' => 'nullable|string|max:100',
            'screenshot'     => 'nullable|image|max:4096',
        ]);
        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('deposit_proofs','public');
        }
        DepositRequest::create([
            'user_id'        => Auth::id(),
            'amount'         => $request->amount,
            'payment_mode'   => 'manual',
            'transaction_id' => $request->transaction_id,
            'screenshot'     => $screenshotPath,
            'status'         => 'pending',
        ]);
        return response()->json(['status' => true, 'message' => 'Deposit request submitted. Admin will approve shortly.']);
    }

    public function depositFundsAuto()
    {
        return view('pages.funds.add_funds_auto');
    }

    public function depositFundsStore(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:100']);
        DepositRequest::create([
            'user_id'      => Auth::id(),
            'amount'       => $request->amount,
            'payment_mode' => $request->method ?? 'upi',
            'status'       => 'pending',
        ]);
        return response()->json(['status' => true]);
    }

    public function withdrawFunds()
    {
        $wallet = Auth::user()->wallet;
        return view('pages.funds.withdraw', compact('wallet'));
    }

    public function withdrawFundsStore(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:500',
            'upi_id' => 'required|string|max:100',
        ]);
        $user   = Auth::user();
        $wallet = $user->wallet;
        DB::transaction(function () use ($request, $user, $wallet) {
            $wallet->lockForUpdate()->first();
            if ($wallet->balance < $request->amount) throw new Exception('Insufficient balance');
            $wallet->decrement('balance', $request->amount);
            $wallet->increment('frozen_balance', $request->amount);
            WithdrawRequest::create([
                'user_id' => $user->id,
                'amount'  => $request->amount,
                'upi_id'  => $request->upi_id,
                'status'  => 'pending',
            ]);
        });
        return response()->json(['status' => true, 'message' => 'Withdrawal request submitted.']);
    }

    public function depositHistory()
    {
        $deposits = DepositRequest::where('user_id', Auth::id())
            ->orderBy('created_at','desc')
            ->paginate(20);
        return view('pages.funds.deposit_history', compact('deposits'));
    }

    public function withdrawHistory()
    {
        $withdrawals = WithdrawRequest::where('user_id', Auth::id())
            ->orderBy('created_at','desc')
            ->paginate(20);
        return view('pages.funds.withdraw_history', compact('withdrawals'));
    }

    public function allFunds()
    {
        return view('pages.funds.all-funds');
    }
    public function addBank()
    {
        return view('pages.funds.add_bank_details');
    }
}
