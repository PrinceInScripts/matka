<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\WalletTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\AnkCalculator;

class BidController extends Controller
{
    public function allBids()
    {
        return view('pages.bids.all-bids');
    }


public function myBids(Request $request)
{
    $user = Auth::user();

    $query = Bid::with([
        'market:id,name',
        'gameType:id,name',
        'walletTransaction:id,wallet_id,type,amount,balance_after,created_at'
    ])->where('user_id', $user->id);

    // ✅ Filters
    if ($request->filled('market')) {
        $query->whereHas('market', fn($q) => $q->where('name', 'like', "%{$request->market}%"));
    }

    if ($request->filled('game_type')) {
        $query->whereHas('gameType', fn($q) => $q->where('name', 'like', "%{$request->game_type}%"));
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // ✅ Paginate Eloquent models (not arrays)
    $bids = $query->orderBy('id', 'desc')->paginate(10);

    if ($request->ajax()) {
        return response()->json([
            'html' => view('pages.bids.partials.bid-list', compact('bids'))->render(),
        ]);
    }

    return view('pages.bids.my-bids', compact('bids'));
}



    public function requestFund()
    {
        return view('pages.bids.fund-request');
    }

    public function approvedCredit()
    {
        return view('pages.bids.approved-credit');
    }

    public function approvedDebit()
    {
        return view('pages.bids.approved-debit');
    }


    public function placeBid(Request $request)
    {

        // return $request;
        $request->validate([
        'market_id' => 'required|integer',
        'market_type' => 'required|string',
        'game_id' => 'required|integer',
        'game_type_id' => 'required|integer',
        'bids' => 'required|array|min:1',
        'bids.*.digits' => 'required|string',
        'bids.*.points' => 'required|integer|min:1',
        'bids.*.session' => 'required|string',
        'date' => 'required|date',
        'game_type' => 'required|string',
    ]);

    $user = Auth::user();
    $totalPoints = collect($request->bids)->sum('points');

    DB::transaction(function () use ($request, $user, $totalPoints) {
        if ($user->wallet->balance < $totalPoints) {
            throw new \Exception("Insufficient wallet balance");
        }

        foreach ($request->bids as $bid) {
            $ank = AnkCalculator::calculate(
                $request->game_type_id,
                $bid['digits'],
                $bid['session']
            );

             $newBid = Bid::create([
                'user_id' => $user->id,
                'market_id' => $request->market_id,
                'market_type' => $request->game_type,
                'game_type_id' => $request->game_type_id,
                'number' => $bid['digits'],
                'ank' => $ank,
                'amount' => $bid['points'],
                'session' => $bid['session'],
                'draw_date' => $request->date,
                'status' => 'pending',
            ]);

            $walletTx = WalletTransactions::create([
                'wallet_id' => $user->wallet->id,
                'type' => 'debit',
                'source' => 'bid',
                'amount' => $bid['points'],
                'reason' => 'Bid placed on ' . ucfirst($request->game_type),
                'reference_id' => $newBid->id,
                'balance_after' => $user->wallet->balance - $bid['points'],
            ]);

            // ✅ Link wallet transaction to bid
            $newBid->update(['wallet_transaction_id' => $walletTx->id]);

            // ✅ Decrease wallet balance step-by-step
            $user->wallet->decrement('balance', $bid['points']);
        }

       
    });

     return response()->json([
        'status' => true,
        'message' => 'Bid placed successfully'
    ]);
    }
}
