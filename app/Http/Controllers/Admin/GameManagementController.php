<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameManagementController extends Controller
{
    public function gameNames()
    {
        $today = strtolower(now()->format('D')); // mon, tue, wed...

    $markets = DB::table('gamelists')
        ->leftJoin('market_schedules', function ($join) use ($today) {
            $join->on('gamelists.id', '=', 'market_schedules.market_id')
                 ->where('market_schedules.weekday', $today);
        })
        ->select(
            'gamelists.id',
            'gamelists.name',
            'gamelists.slug',
            'gamelists.game_status',
            'market_schedules.is_open',
            'market_schedules.open_time',
            'market_schedules.close_time'
        )
        ->get()
        ->map(function ($market) {
            $now = now()->format('H:i:s');

            if (!$market->is_open) {
                $market->status_text = 'Close Today';
                $market->status_color = 'danger';
            } elseif ($now < $market->open_time) {
                $market->status_text = 'Not Opened Yet';
                $market->status_color = 'warning';
            } elseif ($now > $market->close_time) {
                $market->status_text = 'Closed';
                $market->status_color = 'danger';
            } else {
                $market->status_text = 'Open Today';
                $market->status_color = 'success';
            }

            $market->open_time_format = date('h:i A', strtotime($market->open_time));
            $market->close_time_format = date('h:i A', strtotime($market->close_time));

            return $market;
        });

         $weekSchedules = DB::table('market_schedules')
            ->where('market_id', $markets->first()->id ?? null)
            ->get();


    return view('admin.games.game_names', compact('markets', 'weekSchedules'));
    }

     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $game_id = DB::table('gamelists')->insertGetId([
            'name' => $request->name,
            'name_hindi' => $request->name_hindi,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
            'market_type' => 'main',
            'game_status' => 1,
            'created_at' => now()
        ]);

        $week = ['mon','tue','wed','thu','fri','sat','sun'];
        foreach ($week as $d) {
            DB::table('market_schedules')->insert([
                'market_id' => $game_id,
                'weekday' => $d,
                'is_open' => 0,
                'open_time' => null,
                'close_time' => null,
                'created_at' => now()
            ]);
        }

        return redirect()->back()->with('success', 'Game Added!');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        DB::table('gamelists')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'name_hindi' => $request->name_hindi,
                'updated_at' => now()
            ]);

        return redirect()->back()->with('success', 'Game Updated!');
    }


    public function updateSchedule(Request $request, $id)
    {
        if (!$request->weekday) return redirect()->back();

        foreach ($request->weekday as $i => $day) {

            $isOpen = isset($request->is_open[$i]) ? 1 : 0;

            DB::table('market_schedules')
                ->where('market_id', $id)
                ->where('weekday', $day)
                ->update([
                    'is_open' => $isOpen,
                    'open_time' => $isOpen ? $request->open_time[$i] : null,
                    'close_time' => $isOpen ? $request->close_time[$i] : null,
                    'updated_at' => now()
                ]);
        }

        return redirect()->back()->with('success', 'Schedule Updated!');
    }

    

}
