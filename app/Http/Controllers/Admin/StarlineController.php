<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameList;
use App\Models\GameType;
use App\Models\StarlineBidHistory;
use App\Models\StarlineGamesType;
use App\Models\StarlineName;
use App\Models\StarlineRate;
use App\Models\StarlineResult;
use App\Models\StarlineSchedule;
use App\Models\WalletTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function PHPSTORM_META\map;

class StarlineController extends Controller
{
    public function game_name()
    {
          $today = strtolower(now()->format('D')); // mon, tue, wed...

       
        $schedules = DB::table('starline_schedule')
        ->where('weekday', $today)
        ->get()
        ->keyBy('starline_id');

        $markets = StarlineName::where('game_status', 1)->get()->map(function ($market) use ($schedules) {

        $schedule = $schedules->get($market->id);

        $market->today_open_time  = $schedule->open_time ?? null;
        $market->today_close_time = $schedule->close_time ?? null;
        $market->today_is_open    = $schedule->is_open ?? 0;

        // FINAL decision logic
        $now = now();

        if (!$market->game_status) {
            $market->status_text = 'Disabled';
            $market->status_color = 'secondary';
        }
        elseif (!$market->market_status) {
            $market->status_text = 'Closed by Admin';
            $market->status_color = 'danger';
        }
        elseif (!$market->today_is_open) {
            $market->status_text = 'Closed Today';
            $market->status_color = 'danger';
        }
        else {
            $open = now()->setTimeFromTimeString($market->today_open_time);
            $close = now()->setTimeFromTimeString($market->today_close_time);

            if ($now->lt($open)) {
                $market->status_text = 'Not Opened Yet';
                $market->status_color = 'warning';
            }
            elseif ($now->gt($close)) {
                $market->status_text = 'Closed';
                $market->status_color = 'danger';
            }
            else {
                $market->status_text = 'Open Now';
                $market->status_color = 'success';
            }
        }

        $market->open_time_format  = $market->today_open_time
            ? date('h:i A', strtotime($market->today_open_time))
            : '--';

        $market->close_time_format = $market->today_close_time
            ? date('h:i A', strtotime($market->today_close_time))
            : '--';

        return $market;
        });
           // return $markets;    
        return view('admin.starline.game_name', compact('markets'));
    }

