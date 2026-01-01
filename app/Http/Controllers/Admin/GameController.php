<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameList;
use App\Models\GameRate;
use Carbon\Carbon;
use GMP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GameController extends Controller
{
    public function names()
    {
        $today = strtolower(now()->format('D')); // mon, tue...

    // preload today schedules
    $schedules = DB::table('market_schedules')
        ->where('weekday', $today)
        ->get()
        ->keyBy('market_id');

    $markets = GameList::where('market_type', 'main')->get()->map(function ($market) use ($schedules) {

        $schedule = $schedules->get($market->id);

        $market->today_open_time  = $schedule->open_time ?? null;
        $market->today_close_time = $schedule->close_time ?? null;
        $market->today_is_open    = $schedule->is_open ?? 0;

        $now = now();

        /** -------------------------
         * STATUS PRIORITY (IMPORTANT)
         * --------------------------
         * 1. game_status (disabled)
         * 2. market_status (admin closed)
         * 3. today_is_open (off day)
         * 4. time window
         */

        if (!$market->game_status) {
            $market->status_text  = 'Disabled';
            $market->status_color = 'secondary';
            $market->is_live      = false;
        }
        elseif (!$market->market_status) {
            $market->status_text  = 'Closed by Admin';
            $market->status_color = 'danger';
            $market->is_live      = false;
        }
        elseif (!$market->today_is_open) {
            $market->status_text  = 'Closed Today';
            $market->status_color = 'danger';
            $market->is_live      = false;
        }
       else {

    // if time is missing, treat as closed
    if (empty($market->today_open_time) || empty($market->today_close_time)) {
        $market->status_text  = 'Time Not Set';
        $market->status_color = 'secondary';
        $market->is_live      = false;
    } 
    else {
        $open  = now()->setTimeFromTimeString($market->today_open_time);
        $close = now()->setTimeFromTimeString($market->today_close_time);

        if ($now->lt($open)) {
            $market->status_text  = 'Not Opened Yet';
            $market->status_color = 'warning';
            $market->is_live      = false;
        }
        elseif ($now->gt($close)) {
            $market->status_text  = 'Closed';
            $market->status_color = 'danger';
            $market->is_live      = false;
        }
        else {
            $market->status_text  = 'Open Now';
            $market->status_color = 'success';
            $market->is_live      = true;
        }
    }
}


        $market->open_time_format = $market->today_open_time
            ? date('h:i A', strtotime($market->today_open_time))
            : '--';

        $market->close_time_format = $market->today_close_time
            ? date('h:i A', strtotime($market->today_close_time))
            : '--';

        return $market;
    });

        // return $markets;


        return view('admin.games.names', compact('markets'));
    }

    public function getSchedule($marketId)
{
    $data = DB::table('market_schedules')
        ->where('market_id', $marketId)
        ->orderByRaw("FIELD(weekday, 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun')")
        ->get();

    return response()->json($data);
}

    public function rates()
    {
        $rates = GameRate::first(); 
        return view('admin.games.rates', compact('rates'));
    }

    public function updateRates(Request $request)
{
    $validated = $request->validate([
        'single_digit_1' => 'required|numeric',
        'single_digit_2' => 'required|numeric',
        'jodi_digit_1'   => 'required|numeric',
        'jodi_digit_2'   => 'required|numeric',
        'single_pana_1'  => 'required|numeric',
        'single_pana_2'  => 'required|numeric',
        'double_pana_1'  => 'required|numeric',
        'double_pana_2'  => 'required|numeric',
        'triple_pana_1'  => 'required|numeric',
        'triple_pana_2'  => 'required|numeric',
        'half_sangam_1'  => 'required|numeric',
        'half_sangam_2'  => 'required|numeric',
        'full_sangam_1'  => 'required|numeric',
        'full_sangam_2'  => 'required|numeric',
    ]);

    $rate = GameRate::first();

    if ($rate) {
        $rate->update($validated);
    } else {
        GameRate::create($validated);
    }

    return back()->with('success', 'Game rates updated successfully.');
}


    public function store(Request $request)
{
    $validated = $request->validate([
        'name'         => 'required|string|max:255',
        'open_time'    => 'required',
        'close_time'   => 'required',
        'game_status'  => 'required|boolean',
        'market_status'=> 'required|boolean',
    ]);

    $openTime  = Carbon::parse($validated['open_time']);
    $closeTime = Carbon::parse($validated['close_time']);

    if ($openTime->greaterThanOrEqualTo($closeTime)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Open time must be earlier than close time.'
        ], 422);
    }

    if (GameList::whereRaw('LOWER(name) = ?', [strtolower($validated['name'])])->exists()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Market with this name already exists!'
        ], 409);
    }

    DB::beginTransaction();

    try {

        $market = GameList::create([
            'name'          => strtoupper($validated['name']),
            'slug'          => Str::slug($validated['name']),
            'market_type'   => 'main',
            'market_status' => $validated['market_status'],
            'game_status'   => $validated['game_status'],
        ]);

        // enable all game types
        for ($i = 1; $i <= 12; $i++) {
            DB::table('market_gametypes')->insert([
                'market_id' => $market->id,
                'game_type_id' => $i,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // create schedule for all 7 days
        foreach (['mon','tue','wed','thu','fri','sat','sun'] as $day) {
            DB::table('market_schedules')->insert([
                'market_id' => $market->id,
                'weekday'   => $day,
                'is_open'   => 1,
                'open_time' => $validated['open_time'],
                'close_time'=> $validated['close_time'],
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Game Market Created Successfully!'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}


  public function update_schedule(Request $request, $marketId)
{
    foreach ($request->weekday as $i => $day) {

        $isOpen = isset($request->is_open[$i]) ? 1 : 0;

        // Always define vars to avoid undefined variable issues
        $open  = $request->open_time[$i] ?? null;
        $close = $request->close_time[$i] ?? null;

        // Validate only if day is open
        if ($isOpen) {

            if (!$open || !$close) {
                return response()->json([
                    'status' => 'error',
                    'message' => strtoupper($day) . ': Open & Close time required.'
                ], 422);
            }

            if (Carbon::parse($open)->greaterThanOrEqualTo(Carbon::parse($close))) {
                return response()->json([
                    'status' => 'error',
                    'message' => strtoupper($day) . ': Opening time must be earlier than closing time.'
                ], 422);
            }
        }

        DB::table('market_schedules')
            ->where('market_id', $marketId)
            ->where('weekday', $day)
            ->update([
                'is_open'    => $isOpen,
                'open_time'  => $isOpen ? $open : null,
                'close_time' => $isOpen ? $close : null,
                'updated_at' => now(),
            ]);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Schedule updated successfully.'
    ]);
}


public function updateNames(Request $request, $id)
{
    $market = GameList::findOrFail($id);

    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'open_time'     => 'required',
        'close_time'    => 'required',
        'game_status'   => 'required|boolean',
        'market_status' => 'required|boolean',
    ]);

    $openTime  = Carbon::parse($validated['open_time']);
    $closeTime = Carbon::parse($validated['close_time']);

    if ($openTime->greaterThanOrEqualTo($closeTime)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Open time must be earlier than close time.'
        ], 422);
    }

    DB::beginTransaction();

    try {

        // 1️⃣ Update main market flags
        $market->update([
            'name'          => strtoupper($validated['name']),
            'slug'          => Str::slug($validated['name']),
            'game_status'   => $validated['game_status'],
            'market_status' => $validated['market_status'],
        ]);

        // 2️⃣ Apply time to all 7 days
        DB::table('market_schedules')
            ->where('market_id', $market->id)
            ->update([
                'open_time'  => $validated['open_time'],
                'close_time' => $validated['close_time'],
                'updated_at' => now(),
            ]);

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Game, admin status, and schedule updated successfully.'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}


public function getGameTypes($id)
{
    $market = GameList::findOrFail($id);

    $types = DB::table('gametypes')
        ->leftJoin('market_gametypes', function ($join) use ($id) {
            $join->on('gametypes.id', '=', 'market_gametypes.game_type_id')
                 ->where('market_gametypes.market_id', $id);
        })
        ->select(
            'gametypes.id',
            'gametypes.name',
            'gametypes.slug',
            'gametypes.color',
            DB::raw('IFNULL(market_gametypes.is_active, 0) as is_active')
        )
        ->orderBy('gametypes.sort_order')
        ->get();

    return response()->json([
        'market_id' => $market->id,
        'market_name' => $market->name,
        'types' => $types
    ]);
}
public function updateGameTypes(Request $request, $id)
{
    $market = GameList::findOrFail($id);

    $activeTypes = $request->input('game_types', []); // array of IDs

    DB::beginTransaction();

    try {
        // Disable all first
        DB::table('market_gametypes')
            ->where('market_id', $id)
            ->update(['is_active' => 0]);

        // Enable selected
        if (!empty($activeTypes)) {
            DB::table('market_gametypes')
                ->where('market_id', $id)
                ->whereIn('game_type_id', $activeTypes)
                ->update(['is_active' => 1]);
        }

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Game types updated successfully'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}


}
