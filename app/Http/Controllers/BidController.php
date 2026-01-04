<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\GameType;
use App\Models\WalletTransactions;
use App\Services\AnkCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'walletTransaction:id,wallet_id,type,amount,balance_after,created_at',
        ])->where('user_id', $user->id);

        // ✅ Filters
        if ($request->filled('market')) {
            $query->whereHas('market', fn ($q) => $q->where('name', 'like', "%{$request->market}%"));
        }

        if ($request->filled('game_type')) {
            $query->whereHas('gameType', fn ($q) => $q->where('name', 'like', "%{$request->game_type}%"));
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


        $gameType = GameType::findOrFail($request->game_type_id);
    $gameTypeSlug = $gameType->slug;

        DB::transaction(function () use ($request, $user, $totalPoints, $gameTypeSlug) {
            if ($user->wallet->balance < $totalPoints) {
                throw new \Exception('Insufficient wallet balance');
            }

            foreach ($request->bids as $bid) {
                $ank = AnkCalculator::calculate(
                    $gameTypeSlug,
                    $bid['digits'],
                    $bid['session']
                );


                if ($gameTypeSlug === 'single_digit' || $gameTypeSlug === 'single_digit_bulk') {

                    $bid_data = ['digit' => (int) $bid['digits']];

                } elseif ($gameTypeSlug === 'jodi' || $gameTypeSlug === 'jodi_bulk') {
                    $bid_data = ['digit' => $bid['digits']];

                } elseif (in_array($gameTypeSlug, [
                    'single_panna', 'double_panna', 'triple_panna',
                    'single_panna_bulk', 'double_panna_bulk', 'triple_panna_bulk',
                ])) {

                    $bid_data = ['panna' => $bid['digits']];

                } elseif ($gameTypeSlug === 'half_sangam') {

                    [$panna, $digit] = explode('-', $bid['digits']);

                    if($bid['session'] === 'open'){
                        $bid_data = [
                            'open_panna' => $panna,
                            'close_digit' => (int) $digit,
                        ];
                    } else {
                        $bid_data = [
                            'open_digit' => (int) $digit,
                            'close_panna' => $panna,
                        ];
                    }

                } elseif ($gameTypeSlug === 'full_sangam') {

                    [$open_panna, $close_panna] = explode('-', $bid['digits']);

                    $bid_data = [
                        'open_panna' => $open_panna,
                        'close_panna' => $close_panna,
                    ];

                } else {
                    throw new \Exception('Unsupported game type');
                }

                $newBid = Bid::create([
                    'user_id' => $user->id,
                    'market_id' => $request->market_id,
                    'market_type' => $request->game_type,
                    'game_type_id' => $request->game_type_id,
                    'number' => $bid['digits'],
                    'bet_data' => json_encode($bid_data),
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
                    'reason' => 'Bid placed on '.ucfirst($request->game_type),
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
            'message' => 'Bid placed successfully',
        ]);
    }
}
