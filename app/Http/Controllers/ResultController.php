<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Result;
use App\Models\Wallet;
use App\Models\WalletTransactions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller {
    public function getContext( Request $request ) {

        return Result::where( [
            'market_id' => $request->game_id,
            // 'session' => $request->session,
            'result_date' => $request->result_date,
        ] )->first();
    }

    public function saveDraft( Request $request ) {
        Result::updateOrCreate(
            [
                'market_id' => $request->market_id,
                //   'session' => $request->session,
                'result_date' => $request->result_date,
            ],
            [
                'open_panna' => $request->open_panna,
                'open_digit' => $request->open_digit,
                'close_panna' => $request->close_panna,
                'close_digit' => $request->close_digit,
                'status' => 'draft',
            ]
        );

        // return result id so we can store it for show winner
        return Result::where( [
            'market_id' => $request->market_id,
            // 'session' => $request->session,
            'result_date' => $request->result_date,
        ] )->first();
    }
public function declareWinners(Request $request)
{
    $request->validate([
        'result_id' => 'required|exists:results,id',
    ]);

    $result = Result::findOrFail($request->result_id);

    DB::transaction(function () use ($result) {

        if ($result->status === 'declared') {
            throw new \Exception('Result already declared');
        }

        // 🔍 Decide what is declared
        $isOpenDeclared =
            !is_null($result->open_digit) &&
            !is_null($result->open_panna);

        $isCloseDeclared =
            !is_null($result->close_digit) &&
            !is_null($result->close_panna);

        if (!$isOpenDeclared && !$isCloseDeclared) {
            throw new \Exception('No result declared yet');
        }

        // 🎯 Winning values
        $winningDigit = $isOpenDeclared
            ? (int) $result->open_digit
            : (int) $result->close_digit;

        $winningPanna = $isOpenDeclared
            ? $result->open_panna
            : $result->close_panna;

        $jodi = $isCloseDeclared
            ? $result->open_digit . $result->close_digit
            : null;

        // 📥 Fetch all pending bids
        $bids = Bid::with(['user.wallet', 'gameType'])
            ->where('market_id', $result->market_id)
            ->whereDate('draw_date', $result->result_date)
            ->where('status', 'pending')
            ->get();

        foreach ($bids as $bid) {

            $betData  = json_decode($bid->bet_data, true) ?? [];
            $wallet   = $bid->user->wallet;
            $isWinner = false;

            // 🧠 MATCH LOGIC (EXACTLY SAME AS winners())
            switch ($bid->gameType->slug) {

                case 'single_digit':
                case 'single_digit_bulk':
                    $isWinner =
                        isset($betData['digit']) &&
                        (int) $betData['digit'] === $winningDigit;
                    break;

                case 'jodi':
                case 'jodi_bulk':
                    if ($jodi) {
                        $isWinner =
                            isset($betData['digit']) &&
                            $betData['digit'] === $jodi;
                    }
                    break;

                case 'single_panna':
                case 'single_panna_bulk':
                case 'double_panna':
                case 'double_panna_bulk':
                case 'triple_panna':
                case 'triple_panna_bulk':
                    $isWinner =
                        isset($betData['panna']) &&
                        $betData['panna'] === $winningPanna;
                    break;

                case 'half_sangam':
                    if ($bid->session === 'open' && $isOpenDeclared) {
                        $isWinner =
                            isset($betData['panna'], $betData['digit']) &&
                            $betData['panna'] === $result->open_panna &&
                            (int) $betData['digit'] === (int) $result->open_digit;
                    }

                    if ($bid->session === 'close' && $isCloseDeclared) {
                        $isWinner =
                            isset($betData['panna'], $betData['digit']) &&
                            $betData['panna'] === $result->close_panna &&
                            (int) $betData['digit'] === (int) $result->close_digit;
                    }
                    break;

                case 'full_sangam':
                    if ($isCloseDeclared) {
                        $isWinner =
                            isset($betData['open_panna'], $betData['close_panna']) &&
                            $betData['open_panna'] === $result->open_panna &&
                            $betData['close_panna'] === $result->close_panna;
                    }
                    break;
            }

            // 🔓 ALWAYS release frozen balance for this bid
            $wallet->decrement('frozen_balance', $bid->amount);

            if ($isWinner) {

                $winningAmount = $bid->amount * $bid->gameType->payout_rate;

                $bid->update([
                    'status'         => 'won',
                    'result_id'      => $result->id,
                    'winning_amount' => $winningAmount,
                ]);

                // 💰 Credit win
                WalletTransactions::create([
                    'wallet_id'        => $wallet->id,
                    'amount'           => $winningAmount,
                    'type'             => 'credit',
                    'source'           => 'win',
                    'reason'           => 'Winning amount credited',
                    'reference_id'     => $bid->id,
                    'balance_after'    => $wallet->balance + $winningAmount,
                    'transaction_code' => 'WIN-' . strtoupper(uniqid()),
                ]);

                $wallet->increment('balance', $winningAmount);

            } else {

                // ❌ LOST BID
                $bid->update([
                    'status'         => 'lost',
                    'result_id'      => $result->id,
                    'winning_amount' => 0,
                ]);
            }
        }

        // 🏁 Update result status correctly
        if($isOpenDeclared) {
            $result->update(['status' => 'open_declared']);
        } else if($isCloseDeclared) {
            $result->update(['status' => 'close_declared']);
        }else
        if ($isOpenDeclared && $isCloseDeclared) {
            $result->update(['status' => 'declared']);
        } 
    });

    return response()->json([
        'message' => 'Winners declared successfully',
    ]);
}

    public function winners($resultId)
    {
        $result = Result::with('market')->findOrFail($resultId);

            $isOpenDeclared = !is_null($result->open_digit) || !is_null($result->open_panna);

        // Step 1: Decide winning values based on session
       if ($isOpenDeclared) {
        $winningDigit = (int) $result->open_digit;
        $winningPanna = $result->open_panna;
    } else {
        $winningDigit = (int) $result->close_digit;
        $winningPanna = $result->close_panna;
    }

        // $jodi = $result->open_digit.$result->close_digit;

        // Step 2: Fetch related bids
         $bids = Bid::with(['user', 'gameType'])
        ->where('market_id', $result->market_id)
        ->whereDate('draw_date', $result->result_date)
        ->where('status', 'pending')
        ->get();

        $winners = [];
        $losers = [];

        // return $bids;

        foreach ($bids as $bid) {

            $betData = json_decode($bid->bet_data, true) ?? [];
            $isWinner = false;
            // Step 3: Match bid based on game type
            switch ($bid->gameType->slug) {

                case 'single_digit':
                case 'single_digit_bulk':
                    $isWinner =
                        isset($betData['digit']) &&
                        (int) $betData['digit'] === $winningDigit;
                    break;

                case 'jodi':
                case 'jodi_bulk':
                   if (is_null($result->close_digit)) break;

                $jodi = $result->open_digit . $result->close_digit;
                $isWinner =
                    isset($betData['digit']) &&
                    $betData['digit'] === $jodi;
                break;

                case 'single_panna':
                case 'single_panna_bulk':
                case 'double_panna':
                case 'double_panna_bulk':
                case 'triple_panna':
                case 'triple_panna_bulk':
                    $isWinner =
                        isset($betData['panna']) &&
                        $betData['panna'] === $winningPanna;
                    break;

                case 'half_sangam':
                    if ($bid->session === 'open') {
                    $isWinner =
                        isset($betData['panna'], $betData['digit']) &&
                        $betData['panna'] === $result->open_panna &&
                        (int) $betData['digit'] === (int) $result->open_digit;
                } else {
                    $isWinner =
                        isset($betData['panna'], $betData['digit']) &&
                        $betData['panna'] === $result->close_panna &&
                        (int) $betData['digit'] === (int) $result->close_digit;
                }
                    break;

                case 'full_sangam':
                    if (is_null($result->close_panna)) break;

                $isWinner =
                    isset($betData['open_panna'], $betData['close_panna']) &&
                    $betData['open_panna'] === $result->open_panna &&
                    $betData['close_panna'] === $result->close_panna;
                break;
            }

            if ($isWinner) {
                 // Step 4: Calculate winning amount
            $winningAmount = $bid->amount * $bid->gameType->payout_rate;

            $winners[] = [
                'user_id' => $bid->user->id,
                'name' => $bid->user->name,
                'amount' => $bid->amount,
                'winning_amount' => $winningAmount,
                'game_type' => $bid->gameType->name,
                'transaction_id' => $bid->transaction_id,
                'session' => $bid->session,
            ];
            }else{
                $losers[] = [
                    'user_id' => $bid->user->id,
                    'name' => $bid->user->name,
                    'amount' => $bid->amount,
                    'game_type' => $bid->gameType->name,
                    'transaction_id' => $bid->transaction_id,
                    'session' => $bid->session,
                ];
            }

           
        }

        return response()->json([
            'result' => $result,
            'winners' => $winners,
            'losers' => $losers,
            'total_bid' => collect($winners)->sum('amount'),
            'total_win' => collect($winners)->sum('winning_amount'),
        ]);
    }

   public function searchWinningPredictions(Request $request)
{
    $request->validate([
        'date'        => 'required|date',
        'game_id'     => 'required|integer',
        'session'     => 'nullable|string',
        'open_panna'  => 'nullable|string',
        'close_panna' => 'nullable|string',
    ]);

    $query = Bid::with(['user', 'gameType'])
        ->whereDate('draw_date', $request->date)
        ->where('market_id', $request->game_id);

    if ($request->filled('session')) {
        $session = $request->session;
        $query->where('session', $session);
    } else {
        $session = null;
    }

    /*
    |--------------------------------------------------------------------------
    | PANNA FILTERING — SESSION AWARE
    |--------------------------------------------------------------------------
    */

    // OPEN SESSION PANNA FILTER
    if ($session === 'open' && $request->filled('open_panna')) {
    $openPanna = $request->open_panna;

    $query->where(function ($q) use ($openPanna) {

        // PANNA BASED GAMES
        $q->whereJsonContains('bet_data->panna', $openPanna)
          ->orWhereJsonContains('bet_data->open_panna', $openPanna)

          // Half sangam (open side)
          ->orWhere(function ($qq) use ($openPanna) {
              $qq->whereJsonContains('bet_data->panna', $openPanna)
                 ->whereHas('gameType', function ($g) {
                     $g->where('slug', 'half_sangam');
                 });
          })

          // DIGIT BASED GAMES — ALWAYS ALLOWED
          ->orWhereHas('gameType', function ($g) {
              $g->whereIn('slug', [
                  'single_digit',
                  'single_digit_bulk',
                  'jodi',
                  'jodi_bulk',
              ]);
          });
    });
}


    // CLOSE SESSION PANNA FILTER
   if ($session === 'close' && $request->filled('close_panna')) {
    $closePanna = $request->close_panna;

    $query->where(function ($q) use ($closePanna) {

        // PANNA BASED GAMES
        $q->whereJsonContains('bet_data->panna', $closePanna)
          ->orWhereJsonContains('bet_data->close_panna', $closePanna)

          // Half sangam (close side)
          ->orWhere(function ($qq) use ($closePanna) {
              $qq->whereJsonContains('bet_data->panna', $closePanna)
                 ->whereHas('gameType', function ($g) {
                     $g->where('slug', 'half_sangam');
                 });
          })

          // DIGIT BASED GAMES — ALWAYS ALLOWED
          ->orWhereHas('gameType', function ($g) {
              $g->whereIn('slug', [
                  'single_digit',
                  'single_digit_bulk',
                  'jodi',
                  'jodi_bulk',
              ]);
          });
    });
}


    $data = $query->get();

    // return $data;

    return response()->json([
        'data' => $data,
        'totals' => [
            'total_bid' => $data->sum('amount'),
            'total_win' => $data->sum('winning_amount' ),
            ],
        ] );
    }

}
