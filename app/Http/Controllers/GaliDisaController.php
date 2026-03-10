<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GaliDisawarGame;
use App\Models\GaliDisawarGameRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GaliDisaController extends Controller
{
    public function galiDisawar()
    {
         $today = strtolower(now()->format('D')); // mon, tue...
          $rates = GaliDisawarGameRate::all()->keyBy('game_type');

        //   return $rates;

    $games = GaliDisawarGame::where('game_status', 1)
        ->get()
        ->map(function ($game) use ($today) {

            $schedule = DB::table('gali_disawar_schedule')
                ->where('gali_id', $game->id)
                ->where('weekday', $today)
                ->first();

            $game->today_open_time  = $schedule->open_time ?? null;
            $game->today_close_time = $schedule->close_time ?? null;
            $game->is_open_today    = $schedule->is_open ?? 0;

            $now = now();

            // Default flags
            $game->is_live = false;
            $game->user_message = 'Betting Closed';

            // ADMIN FORCE CLOSED
            if ($game->market_status == 0) {
                $game->user_message = 'Market Closed by Admin';
                return $game;
            }

            // CLOSED TODAY
            if (!$game->is_open_today) {
                $game->user_message = 'Market Closed Today';
                return $game;
            }

            // TIME CHECK
            if ($game->today_open_time && $game->today_close_time) {
                $open  = now()->setTimeFromTimeString($game->today_open_time);
                $close = now()->setTimeFromTimeString($game->today_close_time);

                if ($now->lt($open)) {
                    $game->user_message = 'Betting Not Opened Yet';
                } elseif ($now->gt($close)) {
                    $game->user_message = 'Betting Closed';
                } else {
                    $game->is_live = true;
                    $game->user_message = 'Betting Running';
                }
            }

            $game->open_time_format  = $game->today_open_time
                ? date('h:i A', strtotime($game->today_open_time)) : '--';

            $game->close_time_format = $game->today_close_time
                ? date('h:i A', strtotime($game->today_close_time)) : '--';

            return $game;
        });

        return view('games.galidisawar', compact('games'));
    }
}
