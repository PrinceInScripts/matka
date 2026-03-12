<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DepositRequest;
use App\Models\Wallet;
use App\Models\WalletTransactions;
use App\Models\WithdrawRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /* ─── FUND / DEPOSIT REQUESTS ─── */

    public function fund_request()
    {
        $deposits      = DepositRequest::with('user')->orderBy('created_at', 'desc')->get();
        $pendingCount  = $deposits->where('status', 'pending')->count();
        $approvedCount = $deposits->where('status', 'approved')->count();
        $rejectedCount = $deposits->where('status', 'rejected')->count();
        $pendingAmount = $deposits->where('status', 'pending')->sum('amount');
        return view('admin.wallet.fund_request',
            compact('deposits', 'pendingCount', 'approvedCount', 'rejectedCount', 'pendingAmount'));
    }

    public function approveDeposit(Request $request, $id)
    {
        DB::transaction(function () use ($id) {
            $deposit = DepositRequest::where('id', $id)
                ->where('status', 'pending')->lockForUpdate()->firstOrFail();
            $wallet = Wallet::where('user_id', $deposit->user_id)->lockForUpdate()->firstOrFail();
            $wallet->increment('balance', $deposit->amount);
            $deposit->update(['status' => 'approved', 'admin_id' => auth('admin')->id()]);
            WalletTransactions::create([
                'wallet_id'    => $wallet->id,
                'type'         => 'credit',
                'source'       => 'deposit',
                'amount'       => $deposit->amount,
                'reason'       => 'Deposit approved by admin',
                'reference_id' => $deposit->id,
                'balance_after'=> $wallet->fresh()->balance,
            ]);
        });
        return response()->json(['status' => true, 'message' => 'Deposit approved successfully']);
    }

    public function rejectDeposit(Request $request, $id)
    {
        $deposit = DepositRequest::where('id', $id)->where('status', 'pending')->firstOrFail();
        $deposit->update([
            'status'     => 'rejected',
            'admin_id'   => auth('admin')->id(),
            'admin_note' => $request->note ?? 'Rejected by admin',
        ]);
        return response()->json(['status' => true, 'message' => 'Deposit rejected']);
    }

    /* ─── WITHDRAW REQUESTS ─── */

    public function withdraw_request()
    {
        $withdraws     = WithdrawRequest::with('user')->orderBy('created_at', 'desc')->get();
        $pendingCount  = $withdraws->where('status', 'pending')->count();
        $approvedCount = $withdraws->where('status', 'approved')->count();
        $rejectedCount = $withdraws->where('status', 'rejected')->count();
        $pendingAmount = $withdraws->where('status', 'pending')->sum('amount');
        return view('admin.wallet.withdraw_request',
            compact('withdraws', 'pendingCount', 'approvedCount', 'rejectedCount', 'pendingAmount'));
    }

    public function approveWithdraw(Request $request, $id)
    {
        DB::transaction(function () use ($id) {
            $withdraw = WithdrawRequest::where('id', $id)
                ->where('status', 'pending')->lockForUpdate()->firstOrFail();
            $wallet = Wallet::where('user_id', $withdraw->user_id)->lockForUpdate()->firstOrFail();
            // Release frozen balance (was frozen when user submitted request)
            if ($wallet->frozen_balance >= $withdraw->amount) {
                $wallet->decrement('frozen_balance', $withdraw->amount);
            }
            $withdraw->update(['status' => 'approved', 'admin_id' => auth('admin')->id()]);
            WalletTransactions::create([
                'wallet_id'    => $wallet->id,
                'type'         => 'debit',
                'source'       => 'withdraw',
                'amount'       => $withdraw->amount,
                'reason'       => 'Withdrawal approved by admin',
                'reference_id' => $withdraw->id,
                'balance_after'=> $wallet->fresh()->balance,
            ]);
        });
        return response()->json(['status' => true, 'message' => 'Withdrawal approved']);
    }

    public function rejectWithdraw(Request $request, $id)
    {
        DB::transaction(function () use ($id, $request) {
            $withdraw = WithdrawRequest::where('id', $id)
                ->where('status', 'pending')->lockForUpdate()->firstOrFail();
            $wallet = Wallet::where('user_id', $withdraw->user_id)->lockForUpdate()->firstOrFail();
            // Restore frozen balance back to available balance
            if ($wallet->frozen_balance >= $withdraw->amount) {
                $wallet->decrement('frozen_balance', $withdraw->amount);
                $wallet->increment('balance', $withdraw->amount);
            }
            $withdraw->update([
                'status'     => 'rejected',
                'admin_id'   => auth('admin')->id(),
                'admin_note' => $request->note ?? 'Rejected by admin',
            ]);
        });
        return response()->json(['status' => true, 'message' => 'Withdrawal rejected, balance restored']);
    }

    /* ─── ADD FUND (admin manually credits user) ─── */

    public function add_fund()
    {
        $users = User::with('wallet')->orderBy('name')->get();
        return view('admin.wallet.add_fund', compact('users'));
    }

    public function addFundStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount'  => 'required|numeric|min:1|max:500000',
            'note'    => 'nullable|string|max:255',
        ]);
        DB::transaction(function () use ($request) {
            $wallet = Wallet::where('user_id', $request->user_id)->lockForUpdate()->firstOrFail();
            $wallet->increment('balance', $request->amount);
            WalletTransactions::create([
                'wallet_id'    => $wallet->id,
                'type'         => 'credit',
                'source'       => 'admin_add',
                'amount'       => $request->amount,
                'reason'       => $request->note ?? 'Fund added by admin',
                'balance_after'=> $wallet->fresh()->balance,
            ]);
        });
        return response()->json(['status' => true, 'message' => 'Fund added successfully']);
    }

    /* ─── BID / TRANSACTION REPORT ─── */

    public function bid_report()
    {
        $transactions = WalletTransactions::with('wallet.user')
            ->orderBy('created_at', 'desc')->limit(500)->get();
        $totalDebit   = $transactions->where('type', 'debit')->sum('amount');
        $totalCredit  = $transactions->where('type', 'credit')->sum('amount');
        return view('admin.wallet.bid_report', compact('transactions', 'totalDebit', 'totalCredit'));
    }

    public function bidReportFilter(Request $request)
    {
        $query = WalletTransactions::with('wallet.user');
        if ($request->filled('date'))   $query->whereDate('created_at', $request->date);
        if ($request->filled('type'))   $query->where('type', $request->type);
        if ($request->filled('source')) $query->where('source', $request->source);
        $txns = $query->orderBy('created_at', 'desc')->get();
        return response()->json([
            'status' => true,
            'data'   => $txns,
            'totals' => [
                'total_debit'  => $txns->where('type','debit')->sum('amount'),
                'total_credit' => $txns->where('type','credit')->sum('amount'),
            ],
        ]);
    }
}
