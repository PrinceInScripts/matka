<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\DepositRequest;
use App\Models\GameList;
use App\Models\GameType;
use App\Models\WalletTransactions;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function user_bid_history()
    {
       
        $userBids=Bid::with('user','market')->orderBy('created_at','desc')->get();

        $games = GameList::where('game_status', 1)
    ->with(['todaySchedule'])
    ->whereHas('todaySchedule')
    ->get();


       $gameType=GameType::all();

        return view('admin.reports.user_bid', compact('userBids', 'games', 'gameType'));
    }

   public function filter_user_bid_history(Request $request)
{
    $query = Bid::with(['user', 'market', 'gameType']);

    if ($request->date) {
        $query->whereDate('created_at', $request->date);
    }

    if ($request->game_id) {
        $query->where('market_id', $request->game_id);
    }

    if ($request->game_type_id) {
        $query->where('game_type_id', $request->game_type_id);
    }

    $bids = $query->orderBy('created_at', 'desc')->get();

    return response()->json([
        'status' => true,
        'data' => $bids
    ]);
}


    public function customer_sell_report()
    {
        return view('admin.reports.customer_sell');
    }

    public function winning()
    {
        return view('admin.reports.winning');
    }

    public function transfer_point()
    {
        return view('admin.reports.transfer_point');
    }

    public function bid_win()
    {
        return view('admin.reports.bid_win');
    }

    public function withdraw()
    {
        $withdraws=WithdrawRequest::with('user')->orderBy('created_at','desc')->get();
        return view('admin.reports.withdraw', compact('withdraws'));
    }

    public function referral()
    {
        return view('admin.reports.referral');
    }

    public function deposit()
    {
        $deposits=DepositRequest::with('user')->orderBy('created_at','desc')->get();
        return view('admin.reports.deposit', compact('deposits'));
    }
}
