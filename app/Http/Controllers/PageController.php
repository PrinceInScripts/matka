<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\GameList;
use App\Models\GameType;
use App\Models\MarketGameType;
use App\Models\StarlineGameType;
use App\Models\StarlineName;
use App\Models\StarlineSchedule;
use App\Models\WalletTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function home()
    {
        $today = strtolower(now()->format('D'));
    $now   = now();

    $games = GameList::where('game_status', 1)
        ->where('market_type', 'main')
        ->get()
        ->map(function ($game) use ($today, $now) {

            $schedule = DB::table('market_schedules')
                ->where('market_id', $game->id)
                ->where('weekday', $today)
                ->first();

            $game->today_open_time  = $schedule->open_time ?? null;
            $game->today_close_time = $schedule->close_time ?? null;
            $game->today_is_open    = $schedule->is_open ?? 0;

            // FINAL LIVE CHECK
            if (
                $game->game_status == 1 &&
                $game->market_status == 1 &&
                $game->today_is_open == 1 &&
                $game->today_open_time &&
                $game->today_close_time
            ) {
                $open  = now()->setTimeFromTimeString($game->today_open_time);
                $close = now()->setTimeFromTimeString($game->today_close_time);

                if ($now->between($open, $close)) {
                    $game->is_live = true;
                    $game->user_message = 'Betting is running now';
                } elseif ($now->lt($open)) {
                    $game->is_live = false;
                    $game->user_message = 'Betting not opened yet';
                } else {
                    $game->is_live = false;
                    $game->user_message = 'Betting closed for today';
                }
            } else {
                $game->is_live = false;

                if ($game->market_status == 0) {
                    $game->user_message = 'Market is closed by admin';
                } elseif ($game->today_is_open == 0) {
                    $game->user_message = 'Market is closed today';
                } else {
                    $game->user_message = 'Betting unavailable';
                }
            }

            return $game;
        });


        // return $games;

        return view('pages.home', compact('games'));
    }

    public function starline()
    {
        $today = strtolower(now()->format('D')); // mon, tue...

    $games = StarlineName::where('game_status', 1)
        ->get()
        ->map(function ($game) use ($today) {

            $schedule = DB::table('starline_schedule')
                ->where('starline_id', $game->id)
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

        return view('games.starline', compact('games'));
    }

    public function galidisawar()
    {
        $games = GameList::where('game_status', 1)->where('market_type', 'galidisawar')->get();

        return view('games.galidisawar', compact('games'));
    }

    public function play($slug)
{
    $game = GameList::where('slug', $slug)->firstOrFail();
    $gameTypes = $game->gameTypes()->wherePivot('is_active', 1)->get();
    $game_type='market';
    return view('pages.play', compact('game', 'gameTypes','game_type'));
}
    public function starlineGame($slug)
{
    $game = StarlineName::where('slug', $slug)->firstOrFail();
    $gameTypes = $game->gameTypes()->wherePivot('is_active', 1)->get();
    $game_type='starline';
    return view('pages.play', compact('game', 'gameTypes','game_type'));
}

    public function single()
    {
        return view('games.single');
    }

    public function bulk()
    {
        return view('games.bulk');
    }

    public function test(){
    //      $gameId = 1;

    // while ($gameId <= 14) {
    //     foreach (['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'] as $i) {
    //         StarlineSchedule::create([
    //             'starline_id' => $gameId,
    //             'weekday' => $i,
    //             'is_open' => 1,
    //             'open_time' => '00:00:00',
    //             'close_time' => '23:59:59',
    //         ]);
    //     }
    //     $gameId++;
    // }
        // return view('pages.test');

         $weekdays = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

        /**
         * Starline slot timings
         * key   = starline_id
         * value = [open_time, close_time]
         */
        $starlineSlots = [
            1  => ['10:00:00', '10:05:00'],
            2  => ['11:00:00', '11:05:00'],
            3  => ['12:00:00', '12:05:00'],
            4  => ['13:00:00', '13:05:00'],
            5  => ['14:00:00', '14:05:00'],
            6  => ['15:00:00', '15:05:00'],
            7  => ['16:00:00', '16:05:00'],
            8  => ['17:00:00', '17:05:00'],
            9  => ['18:00:00', '18:05:00'],
            10 => ['19:00:00', '19:05:00'],
            11 => ['20:00:00', '20:05:00'],
            12 => ['21:00:00', '21:05:00'],
            13 => ['22:00:00', '22:05:00'],
            14 => ['23:00:00', '23:05:00'],
        ];

        foreach ($starlineSlots as $starlineId => [$openTime, $closeTime]) {

            // Safety check: skip if starline name does not exist
            if (!StarlineName::where('id', $starlineId)->exists()) {
                continue;
            }

            foreach ($weekdays as $day) {
                StarlineSchedule::updateOrCreate(
                    [
                        'starline_id' => $starlineId,
                        'weekday'     => $day,
                    ],
                    [
                        'is_open'    => 1,
                        'open_time'  => $openTime,
                        'close_time' => $closeTime,
                    ]
                );
            }
        }

        return response()->json([
            'status'  => true,
            'message' => 'Starline schedules seeded successfully',
        ]);

    }

    public function test1() {

        $gameTypeIds=[1,5,7,9];
        for($i=1; $i<=15; $i++){
            foreach($gameTypeIds as $gtid){
                StarlineGameType::updateOrCreate(
                    [
                        'market_id' => $i,
                        'game_type_id' => $gtid,
                    ],
                    [
                        'is_active' => 1,
                    ]
                );
            }
        }
    }

    public function accountStatement(Request $request)
{
    $user = Auth::user();

    $query = WalletTransactions::whereHas('wallet', function ($q) use ($user) {
        $q->where('user_id', $user->id);
    });

    // ✅ Filters
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('reason')) {
        $query->where('reason', 'like', "%{$request->reason}%");
    }

    if ($request->filled('date_from')) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }

    $transactions = $query->orderBy('id', 'desc')->paginate(10);

    if ($request->ajax()) {
        return response()->json([
            'html' => view('pages.account-statement-partials-list', compact('transactions'))->render(),
        ]);
    }

    return view('pages.account-statement', compact('transactions'));
}

// public function accountStatement(Request $request)
// {
//     $user = Auth::user();

//     $query = WalletTransactions::whereHas('wallet', function ($q) use ($user) {
//         $q->where('user_id', $user->id);
//     });

//     // Filters
//     if ($request->filled('type')) {
//         $query->where('type', $request->type);
//     }

//     if ($request->filled('remark')) {
//         $query->where('remark', 'like', "%{$request->remark}%");
//     }

//     $transactions = $query->orderBy('id', 'desc')->paginate(10);

//     // AJAX response
//     if ($request->ajax()) {
//         return response()->json([
//             'html' => view('pages.account-statement-partials-list', compact('transactions'))->render(),
//         ]);
//     }

//     return view('pages.account-statement', compact('transactions'));
// }



    public function gameRates()
    {
        $gamesTypes = GameType::all();
        return view('pages.game-rates', compact('gamesTypes'));
    }

    public function halfSangam()
    {
        return view('games.halfsangam');
    }

    public function fullSangam()
    {
        return view('games.fullsangam');
    }

}
