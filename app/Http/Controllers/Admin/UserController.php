<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\DepositRequest;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransactions;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('wallet')->orderBy('created_at', 'desc')->get();
        $users->each(function ($u) {
            $u->balance = $u->wallet ? $u->wallet->balance : 0;
        });
        return view('admin.user_management', compact('users'));
    }

    public function view($id)
    {
        $user    = User::with('wallet')->findOrFail($id);
        $user->balance = $user->wallet ? $user->wallet->balance : 0;

        $recentBids   = Bid::with('market', 'gameType')
            ->where('user_id', $id)->orderBy('created_at', 'desc')->limit(30)->get();
        $deposits     = DepositRequest::where('user_id', $id)->orderBy('created_at', 'desc')->limit(20)->get();
        $withdraws    = WithdrawRequest::where('user_id', $id)->orderBy('created_at', 'desc')->limit(20)->get();
        $transactions = WalletTransactions::where('wallet_id', optional($user->wallet)->id)
            ->orderBy('created_at', 'desc')->limit(50)->get();
        $bonusTransaction = WalletTransactions::where('wallet_id', optional($user->wallet)->id)
    ->whereIn('source', ['admin_credit','admin_debit'])
    ->orderBy('created_at', 'desc')
    ->limit(50)
    ->get();

        $totalBid = Bid::where('user_id', $id)->sum('amount');
        $totalWin = Bid::where('user_id', $id)->where('status', 'won')->sum('winning_amount');

       

        return view('admin.user_view',
            compact('user','recentBids','deposits','withdraws','transactions','totalBid','totalWin','bonusTransaction'));
    }

    public function toggleBetting($id)
    {
        $user = User::findOrFail($id);
        $user->update(['betting' => $user->betting ? 0 : 1]);
        return response()->json(['status' => true, 'betting' => $user->betting]);
    }

    public function toggleTransfer($id)
    {
        $user = User::findOrFail($id);
        $user->update(['transfer' => $user->transfer ? 0 : 1]);
        return response()->json(['status' => true, 'transfer' => $user->transfer]);
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => $user->status ? 0 : 1]);
        return response()->json(['status' => true, 'active' => $user->status]);
    }

    public function addBalance(Request $request, $id)
    {
        $request->validate(['amount' => 'required|numeric|min:1', 'note' => 'nullable|string|max:255']);
        DB::transaction(function () use ($request, $id) {
            $wallet = Wallet::where('user_id', $id)->lockForUpdate()->firstOrFail();
            $wallet->increment('bonus_balance', $request->amount);
            WalletTransactions::create([
                'wallet_id'    => $wallet->id,
                'type'         => 'credit',
                'source'       => 'admin_credit',
                'amount'       => $request->amount,
                'reason'       => $request->note ?? 'Bonus added by admin',
                'balance_after'=> $wallet->fresh()->balance+$request->amount,
            ]);
        });

         sendNotification(
            $id,
            'Bonus Added',
             'An amount of '.$request->amount.' has been added to your bonus balance by admin.',
            'bonus'
        );
        return response()->json(['status' => true, 'message' => 'Balance added successfully']);
    }

    public function deductBalance(Request $request, $id)
    {
        $request->validate(['amount' => 'required|numeric|min:1', 'note' => 'nullable|string|max:255']);
        DB::transaction(function () use ($request, $id) {
            $wallet = Wallet::where('user_id', $id)->lockForUpdate()->firstOrFail();
            if ($wallet->balance < $request->amount) {
                throw new \Exception('Insufficient balance');
            }
            $wallet->decrement('balance', $request->amount);
            WalletTransactions::create([
                'wallet_id'    => $wallet->id,
                'type'         => 'debit',
                'source'       => 'admin_debit',
                'amount'       => $request->amount,
                'reason'       => $request->note ?? 'Balance deducted by admin',
                'balance_after'=> $wallet->fresh()->balance,
            ]);
        });
        return response()->json(['status' => true, 'message' => 'Balance deducted successfully']);
    }
}
