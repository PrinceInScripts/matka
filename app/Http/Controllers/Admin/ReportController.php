<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\DepositRequest;
use App\Models\GameList;
use App\Models\GameType;
use App\Models\PointTransfer;
use App\Models\Referral;
use App\Models\WalletTransactions;
use App\Models\WithdrawRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ReportController extends Controller
{
    public function user_bid_history()
    {
        $userBids = Bid::with('user','market','gameType')->orderBy('created_at','desc')->limit(300)->get();
        $games    = GameList::where('game_status',1)->where('market_type','main')->get();
        $gameType = GameType::all();
        return view('admin.reports.user_bid', compact('userBids','games','gameType'));
    }

    public function filter_user_bid_history(Request $request)
    {
        $query = Bid::with(['user','market','gameType']);
        if ($request->filled('date'))         $query->whereDate('draw_date', $request->date);
        if ($request->filled('game_id'))      $query->where('market_id', $request->game_id);
        if ($request->filled('game_type_id')) $query->where('game_type_id', $request->game_type_id);
        if ($request->filled('session'))      $query->where('session', $request->session);
        if ($request->filled('status'))       $query->where('status', $request->status);
        $bids = $query->orderBy('created_at','desc')->get();
        return response()->json([
            'status' => true,
            'data'   => $bids,
            'totals' => [
                'total_amount' => $bids->sum('amount'),
                'total_win'    => $bids->where('status','won')->sum('winning_amount'),
                'total_bids'   => $bids->count(),
            ],
        ]);
    }

    public function customer_sell()
    {
        $games    = GameList::where('game_status',1)->where('market_type','main')->get();
        $gameType = GameType::all();
        return view('admin.reports.customer_sell', compact('games','gameType'));
    }

    public function customer_sell_filter(Request $request)
    {
        $request->validate(['date' => 'required|date']);
        $query = Bid::with(['user','gameType'])->whereDate('draw_date', $request->date);
        if ($request->filled('game_id')) $query->where('market_id', $request->game_id);
        $bids = $query->get();
        $grouped = $bids->groupBy(fn($b) => optional($b->gameType)->name ?? 'Unknown')->map(fn($g) => [
            'game_type'    => optional($g->first()->gameType)->name ?? '-',
            'total_bids'   => $g->count(),
            'total_amount' => $g->sum('amount'),
            'total_win'    => $g->where('status','won')->sum('winning_amount'),
        ])->values();
        return response()->json([
            'status' => true, 'data' => $grouped,
            'total_amount' => $bids->sum('amount'),
            'total_win'    => $bids->where('status','won')->sum('winning_amount'),
        ]);
    }

    public function winning()
    {
        $games    = GameList::where('game_status',1)->where('market_type','main')->get();
        $gameType = GameType::all();
        return view('admin.reports.winning', compact('games','gameType'));
    }

    public function winning_filter(Request $request)
    {
        $request->validate(['date' => 'required|date']);
        $query = Bid::with(['user','market','gameType'])->where('status','won')->whereDate('draw_date', $request->date);
        if ($request->filled('game_id')) $query->where('market_id', $request->game_id);
        $bids = $query->orderBy('winning_amount','desc')->get();
        return response()->json(['status' => true, 'data' => $bids, 'total_win' => $bids->sum('winning_amount')]);
    }

    public function transfer_point()
    {
        // Gracefully handle missing table
        if (!Schema::hasTable('point_transfers')) {
            $transfers = collect();
            $totalTransfers = $monthTransfers = $totalAmount = 0;
        } else {
            $transfers      = PointTransfer::with('sender','receiver')->orderBy('created_at','desc')->get();
            $totalTransfers = $transfers->count();
            $totalAmount    = $transfers->sum('amount');
            $monthTransfers = $transfers->where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        }
        return view('admin.reports.transfer_point', compact('transfers','totalTransfers','totalAmount','monthTransfers'));
    }

    public function bid_win()
    {
        $games    = GameList::where('game_status',1)->where('market_type','main')->get();
        $gameType = GameType::all();
        return view('admin.reports.bid_win', compact('games','gameType'));
    }

    public function referral()
    {
        if (!Schema::hasTable('referrals')) {
            $referrals = collect();
            $totalReferrals = $paidReferrals = $pendingReferrals = $totalBonus = 0;
        } else {
            $referrals       = Referral::with('referrer','referred')->orderBy('created_at','desc')->get();
            $totalReferrals  = $referrals->count();
            $paidReferrals   = $referrals->where('status','paid')->count();
            $pendingReferrals= $referrals->where('status','pending')->count();
            $totalBonus      = $referrals->where('status','paid')->sum('referrer_bonus');
        }
        return view('admin.reports.referral', compact('referrals','totalReferrals','paidReferrals','pendingReferrals','totalBonus'));
    }

    public function payReferral(Request $request)
    {
        $request->validate(['id' => 'required|exists:referrals,id']);
        $referral = Referral::findOrFail($request->id);
        if ($referral->status !== 'pending') {
            return response()->json(['status' => false, 'message' => 'Already processed']);
        }
        $referral->update(['status' => 'paid', 'paid_at' => now()]);
        return response()->json(['status' => true, 'message' => 'Bonus marked as paid']);
    }

    public function withdraw()
    {
        $withdraws     = WithdrawRequest::with('user')->orderBy('created_at','desc')->get();
        $pendingTotal  = $withdraws->where('status','pending')->sum('amount');
        $approvedTotal = $withdraws->where('status','approved')->sum('amount');
        return view('admin.reports.withdraw', compact('withdraws','pendingTotal','approvedTotal'));
    }

    public function deposit()
    {
        $deposits      = DepositRequest::with('user')->orderBy('created_at','desc')->get();
        $pendingTotal  = $deposits->where('status','pending')->sum('amount');
        $approvedTotal = $deposits->where('status','approved')->sum('amount');
        return view('admin.reports.deposit', compact('deposits','pendingTotal','approvedTotal'));
    }
}
