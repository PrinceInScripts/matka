<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameList;
use App\Models\StarlineName;
use App\Models\StarlineRate;
use App\Models\StarlineSchedule;
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
    $rates = StarlineRate::all()->keyBy('game_type');
        // return $rates;
        return view('admin.starline.rates', compact('rates'));
    }

   
    public function update_rates(Request $request)
{
    // return $request;
    $request->validate([
        'rates' => 'required|array',
    ]);

    foreach ($request->rates as $gameType => $payout) {
        StarlineRate::where('game_type', $gameType)
            ->update([
                'payout_rate' => $payout,
                'status' => true,
            ]);
    }

    return response()->json([
        'status'  => 'success',
        'message' => 'Starline Rates updated successfully',
    ]);
}


    public function bid_history()
    {
        return view('admin.starline.bid_history');
    }

    public function declare_result()
    {
        return view('admin.starline.declare_result');
    }

    public function result_history()
    {
        return view('admin.starline.result_history');
    }


    public function sell_report()
    {
        return view('admin.starline.sell_report');
    }

    public function winning_report()
    {
        return view('admin.starline.winning_report');
    }

    public function winning_prediction()
    {
        return view('admin.starline.winning_prediction');
    }
}
