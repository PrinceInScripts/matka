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
    $result_id = $request->input('result_id');
        $result = Result::findOrFail( $result_id );
        DB::transaction( function () use ( $result ) {

            if ( $result->status === 'declared' ) {
                throw new Exception( 'Already declared' );
            }

            $bids = Bid::where( 'market_id', $result->market_id )
            // ->where( 'session', $result->session )
            ->whereDate( 'draw_date', $result->result_date )
            ->where( 'status', 'pending' )
            ->get();

            $winners = [];

            foreach ( $bids as $bid ) {
                $betData = json_decode( $bid->bet_data, true ) ?? [];
                $isWinner = false;
                // Step 3: Match bid based on game type
                switch ( $bid->gameType->slug ) {

                    case 'single_digit':
                    case 'single_digit_bulk':
                    $isWinner =
                    isset( $betData[ 'digit' ] ) &&
                    ( int ) $betData[ 'digit' ] === ( int ) $result-> {
                        "{$result->session}_digit"}
                        ;
                        break;

                        case 'jodi':
                        case 'jodi_bulk':
                        $isWinner =
                        isset( $betData[ 'digit' ] ) &&
                        $betData[ 'digit' ] === $result->open_digit.$result->close_digit;
                        break;

                        case 'single_panna':
                        case 'single_panna_bulk':
                        case 'double_panna':
                        case 'double_panna_bulk':
                        case 'triple_panna':
                        case 'triple_panna_bulk':
                        $isWinner =
                        isset( $betData[ 'panna' ] ) &&
                        $betData[ 'panna' ] === $result-> {
                            "{$result->session}_panna"}
                            ;
                            break;

                            case 'half_sangam':
                            if ( $bid->session === 'open' ) {
                                $isWinner =
                                isset( $betData[ 'panna' ], $betData[ 'digit' ] ) &&
                                $betData[ 'panna' ] === $result->open_panna &&
                                ( int ) $betData[ 'digit' ] === ( int ) $result->close_digit;
                            } else {
                                $isWinner =
                                isset( $betData[ 'panna' ], $betData[ 'digit' ] ) &&
                                $betData[ 'panna' ] === $result->close_panna &&
                                ( int ) $betData[ 'digit' ] === ( int ) $result->open_digit;
                            }
                            break;

                            case 'full_sangam':
                            $isWinner =
                            isset( $betData[ 'open_panna' ], $betData[ 'close_panna' ] ) &&
                            $betData[ 'open_panna' ] === $result->open_panna &&
                            $betData[ 'close_panna' ] === $result->close_panna;
                            break;
                        }

                        if ( ! $isWinner ) {
                            continue;
                        }

                        // Step 4: Calculate winning amount
                        $winningAmount = $bid->amount * $bid->gameType->payout_rate;

                        $winners[] = [
                            'user_id' => $bid->user->id,
                            'winning_amount' => $winningAmount,
                        ];
                        // Update bid status to 'won'
                        $bid->update( [ 'status' => 'won', 'result_id' => $result->id, 'winning_amount' => $winningAmount ] );
                    }

                    foreach ( $winners as $win ) {

                        $wallet = Wallet::where( 'user_id', $win[ 'user_id' ] )->first();

                        // Credit winning amount to user's wallet
                WalletTransactions::create([
                    'wallet_id' => $wallet->id,
                    'amount' => $win['winning_amount'],
                    'type' => 'credit',
                    'source' => 'win',
                    'reason' => 'Winning amount credited',
                    'reference_id' => $result->id,
                    'balance_after' => $wallet->balance + $win['winning_amount'],
                    'transaction_code' => 'WIN-'.strtoupper(uniqid()),
                ]);
            }

            $result->update(['status' => 'declared']);

            return response()->json([
                'message' => 'Winners declared successfully',
            ]);
        });

    }

    public function winners($resultId)
    {
        $result = Result::with('market')->findOrFail($resultId);

        // Step 1: Decide winning values based on session
        if ($result->session === 'open') {
            $winningDigit = (int) $result->open_digit;
            $winningPanna = $result->open_panna;
        } else {
            $winningDigit = (int) $result->close_digit;
            $winningPanna = $result->close_panna;
        }

        $jodi = $result->open_digit.$result->close_digit;

        // Step 2: Fetch related bids
        $bids = Bid::with(['user', 'gameType'])
            ->where('market_id', $result->market_id)
               // ->where('session', $result->session)
            ->whereDate('draw_date', $result->result_date)
            ->where('status', 'pending')
            ->get();

        $winners = [];

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
                            (int) $betData['digit'] === (int) $result->close_digit;
                    } else {
                        $isWinner =
                            isset($betData['panna'], $betData['digit']) &&
                            $betData['panna'] === $result->close_panna &&
                            (int) $betData['digit'] === (int) $result->open_digit;
                    }
                    break;

                case 'full_sangam':
                    $isWinner =
                        isset($betData['open_panna'], $betData['close_panna']) &&
                        $betData['open_panna'] === $result->open_panna &&
                        $betData['close_panna'] === $result->close_panna;
                    break;
            }

            if (! $isWinner) {
                continue;
            }

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
        }

        return response()->json([
            'result' => $result,
            'winners' => $winners,
            'total_bid' => collect($winners)->sum('amount'),
            'total_win' => collect($winners)->sum('winning_amount'),
        ]);
    }

    public function searchWinningPredictions(Request $request)
    {
        $query = Bid::whereDate('created_at', $request->date)
            ->where('market_id', $request->game_id);

        if ($request->session) {
            $query->where('session', $request->session);
        }

        if ($request->open_panna) {
            $query->where('panna', $request->open_panna);
        }

        if ($request->close_panna) {
            $query->where('panna', $request->close_panna);
        }

        $data = $query->get();

        return response()->json([
            'data' => $data,
            'totals' => [
                'total_bid' => $data->sum('bid_points'),
                'total_win' => $data->sum('winning_points' ),
                    ],
                ] );

            }
        }
