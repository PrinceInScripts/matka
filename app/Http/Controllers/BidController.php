<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\GaliDisawarBid;
use App\Models\GaliDisawarGameType;
use App\Models\GaliDisawarType;
use App\Models\GameType;
use App\Models\StarlineBidHistory;
use App\Models\StarlineGamesType;
use App\Models\WalletTransactions;
use App\Services\AnkCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BidController extends Controller
{
    public function allBids()
    {
        return view('pages.bids.all-bids');
    }

    // public function myBids(Request $request)
    // {
    //     $user = Auth::user();

    //     $query = Bid::with([
    //         'market:id,name',
    //         'gameType:id,name',
    //         'walletTransaction:id,wallet_id,type,amount,balance_after,created_at',
    //     ])->where('user_id', $user->id);

    //     if ($request->filled('market')) {
    //         $query->whereHas('market', fn ($q) => $q->where('name', 'like', "%{$request->market}%"));
    //     }

    //     if ($request->filled('game_type')) {
    //         $query->whereHas('gameType', fn ($q) => $q->where('name', 'like', "%{$request->game_type}%"));
    //     }

    //     if ($request->filled('status')) {
    //         $query->where('status', $request->status);
    //     }

    //     $bids = $query->orderBy('id', 'desc')->paginate(10);

    //     if ($request->ajax()) {
    //         return response()->json([
    //             'html' => view('pages.bids.partials.bid-list', compact('bids'))->render(),
    //         ]);
    //     }

    //     return view('pages.bids.my-bids', compact('bids'));
    // }

    public function myBids(Request $request)
{
    $user = Auth::user();

    $query = Bid::with([
        'market:id,name',
        'gameType:id,name',
        'walletTransaction:id,wallet_id,type,amount,balance_after,created_at',
    ])
    ->where('user_id', $user->id);


    /* -----------------------------
       MARKET TYPE FILTER
    -----------------------------*/

    if ($request->filled('market')) {

        if ($request->market === 'main_market') {
            $query->where('market_type', 'main');
        }

        if ($request->market === 'starline') {
            $query->where('market_type', 'starline');
        }

        if ($request->market === 'gali_disawar') {
            $query->where('market_type', 'gali_disawar');
        }
    }


    /* -----------------------------
       STATUS FILTER
    -----------------------------*/

    if ($request->filled('status')) {
        $query->where('status', strtolower($request->status));
    }


    /* -----------------------------
       DATE RANGE FILTER
    -----------------------------*/

    if ($request->range === 'today') {
        $query->whereDate('created_at', today());
    }

    if ($request->range === 'week') {
        $query->where('created_at', '>=', now()->subDays(7));
    }

    if ($request->range === 'month') {
        $query->where('created_at', '>=', now()->subMonth());
    }

    if ($request->range === 'custom') {

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
    }


    /* -----------------------------
       PAGINATION
    -----------------------------*/

    $bids = $query
        ->orderBy('id', 'desc')
        ->paginate(10);


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

    private function validateBidShape(string $slug, array $data): bool
    {

        return match ($slug) {
            'single_digit', 'single_bulk_digit' => isset($data['digit']) && is_numeric($data['digit']) && $data['digit'] >= 0 && $data['digit'] <= 9,

            'jodi', 'jodi_bulk' => isset($data['digit']) && preg_match('/^\d{2}$/', $data['digit']),

            'single_panna', 'double_panna', 'triple_panna' => isset($data['panna']) && preg_match('/^\d{3}$/', $data['panna']),

            'half_sangam' => isset($data['panna'], $data['digit'])
                   && preg_match('/^\d{3}$/', $data['panna'])
                   && is_numeric($data['digit']),

            'full_sangam' => isset($data['open_panna'], $data['close_panna'])
                   && preg_match('/^\d{3}$/', $data['open_panna'])
                   && preg_match('/^\d{3}$/', $data['close_panna']),

            default => false
        };
    }

    // public function placeBid(Request $request)
    // {

    //     // return $request;
    //     $request->validate([
    //         'market_id' => 'required|integer',
    //         'market_type' => 'required|string',
    //         'game_id' => 'required|integer',
    //         'game_type_id' => 'required|integer',
    //         'bids' => 'required|array|min:1',
    //         'bids.*.digits' => 'required|string',
    //         'bids.*.points' => 'required|integer|min:1',
    //         'bids.*.session' => 'required|string',
    //         'date' => 'required|date',
    //         'game_type' => 'required|string',
    //     ]);

    //     $user = Auth::user();
    //     $totalPoints = collect($request->bids)->sum('points');


    //     $gameType = GameType::findOrFail($request->game_type_id);
    // $gameTypeSlug = $gameType->slug;

    //     DB::transaction(function () use ($request, $user, $totalPoints, $gameTypeSlug) {
    //         if ($user->wallet->balance < $totalPoints) {
    //             throw new \Exception('Insufficient wallet balance');
    //         }

    //         foreach ($request->bids as $bid) {
    //             $ank = AnkCalculator::calculate(
    //                 $gameTypeSlug,
    //                 $bid['digits'],
    //                 $bid['session']
    //             );


    //             if ($gameTypeSlug === 'single_digit' || $gameTypeSlug === 'single_digit_bulk') {

    //                 $bid_data = ['digit' => (int) $bid['digits']];

    //             } elseif ($gameTypeSlug === 'jodi' || $gameTypeSlug === 'jodi_bulk') {
    //                 $bid_data = ['digit' => $bid['digits']];

    //             } elseif (in_array($gameTypeSlug, [
    //                 'single_panna', 'double_panna', 'triple_panna',
    //                 'single_panna_bulk', 'double_panna_bulk', 'triple_panna_bulk',
    //             ])) {

    //                 $bid_data = ['panna' => $bid['digits']];

    //             } elseif ($gameTypeSlug === 'half_sangam') {

    //                 [$panna, $digit] = explode('-', $bid['digits']);

    //                 if($bid['session'] === 'open'){
    //                     $bid_data = [
    //                         'open_panna' => $panna,
    //                         'close_digit' => (int) $digit,
    //                     ];
    //                 } else {
    //                     $bid_data = [
    //                         'open_digit' => (int) $digit,
    //                         'close_panna' => $panna,
    //                     ];
    //                 }

    //             } elseif ($gameTypeSlug === 'full_sangam') {

    //                 [$open_panna, $close_panna] = explode('-', $bid['digits']);

    //                 $bid_data = [
    //                     'open_panna' => $open_panna,
    //                     'close_panna' => $close_panna,
    //                 ];

    //             } else {
    //                 throw new \Exception('Unsupported game type');
    //             }

    //             // crate bid txn id 
    //             $bidTxnId = Str::uuid()->toString();

    //             $newBid = Bid::create([
    //                 'user_id' => $user->id,
    //                 'market_id' => $request->market_id,
    //                 'market_type' => $request->game_type,
    //                 'game_type_id' => $request->game_type_id,
    //                 'number' => $bid['digits'],
    //                 'bet_data' => json_encode($bid_data),
    //                 'ank' => $ank,
    //                 'amount' => $bid['points'],
    //                 'session' => $bid['session'],
    //                 'draw_date' => $request->date,
    //                 'status' => 'pending',
    //                 'txn_id' => $bidTxnId,
    //             ]);

    //             $walletTx = WalletTransactions::create([
    //                 'wallet_id' => $user->wallet->id,
    //                 'type' => 'debit',
    //                 'source' => 'bid',
    //                 'amount' => $bid['points'],
    //                 'reason' => 'Bid placed on '.ucfirst($request->game_type),
    //                 'reference_id' => $newBid->id,
    //                 'balance_after' => $user->wallet->balance - $bid['points'],
    //             ]);

    //             // ✅ Link wallet transaction to bid
    //             $newBid->update(['wallet_transaction_id' => $walletTx->id]);

    //             // ✅ Decrease wallet balance step-by-step
    //             $user->wallet->decrement('balance', $bid['points']);
    //             // Freeze the amount
    //             $user->wallet->increment('frozen_balance', $bid['points']);
                
    //         }

    //     });

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Bid placed successfully',
    //     ]);
    // }

    private function placeGaliDisawarBid(Request $request)
{    
    // return $request;
    $request->validate([
        'market_id'    => 'required|integer|exists:gali_disawar_games,id',
        'game_type_id' => 'required|integer|exists:gali_disawar_types,id',
        'bids'         => 'required|array|min:1',
        'bids.*.digits'=> 'required|string',
        'bids.*.points'=> 'required|integer|min:1',
        'bids.*.session'=> 'required|in:OPEN,CLOSE',
        'date'         => 'required|date',
    ]);

    $user = Auth::user();
    $totalPoints = collect($request->bids)->sum('points');

    $gameType = GaliDisawarGameType::findOrFail($request->game_type_id);
    
   

    // 🔒 Check if game type allowed for this market
    $isAllowed = GaliDisawarGameType::where([
        'gali_id'      => $request->market_id,
        'game_type_id'=> $gameType->id,
        'status'       => 1,
    ])->exists();

    if (!$isAllowed) {
        abort(422, 'Game type not allowed for this market');
    }

    DB::transaction(function () use ($request, $user, $totalPoints, $gameType) {

        if ($user->wallet->balance < $totalPoints) {
            throw new \Exception('Insufficient wallet balance');
        }
         $gameType= GaliDisawarType::findOrFail($gameType->game_type_id);
         $gameTypeSlug = $gameType->slug;


        foreach ($request->bids as $bid) {

            // 🎯 Build bet_data cleanly
            $betData = match ($gameTypeSlug) {
                'single_digit', 'left_digit', 'right_digit'
                    => ['digit' => (int)$bid['digits']],

                'jodi_digit'
                    => ['jodi' => $bid['digits']],

                default
                    => throw new \Exception('Unsupported Gali Disawar game type'),
            };

            $bidTxnId = Str::uuid()->toString();

            $newBid = GaliDisawarBid::create([
                'user_id'   => $user->id,
                'gali_id'   => $request->market_id,
                'game_type_id' => $gameType->id,
                'bet_data'  => json_encode($betData),
                'bet_value' => $bid['digits'],
                'amount'    => $bid['points'],
                'draw_date' => $request->date,
                'bid_date'  => now()->toDateString(),
                'status'    => 'pending',
                'txn_id'    => $bidTxnId,
                'winning_amount'=> $bid['points'] * $gameType->payout_rate,
                'session'   => $bid['session'], //with lowercase session
            ]);

            $user->wallet->decrement('balance', $bid['points']);
            $user->wallet->increment('frozen_balance', $bid['points']);
            $user->wallet->refresh(); // reload from DB


            $walletTx = WalletTransactions::create([
                'wallet_id' => $user->wallet->id,
                'type'      => 'debit',
                'source'    => 'galidisawar_bid',
                'amount'    => $bid['points'],
                'reason'    => 'Gali Disawar Bid',
                'reference_id' => $newBid->id,
                // 'source' => 'galidisawar_bid',
                'balance_after' => $user->wallet->balance,
            ]);

            $newBid->update([
                'wallet_transaction_id' => $walletTx->id
            ]);

           
        }
    });

    sendNotification(
    $user->id,
    "Bet Placed",
    "Your bet has been successfully placed on Gali Disawar",
    "bet"
);

    return response()->json([
        'status'  => true,
        'message' => 'Gali Disawar bid placed successfully',
    ]);
}

private function placeStarlineBid(Request $request)
{
    // return $request;
    $request->validate([
        'market_id'    => 'required|integer|exists:starline_names,id',
        'game_type_id' => 'required|integer|exists:gametypes,id',
        'bids'         => 'required|array|min:1',
        'bids.*.digits'=> 'required|string',
        'bids.*.points'=> 'required|integer|min:1',
        'bids.*.session'=> 'required|in:OPEN,CLOSE',
        'date'         => 'required|date',
    ]);

    $user = Auth::user();
    $totalPoints = collect($request->bids)->sum('points');

    $gameType = StarlineGamesType::findOrFail($request->game_type_id);

    DB::transaction(function () use ($request, $user, $totalPoints, $gameType) {

        if ($user->wallet->balance < $totalPoints) {
            throw new \Exception('Insufficient wallet balance');
        }

        foreach ($request->bids as $bid) {

            $betData = match ($gameType->slug) {
                'single_digit',
                    => ['digit' => (int)$bid['digits']],

                'single_panna', 'double_panna', 'triple_panna'
                    => ['panna' => $bid['digits']],

                default
                    => throw new \Exception('Unsupported Starline game type'),
            };

            $bidTxnId = Str::uuid()->toString();

            $newBid = StarlineBidHistory::create([
                'user_id'   => $user->id,
                'starline_id' => $request->market_id,
                'game_type_id'=> $gameType->id,
                'bet_data'  => json_encode($betData),
                'bet_value' => $bid['digits'],
                'amount'    => $bid['points'],
                'draw_date' => $request->date,
                'bid_date'  => now()->toDateString(),
                'status'    => 'pending',
                'session'   => $bid['session'],
                'txn_id'    => $bidTxnId,
                'winning_amount'=> $bid['points'] * $gameType->payout_rate,
            ]);

             $user->wallet->decrement('balance', $bid['points']);
            $user->wallet->increment('frozen_balance', $bid['points']);
            $user->wallet->refresh(); // reload from DB

            $walletTx = WalletTransactions::create([
                'wallet_id' => $user->wallet->id,
                'type'      => 'debit',
                'source'    => 'starline_bid',
                'amount'    => $bid['points'],
                'reason'    => 'Starline Bid',
                'reference_id' => $newBid->id,
                // 'source' => 'starline_bid',
                'balance_after' => $user->wallet->balance,
            ]);

            $newBid->update(['wallet_transaction_id' => $walletTx->id]);

           
        }
    });

    sendNotification(
    $user->id,
    "Bet Placed",
    "Your bet has been successfully placed on Starline",
    "bet"
);

    return response()->json([
        'status'  => true,
        'message' => 'Starline bid placed successfully',
    ]);
}

private function placeMainMarketBid(Request $request)
{
    $request->validate([
        'market_id'    => 'required|integer|exists:gamelists,id',
        'game_type_id' => 'required|integer|exists:gametypes,id',
        'bids'         => 'required|array|min:1',
        'bids.*.digits'=> 'required|string',
        'bids.*.points'=> 'required|integer|min:1',
        'bids.*.session'=> 'required|in:OPEN,CLOSE',
        'date'         => 'required|date',
    ]);

    $user = Auth::user();
    $totalPoints = collect($request->bids)->sum('points');

    $gameType = GameType::findOrFail($request->game_type_id);

    DB::transaction(function () use ($request, $user, $totalPoints, $gameType) {

        if ($user->wallet->balance < $totalPoints) {
            throw new \Exception('Insufficient wallet balance');
        }

        foreach ($request->bids as $bid) {

            // 🎯 Main market supports complex types
            $betData = match ($gameType->slug) {

                'single_digit','single_bulk_digit'
                    => ['digit' => (int)$bid['digits']],

                'jodi','jodi_bulk'
                    => ['jodi' => $bid['digits']],

                'single_panna','double_panna','triple_panna','single_panna_bulk','double_panna_bulk','triple_panna_bulk'
                    => ['panna' => $bid['digits']],

                'half_sangam' => $bid['session'] === 'open'
                    ? ['open_panna' => explode('-', $bid['digits'])[0],
                       'close_digit'=> explode('-', $bid['digits'])[1]]
                    : ['open_digit' => explode('-', $bid['digits'])[1],
                       'close_panna'=> explode('-', $bid['digits'])[0]],

                'full_sangam'
                    => [
                        'open_panna'  => explode('-', $bid['digits'])[0],
                        'close_panna' => explode('-', $bid['digits'])[1],
                    ],

                default
                    => throw new \Exception('Unsupported Main Market game type'),
            };

            $bidTxnId = Str::uuid()->toString();

            $newBid = Bid::create([
                'user_id'   => $user->id,
                'market_id' => $request->market_id,
                'game_type_id'=> $gameType->id,
                'bet_data'  => json_encode($betData),
                'number'    => $bid['digits'],
                'amount'    => $bid['points'],
                'session'   => $bid['session'],
                'draw_date' => $request->date,
                'status'    => 'pending',
                'txn_id'    => $bidTxnId,
                'ank'       => AnkCalculator::calculate($gameType->slug, $bid['digits'], $bid['session']),
                'winning_amount'=> $bid['points'] * $gameType->payout_rate,
            ]);

             $user->wallet->decrement('balance', $bid['points']);
            $user->wallet->increment('frozen_balance', $bid['points']);
            $user->wallet->refresh(); // reload from DB

            $walletTx = WalletTransactions::create([
                'wallet_id' => $user->wallet->id,
                'type'      => 'debit',
                // 'source'    => 'main_market_bid',
                'amount'    => $bid['points'],
                'reason'    => 'Main Market Bid',
                'reference_id' => $newBid->id,
                'source' => 'main_market_bid',
                'balance_after' => $user->wallet->balance,
            ]);

            $newBid->update(['wallet_transaction_id' => $walletTx->id]);

           
        }
    });

    sendNotification(
    $user->id,
    "Bet Placed",
    "Your bet has been successfully placed on Main Market",
    "bet"
);

    return response()->json([
        'status'  => true,
        'message' => 'Main Market bid placed successfully',
    ]);
}
public function placeBid(Request $request)
{
    $request->validate([
        'game_type' => 'required|in:main_market,starline,gali_disawar',
    ]);

    return match ($request->game_type) {
        'main_market'  => $this->placeMainMarketBid($request),
        'starline'     => $this->placeStarlineBid($request),
        'gali_disawar' => $this->placeGaliDisawarBid($request),
    };
}

    public function starlineBidHistory(Request $request)
    {
        $user = auth()->user();
        $bids = \App\Models\StarlineBidHistory::with(['starline','gameType'])
            ->where('user_id', $user->id)
            ->orderBy('created_at','desc')
            ->paginate(15);
        if ($request->ajax()) {
            return response()->json(['html' => view('pages.bids.partials.starline-bid-list', compact('bids'))->render()]);
        }
        return view('pages.bids.starline-bid-history', compact('bids'));
    }

    public function starlineWinHistory(Request $request)
    {
        $user = auth()->user();
        $bids = \App\Models\StarlineBidHistory::with(['starline','gameType'])
            ->where('user_id', $user->id)
            ->where('status','won')
            ->orderBy('created_at','desc')
            ->paginate(15);
        if ($request->ajax()) {
            return response()->json(['html' => view('pages.bids.partials.starline-bid-list', compact('bids'))->render()]);
        }
        return view('pages.bids.starline-win-history', compact('bids'));
    }
    public function galidisawarBidHistory(Request $request)
    {
        $user = Auth::user();
        $bids = \App\Models\GalidisawarBid::with(['gali','gameType'])
            ->where('user_id', $user->id)
            ->orderBy('created_at','desc')
            ->paginate(15);
        if ($request->ajax()) {
            return response()->json(['html' => view('pages.bids.partials.galidisawar-bid-list', compact('bids'))->render()]);
        }
        return view('pages.bids.galidisawar-bid-history', compact('bids'));
    }

    public function galidisawarWinHistory(Request $request)
    {
        $user = Auth::user();
        $bids = \App\Models\GalidisawarBid::with(['gali','gameType'])
            ->where('user_id', $user->id)
            ->where('status','won')
            ->orderBy('created_at','desc')
            ->paginate(15);
        if ($request->ajax()) {
            return response()->json(['html' => view('pages.bids.partials.galidisawar-win-list', compact('bids'))->render()]);
        }
        return view('pages.bids.galidisawar-win-history', compact('bids'));
    }

}