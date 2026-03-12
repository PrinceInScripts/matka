<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaliDisawarBid;
use App\Models\GaliDisawarGame;
use App\Models\GaliDisawarGameRate;
use App\Models\GaliDisawarGameType;
use App\Models\GaliDisawarResult;
use App\Models\GaliDisawarSchedule;
use App\Models\GaliDisawarType;
use App\Models\GameType;
use App\Models\WalletTransactions;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function PHPSTORM_META\map;

class GaliDisawarController extends Controller
{
    public function game_name()
    {
          $today = strtolower(now()->format('D')); // mon, tue, wed...

       
        $schedules = DB::table('gali_disawar_schedule')
        ->where('weekday', $today)
        ->get()
        ->keyBy('gali_id');

    $markets = GaliDisawarGame::where('game_status', 1)->get()->map(function ($market) use ($schedules) {

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
        return view('admin.gali_disawar.game_name', compact('markets'));
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

    $game = GaliDisawarGame::create([
        'name'          => $request->name,
        'slug'          => Str::slug($request->name),
        'game_status'   => $request->game_status,
        'market_status' => $request->market_status,
    ]);

     for ($i = 1; $i <= 4; $i++) {
            DB::table('gali_disawar_gametypes')->insert([
                'gali_id' => $game->id,
                'game_type_id' => $i,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    foreach (['mon','tue','wed','thu','fri','sat','sun'] as $day) {
        DB::table('gali_disawar_schedule')->insert([
            'gali_id' => $game->id,
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
        'message' => 'Gali Disawar game added successfully',
    ]);
    }

    public function update(Request $request, $id)
    {
         $market = GaliDisawarGame::findOrFail($id);

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
    DB::table('gali_disawar_schedule')
        ->where('gali_id', $market->id)
        ->update([
            'open_time'  => $request->open_time,
            'close_time' => $request->close_time,
            'updated_at' => now(),
        ]);

    return response()->json([
        'status'  => 'success',
        'message' => 'Gali Disawar game updated successfully',
    ]);
    }

    public function getSchedule($id)
{
    $days = ['mon','tue','wed','thu','fri','sat','sun'];

    $schedule = GaliDisawarSchedule::where('gali_id', $id)
        ->orderByRaw("FIELD(weekday, 'mon','tue','wed','thu','fri','sat','sun')")
        ->get();

    // safety: ensure all 7 days exist
    if ($schedule->count() < 7) {
        foreach ($days as $day) {
            GaliDisawarSchedule::firstOrCreate([
                'gali_id' => $id,
                'weekday'     => $day,
            ], [
                'is_open'    => 1,
                'open_time'  => '00:00:00',
                'close_time' => '00:00:00',
            ]);
        }

        $schedule = GaliDisawarSchedule::where('gali_id', $id)->get();
    }

    return response()->json($schedule);
}



public function updateSchedule(Request $request, $id)
{
    foreach ($request->weekday as $index => $day) {

        GaliDisawarSchedule::where('gali_id', $id)
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
    // $rates = GaliDisawarGameRate::all()->keyBy('game_type');
    $rates = GaliDisawarType::orderBy('sort_order')->get();
        // return $rates;  
        return view('admin.gali_disawar.rates', compact('rates'));
    }

   
    public function update_rates(Request $request)
{
    // return $request;
    // $request->validate([
    //     'rates' => 'required|array',
    // ]);

    // foreach ($request->rates as $gameType => $payout) {
    //     GaliDisawarGameRate::where('game_type', $gameType)
    //         ->update([
    //             'payout_rate' => $payout,
    //             'status' => true,
    //         ]);
    // }

    // return response()->json([
    //     'status'  => 'success',
    //     'message' => 'Gali Disawar Rates updated successfully',
    // ]);

     foreach ($request->rates as $slug => $data) {

        $value2 = (float) $data['value2'];

        // value1 is always 10
        $payoutRate = $value2 / 10;

        GaliDisawarType::where('slug', $slug)->update([
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
         $userBids=GaliDisawarBid::with('user','galiDisawar')->orderBy('created_at','desc')->get();

        $games = GaliDisawarGame::where('game_status', 1)
    ->with(['todaySchedule'])
    ->whereHas('todaySchedule')
    ->get();


       $gameType=GameType::all();

        return view('admin.gali_disawar.bid_history', compact('userBids', 'games', 'gameType'));
    }

    public function filter_bid_history(Request $request)
{
    $query = GaliDisawarBid::with(['user', 'galiDisawar', 'gameType']);

    if ($request->date) {
        $query->whereDate('created_at', $request->date);
    }

    if ($request->game_id) {
        $query->where('gali_id', $request->game_id);
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
         $games = GaliDisawarGame::where('game_status', 1)
    ->with(['todaySchedule'])
    ->whereHas('todaySchedule')
    ->get();

   
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

        // collapse permutations into 120 unique sets
        $pannas = collect($pannas)
            ->unique(fn ($num) => collect(str_split($num))->sort()->implode(''))
            ->values()
            ->toArray();

        $results = GaliDisawarResult::with('gali')->get();
        // return $results;

        return view('admin.gali_disawar.declare_result', compact('games', 'pannas', 'results'));
    }

    public function getContext(Request $request)
    {
        $galiId = $request->gali_id ?? $request->game_id;
        $date   = $request->draw_date ?? $request->date ?? now()->toDateString();

        $result = GaliDisawarResult::where([
            'gali_id'   => $galiId,
            'draw_date' => $date,
        ])->first();

        return response()->json($result); // returns null-safe JSON
    }

    public function saveDraft(Request $request)
{
    $request->validate([
        'gali_id'     => 'required|integer|exists:gali_disawar_games,id',
        'draw_date'   => 'required|date',
        'result_jodi' => 'required|digits:2',
    ]);

    // ✅ derive digits from jodi
    $leftDigit  = (int) $request->result_jodi[0];
    $rightDigit = (int) $request->result_jodi[1];

    // optional: sum logic if needed
    $digit = ($leftDigit + $rightDigit) % 10;

    $result = GaliDisawarResult::updateOrCreate(
        [
            'gali_id'   => $request->gali_id,
            'draw_date' => $request->draw_date,
        ],
        [
            'result_jodi'  => $request->result_jodi,
            'result_digit' => $digit, // optional but useful
            'status'       => 'draft',
        ]
    );

    return response()->json([
        'result_id' => $result->id,
        'status'    => true,
    ]);
}
public function declareWinners(Request $request)
{
    $request->validate([
        'result_id' => 'required|exists:gali_disawar_results,id',
    ]);

    DB::transaction(function () use ($request) {

        $result = GaliDisawarResult::findOrFail($request->result_id);

        // ❌ prevent duplicate declaration
        if ($result->declared_at) {
            throw new \Exception('Result already declared');
        }

        // ❌ validate result exists
        if (is_null($result->result_digit) && is_null($result->result_jodi)) {
            throw new \Exception('Result data missing');
        }

        // 🎯 final values
        $openDigit  = (int) substr($result->result_jodi, 0, 1);
        $closeDigit = (int) substr($result->result_jodi, 1, 1);
        $jodi       = $result->result_jodi;

        // 📥 get all pending bids
        $bids = GaliDisawarBid::with(['user.wallet', 'gameType'])
            ->where('gali_id', $result->gali_id)
            ->whereDate('draw_date', $result->draw_date)
            ->where('status', 'pending')
            ->get();

        foreach ($bids as $bid) {

            $bet = is_array($bid->bet_data)
                ? $bid->bet_data
                : json_decode($bid->bet_data, true);

            $wallet = $bid->user->wallet;

            if (!$wallet) {
                throw new \Exception("Wallet missing for user {$bid->user_id}");
            }

            $isWin = false;

            switch ($bid->gameType->slug) {

                case 'single_digit':
                    // 🔥 IMPORTANT: decide logic (both digits allowed)
                    $isWin =
                        isset($bet['digit']) &&
                        (
                            (int)$bet['digit'] === $openDigit ||
                            (int)$bet['digit'] === $closeDigit
                        );
                    break;

                case 'jodi_digit':
                    $isWin =
                        isset($bet['digit']) &&
                        $bet['digit'] === $jodi;
                    break;

                case 'left_digit':
                    $isWin =
                        isset($bet['digit']) &&
                        (int)$bet['digit'] === $openDigit;
                    break;

                case 'right_digit':
                    $isWin =
                        isset($bet['digit']) &&
                        (int)$bet['digit'] === $closeDigit;
                    break;
            }

            // 🔓 release frozen balance
            $wallet->decrement('frozen_balance', $bid->amount);

            if ($isWin) {

                $winAmount = $bid->amount * $bid->gameType->payout_rate;

                // 💰 update wallet first
                $wallet->increment('balance', $winAmount);
                    $wallet->refresh(); // ← ensure we have latest balance for transaction record
    
                    // ✅ update bid status

                $bid->update([
                    'status' => 'won',
                    'winning_amount' => $winAmount,
                    'result_id' => $result->id,
                ]);

                sendNotification(
                    $bid->user_id,
                    '🎉 You Won!',
                    "You won ₹{$winAmount} in {$bid->gameType->name} (Jodi {$jodi}).",
                    'bet'
                );

                WalletTransactions::create([
                    'wallet_id' => $wallet->id,
                    'amount' => $winAmount,
                    'type' => 'credit',
                    'source' => 'galidisawar_win', // ⚠️ keep short (DB limit issue)
                    'reason' => "Win for bid {$bid->id}",
                    'reference_id' => $bid->id,
                    'balance_after' => $wallet->balance,
                    'transaction_code' => 'GD-' . strtoupper(uniqid()),
                ]);

            } else {

                $bid->update([
                    'status' => 'lost',
                    'winning_amount' => 0,
                    'result_id' => $result->id,
                ]);

                sendNotification(
                    $bid->user_id,
                    '❌ You Lost',
                    "You lost ₹{$bid->amount} in {$bid->gameType->name} (Jodi {$jodi}).",
                    'bet'
                );
            }
        }



        // 🏁 mark declared
       $result->declared_at = now();
$result->status = 'declared';
$result->save();
    });

    return response()->json([
        'message' => 'Gali Disawar winners declared successfully',
    ]);
}

   public function winners($resultId)
{
    $result = GaliDisawarResult::with('gali')->findOrFail($resultId);

    // 🎯 Extract values from result
    $jodi = $result->result_jodi;

    if (!$jodi || strlen($jodi) !== 2) {
        return response()->json([
            'error' => 'Invalid result jodi'
        ], 400);
    }

    $openDigit  = (int) $jodi[0];
    $closeDigit = (int) $jodi[1];

    // 📥 Get bids
    $bids = GaliDisawarBid::with(['user', 'gameType'])
        ->where('gali_id', $result->gali_id)
        ->whereDate('draw_date', $result->draw_date)
        ->where('status', 'pending')
        ->get();
        

    $winners = [];
    $losers  = [];

    foreach ($bids as $bid) {

        $bet = is_array($bid->bet_data)
            ? $bid->bet_data
            : json_decode($bid->bet_data, true);

        $isWinner = false;

        switch ($bid->gameType->slug) {

            case 'single_digit':
                // ⚠️ both digits allowed (or change based on your rule)
                $isWinner =
                    isset($bet['digit']) &&
                    (
                        (int)$bet['digit'] === $openDigit ||
                        (int)$bet['digit'] === $closeDigit
                    );
                break;

            case 'jodi_digit':
                $isWinner =
                    isset($bet['digit']) &&
                    $bet['digit'] === $jodi;
                break;

            case 'left_digit':
                $isWinner =
                    isset($bet['digit']) &&
                    (int)$bet['digit'] === $openDigit;
                break;

            case 'right_digit':
                $isWinner =
                    isset($bet['digit']) &&
                    (int)$bet['digit'] === $closeDigit;
                break;
        }

        if ($isWinner) {

            $winningAmount = $bid->amount * $bid->gameType->payout_rate;

            $winners[] = [
                'user_id' => $bid->user->id,
                'name' => $bid->user->name,
                'amount' => $bid->amount,
                'winning_amount' => $winningAmount,
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
        'total_bid' => $bids->sum('amount'),
        'total_win' => collect($winners)->sum('winning_amount'),
    ]);
}

    public function result_history()
    {
        $results   = GaliDisawarResult::with('gali')->orderBy('draw_date','desc')->get();
        $declared  = $results->where('status','declared')->count();
        $draft     = $results->where('status','draft')->count();
        $thisMonth = $results->where('draw_date','>=', now()->startOfMonth())->count();
        return view('admin.gali_disawar.result_history', compact('results','declared','draft','thisMonth'));
    }

    public function sell_report()
    {
        $games = GaliDisawarGame::where('game_status',1)->get();
        return view('admin.gali_disawar.sell_report', compact('games'));
    }

    public function sell_report_filter(\Illuminate\Http\Request $request)
    {
        $request->validate(['date' => 'required|date']);
        $query = GaliDisawarBid::with('galiDisawar')
            ->whereDate('bid_date', $request->date);
        if ($request->filled('game_id')) $query->where('gali_id', $request->game_id);
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
        $games = GaliDisawarGame::where('game_status',1)->get();
        return view('admin.gali_disawar.winning_report', compact('games'));
    }

    public function winning_report_filter(\Illuminate\Http\Request $request)
    {
        $request->validate(['date' => 'required|date']);
        $query = GaliDisawarBid::with('user','galiDisawar')
            ->where('status','won')->whereDate('bid_date', $request->date);
        if ($request->filled('game_id')) $query->where('gali_id', $request->game_id);
        $bids = $query->orderBy('winning_amount','desc')->get();
        return response()->json(['status' => true, 'data' => $bids, 'total_win' => $bids->sum('winning_amount')]);
    }

    public function winning_prediction()
    {
         $games = GaliDisawarGame::where('game_status', 1)->get();
        return view('admin.gali_disawar.winning_prediction', compact('games'));
    }

    public function searchWinningPredictions(Request $request)
    {
        $request->validate([
            'date'    => 'required|date',
            'gali_id' => 'required|integer|exists:gali_disawar_games,id',
            'digit'   => 'nullable|integer|min:0|max:9',
            'jodi'    => 'nullable|string|size:2',
        ]);

        $query = GaliDisawarBid::with(['user', 'gali','gameType'])
            ->forDate($request->date)
            ->where('gali_id', $request->gali_id);

        

        /* -----------------------------
           DIGIT FILTER
        ----------------------------- */
        if ($request->filled('digit')) {
            $digit = (int) $request->digit;

            $query->where(function ($q) use ($digit) {
                $q->whereJsonContains('bet_data->digit', $digit)
                  ->orWhereJsonContains('bet_data->left_digit', $digit)
                  ->orWhereJsonContains('bet_data->right_digit', $digit);
            });
        }

        /* -----------------------------
           JODI FILTER
        ----------------------------- */
        if ($request->filled('jodi')) {
            $jodi = $request->jodi;

            $query->where(function ($q) use ($jodi) {
                $q->whereJsonContains('bet_data->jodi', $jodi)
                  ->orWhereJsonContains('bet_data->digit', (int) $jodi[0])
                  ->orWhereJsonContains('bet_data->digit', (int) $jodi[1]);
            });
        }

        $data = $query->get();

        return response()->json([
            'data' => $data,
            'totals' => [
                'total_bid' => $data->sum('amount'),
                'total_win' => $data->sum('winning_amount'),
            ],
        ]);
    }
}