     public function store(Request $request)
    {
         $request->validate([
        'name'          => 'required|string|max:255',
        'open_time'     => 'required',
        'close_time'    => 'required|after:open_time',
        'game_status'   => 'required|boolean',
        'market_status' => 'required|boolean',
         ]);

        $game = StarlineName::create([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'game_status'   => $request->game_status,
            'market_status' => $request->market_status,
        ]);

        foreach ([1,2,3,4] as $gameTypeId) {
            DB::table('starline_gametypes')->insert([
                'starline_id'   => $game->id,
                'game_type_id'  => $gameTypeId,
                'is_active'     => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        foreach (['mon','tue','wed','thu','fri','sat','sun'] as $day) {
            DB::table('starline_schedule')->insert([
                'starline_id' => $game->id,
                'weekday'     => $day,
                'is_open'     => 1,
                'open_time'   => $request->open_time,
                'close_time'  => $request->close_time,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Starline game added successfully',
        ]);
    }

    public function update(Request $request, $id)
    {
         $market = StarlineName::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'open_time'     => 'required',
            'close_time'    => 'required|after:open_time',
            'game_status'   => 'required|boolean',
            'market_status' => 'required|boolean',
        ]);

        // 1️⃣ Update game identity & admin controls
        $market->update([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'game_status'   => $request->game_status,
            'market_status' => $request->market_status,
        ]);

        // 2️⃣ Update timing for ALL weekdays
        DB::table('starline_schedule')
            ->where('starline_id', $market->id)
            ->update([
                'open_time'  => $request->open_time,
                'close_time' => $request->close_time,
                'updated_at' => now(),
            ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Starline game updated successfully',
        ]);
    }

    public function getSchedule($id)
    {
        $days = ['mon','tue','wed','thu','fri','sat','sun'];

        $schedule = StarlineSchedule::where('starline_id', $id)
            ->orderByRaw("FIELD(weekday, 'mon','tue','wed','thu','fri','sat','sun')")
            ->get();

        // safety: ensure all 7 days exist
        if ($schedule->count() < 7) {
            foreach ($days as $day) {
                StarlineSchedule::firstOrCreate([
                    'starline_id' => $id,
                    'weekday'     => $day,
                ], [
                    'is_open'    => 1,
                    'open_time'  => '00:00:00',
                    'close_time' => '00:00:00',
                ]);
            }

            $schedule = StarlineSchedule::where('starline_id', $id)->get();
        }

        return response()->json($schedule);
    }


    public function updateSchedule(Request $request, $id)
    {
        foreach ($request->weekday as $index => $day) {

            StarlineSchedule::where('starline_id', $id)
                ->where('weekday', $day)
                ->update([
                    'is_open'    => isset($request->is_open[$index]) ? 1 : 0,
                    'open_time'  => $request->open_time[$index] ?? null,
                    'close_time' => $request->close_time[$index] ?? null,
                    'updated_at'=> now(),
                ]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Schedule updated successfully',
        ]);
    }


    public function rates()
    {
    // $rates = StarlineRate::all()->keyBy('game_type');
     $rates = StarlineGamesType::orderBy('sort_order')->get();
        // return $rates;
        return view('admin.starline.rates', compact('rates'));
    }

   
    public function update_rates(Request $request)
{
    // return $request;
    // $request->validate([
    //     'rates' => 'required|array',
    // ]);

    // foreach ($request->rates as $gameType => $payout) {
    //     StarlineRate::where('game_type', $gameType)
    //         ->update([
    //             'payout_rate' => $payout,
    //             'status' => true,
    //         ]);
    // }

    // return response()->json([
    //     'status'  => 'success',
    //     'message' => 'Starline Rates updated successfully',
    // ]);

    foreach ($request->rates as $slug => $data) {

        $value2 = (float) $data['value2'];

        // value1 is always 10
        $payoutRate = $value2 / 10;

        StarlineGamesType::where('slug', $slug)->update([
            'payout_rate' => $payoutRate,
        ]);
    }

    return response()->json([
        'status' => true,
        'message' => 'Game rates updated successfully',
    ]);
}


    public function bid_history()
    {
         $userBids=StarlineBidHistory::with('user','starline')->orderBy('created_at','desc')->get();

        $games = StarlineName::where('game_status', 1)
    ->with(['todaySchedule'])
    ->whereHas('todaySchedule')
    ->get();


       $gameType=StarlineGamesType::all();

        return view('admin.starline.bid_history', compact('userBids', 'games', 'gameType'));
    }

    public function filter_bid_history(Request $request)
{
    $query = StarlineBidHistory::with(['user', 'starline', 'gameType']);

    if ($request->date) {
        $query->whereDate('created_at', $request->date);
    }

    if ($request->game_id) {
        $query->where('starline_id', $request->game_id);
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


    public function declare_result()
    {
         $games = StarlineName::where('game_status', 1)->get();

    // Generate pannas (same logic reused)
    $pannas = [];

    for ($i = 0; $i <= 9; $i++) {
        $pannas[] = "{$i}{$i}{$i}";
    }

    for ($i = 0; $i <= 9; $i++) {
        for ($j = 0; $j <= 9; $j++) {
            for ($k = 0; $k <= 9; $k++) {
                if ($i !== $j && $i !== $k && $j !== $k) {
                    $pannas[] = "{$i}{$j}{$k}";
                }
            }
        }
    }

    $pannas = collect($pannas)
        ->unique(fn ($num) => collect(str_split($num))->sort()->implode(''))
        ->values()
        ->toArray();

    $results = StarlineResult::with('starline')->latest()->get();

        return view('admin.starline.declare_result',compact('games','pannas','results'));
    }

    public function result_history()
    {
        $results   = StarlineResult::with('starline')->orderBy('draw_date','desc')->get();
        $declared  = $results->where('status','declared')->count();
        $draft     = $results->where('status','draft')->count();
        $thisMonth = $results->where('draw_date','>=', now()->startOfMonth())->count();
        return view('admin.starline.result_history', compact('results','declared','draft','thisMonth'));
    }

    public function sell_report()
    {
        $games = StarlineName::where('game_status',1)->get();
        return view('admin.starline.sell_report', compact('games'));
    }

    public function sell_report_filter(\Illuminate\Http\Request $request)
    {
        $request->validate(['date' => 'required|date']);
        $query = StarlineBidHistory::with('gameType','starline')
            ->whereDate('bid_date', $request->date);
        if ($request->filled('game_id')) $query->where('starline_id', $request->game_id);
        $bids = $query->get();
        $grouped = $bids->groupBy(fn($b) => $b->game_type_id ?? 'Unknown')
            ->map(fn($g) => [
                'game_type'    => $g->first()->game_type_id ?? '—',
                'total_bids'   => $g->count(),
                'total_amount' => $g->sum('amount'),
                'total_win'    => $g->where('status','won')->sum('winning_amount'),
            ])->values();
        return response()->json([
            'status' => true, 'data' => $grouped,
            'total_bids'   => $bids->count(),
            'total_amount' => $bids->sum('amount'),
            'total_win'    => $bids->where('status','won')->sum('winning_amount'),
        ]);
    }

    public function winning_report()
    {
        $games = StarlineName::where('game_status',1)->get();
        return view('admin.starline.winning_report', compact('games'));
    }

    public function winning_report_filter(\Illuminate\Http\Request $request)
    {
        $request->validate(['date' => 'required|date']);
        $query = StarlineBidHistory::with('user','starline','gameType')
            ->where('status','won')->whereDate('bid_date', $request->date);
        if ($request->filled('game_id')) $query->where('starline_id', $request->game_id);
        $bids = $query->orderBy('winning_amount','desc')->get();
        return response()->json(['status' => true, 'data' => $bids, 'total_win' => $bids->sum('winning_amount')]);
    }

    public function winning_prediction()
    {
        // Active starline markets
    $games = StarlineName::where('game_status', 1)->get();

    // Existing declared results (optional, for display)
    $results = StarlineResult::with('starline')->latest()->get();

    // Generate panna list (same logic, reused)
    $pannas = [];

    // Triple panna
    for ($i = 0; $i <= 9; $i++) {
        $pannas[] = "{$i}{$i}{$i}";
    }

    // Single / Double panna (unique sets)
    for ($i = 0; $i <= 9; $i++) {
        for ($j = 0; $j <= 9; $j++) {
            for ($k = 0; $k <= 9; $k++) {
                if ($i !== $j && $i !== $k && $j !== $k) {
                    $pannas[] = "{$i}{$j}{$k}";
                }
            }
        }
    }

    $pannas = collect($pannas)
        ->unique(fn ($num) => collect(str_split($num))->sort()->implode(''))
        ->values()
        ->toArray();

    // return view('admin.starline_winning_predictions', compact(
    //     'games',
    //     'results',
    //     'pannas'
    // ));
        return view('admin.starline.winning_prediction', compact('games', 'results', 'pannas'));
    }

    public function searchStarlineWinningPredictions(Request $request)
{
    $request->validate([
        'date'       => 'required|date',
        'starline_id'=> 'required|integer|exists:starline_names,id',
        'digit'      => 'nullable|integer|min:0|max:9',
        'panna'      => 'nullable|string|size:3',
    ]);

    $query = StarlineBidHistory::with(['user', 'gameType'])
        ->whereDate('draw_date', $request->date)
        ->where('starline_id', $request->starline_id);

   
    if ($request->filled('digit')) {
        $digit = (string) $request->digit;

        $query->where(function ($q) use ($digit) {
            $q->whereJsonContains('bet_data->digit', (int)$digit)
              ->orWhereHas('gameType', function ($g) {
                  $g->whereIn('slug', ['single_panna', 'double_panna', 'triple_panna']);
              });
        });
    }

   
    if ($request->filled('panna')) {
        $panna = $request->panna;

        $query->where(function ($q) use ($panna) {
            $q->whereJsonContains('bet_data->panna', $panna)
              ->orWhereHas('gameType', function ($g) {
                  $g->whereIn('slug', ['single_digit', 'jodi']);
              });
        });
    }

    $data = $query->get();

    return response()->json([
        'data' => $data,
        'totals' => [
            'total_bid' => $data->sum('amount'),
            'total_win' => $data->where('status', 'won')->sum('winning_amount'),
        ],
    ]);
}

public function getContext(Request $request)
{
    $request->validate([
        'starline_id' => 'required|integer',
        'date'        => 'required|date',
        'digit'       => 'nullable|integer|min:0|max:9',
        'panna'       => 'nullable|string',
    ]);

    $query = StarlineBidHistory::with(['user', 'gameType'])
        ->where('starline_id', $request->starline_id)
        ->whereDate('draw_date', $request->date)
        ->where('status', 'pending');

    if ($request->filled('digit')) {
        $query->whereJsonContains('bet_data->digit', (int) $request->digit);
    }

    if ($request->filled('panna')) {
        $query->whereJsonContains('bet_data->panna', $request->panna);
    }

    $bids = $query->get();

    return response()->json([
        'data' => $bids,
        'totals' => [
            'total_bid' => $bids->sum('amount'),
            'total_win' => $bids->sum('winning_amount'),
        ],
    ]);
}

public function saveDraft(Request $request)
{
    $request->validate([
        'starline_id'   => 'required|integer',
        'result_digit'  => 'required|integer|min:0|max:9',
        'result_pana'   => 'nullable|string',
        'date'          => 'required|date',
    ]);

    $result = StarlineResult::updateOrCreate(
        [
            'starline_id' => $request->starline_id,
            'draw_date'   => $request->date,
        ],
        [
            'result_digit' => $request->result_digit,
            'result_pana'  => $request->result_pana,
            'status'       => 'draft', // force draft always
        ]
    );

    return response()->json([
        'result_id' => $result->id,
        'status'    => true,
    ]);
}

public function winners(StarlineResult $result)
{
    $bids = StarlineBidHistory::with(['user', 'gameType'])
        ->where('starline_id', $result->starline_id)
        ->whereDate('draw_date', $result->draw_date)
        // ->where('status', 'pending')
        ->get();

    $winners = [];
    $losers = [];

    foreach ($bids as $bid) {

        // ✅ FIX 1: decode JSON properly
        $bet = is_array($bid->bet_data)
            ? $bid->bet_data
            : json_decode($bid->bet_data, true);

        $isWinner = false;

        // ✅ FIX 2: strict & safe comparison
        if (
            isset($bet['digit']) &&
            (int)$bet['digit'] === (int)$result->result_digit
        ) {
            $isWinner = true;
        }

        if (
            isset($bet['panna']) &&
            $result->result_pana !== null &&
            $bet['panna'] === $result->result_pana
        ) {
            $isWinner = true;
        }

        if ($isWinner) {
            $winners[] = [
                'user_id' => $bid->user->id,
                'name' => $bid->user->name,
                'amount' => $bid->amount,
                'winning_amount' => $bid->winning_amount,
                'game_type' => $bid->gameType->name,
                'txn_id' => $bid->txn_id,
                'bid_time' => $bid->created_at->format('Y-m-d H:i:s'),
            ];
        } else {
            $losers[] = [
                'user_id' => $bid->user->id,
                'name' => $bid->user->name,
                'amount' => $bid->amount,
                'game_type' => $bid->gameType->name,
                'txn_id' => $bid->txn_id,
                'bid_time' => $bid->created_at->format('Y-m-d H:i:s'),
            ];
        }
    }

    return response()->json([
        'result' => $result,
        'winners' => $winners,
        'losers' => $losers,
        'total_bid' => collect($bids)->sum('amount'),
        'total_win' => collect($winners)->sum('winning_amount'),
    ]);
}
public function declareWinners(Request $request)
{
    $request->validate([
        'result_id' => 'required|exists:starline_results,id',
    ]);

    DB::transaction(function () use ($request) {

        $result = StarlineResult::findOrFail($request->result_id);

        if ($result->declared_at) {
            throw new \Exception('Already declared');
        }

        // ✅ Prevent empty result declaration
        if (is_null($result->result_digit) && is_null($result->result_pana)) {
            throw new \Exception('Result data is empty');
        }

        $bids = StarlineBidHistory::with(['user.wallet', 'gameType'])
            ->where('starline_id', $result->starline_id)
            ->whereDate('draw_date', $result->draw_date)
            ->where('status', 'pending')
            ->get();

        foreach ($bids as $bid) {

            // ✅ FIX: decode JSON safely
            $bet = is_array($bid->bet_data)
                ? $bid->bet_data
                : json_decode($bid->bet_data, true);

            $wallet = $bid->user->wallet;

            if (!$wallet) {
                throw new \Exception("Wallet not found for user ID {$bid->user->id}");
            }

            $isWin = false;

            // ✅ strict comparison
            if (
                isset($bet['digit']) &&
                (int)$bet['digit'] === (int)$result->result_digit
            ) {
                $isWin = true;
            }

            if (
                isset($bet['panna']) &&
                $result->result_pana !== null &&
                $bet['panna'] === $result->result_pana
            ) {
                $isWin = true;
            }

            // 🔓 release frozen balance
            $wallet->decrement('frozen_balance', $bid->amount);

            if ($isWin) {

                $winAmount = $bid->amount * $bid->gameType->payout_rate;

                // ✅ update wallet FIRST
                // $wallet->increment('balance', $winAmount);

                $bid->update([
                    'status' => 'won',
                    'winning_amount' => $winAmount,
                    'result_id' => $result->id,
                ]);

                $wallet->increment('balance', $winAmount);
$wallet->refresh(); // ← add this line


                // ✅ correct balance_after
                WalletTransactions::create([
                    'wallet_id' => $wallet->id,
                    'amount' => $winAmount,
                    'type' => 'credit',
                    'source' => 'starline_win',
                    'reason' => "Win for bid ID {$bid->id}",
                    'reference_id' => $bid->id,
                    'balance_after' => $wallet->balance,
                ]);

            } else {

                $bid->update([
                    'status' => 'lost',
                    'winning_amount' => 0,
                    'result_id' => $result->id,
                ]);
            }
        }

        // 🏁 mark declared
        $result->update([
            'declared_at' => now(),
             'status' => 'declared',
        ]);
    });

    return response()->json([
        'message' => 'Starline winners declared successfully',
    ]);
}
}