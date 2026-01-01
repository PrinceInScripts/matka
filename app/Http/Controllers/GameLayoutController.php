<?php

namespace App\Http\Controllers;

use App\Models\GameList;
use Illuminate\Http\Request;
use App\Services\GameNumberService;
use App\Models\Market;
use App\Models\GameType;
use App\Models\StarlineGameType;
use App\Models\StarlineName;

class GameLayoutController extends Controller
{
    public function getGameLayout($game_type, $marketId, $gameCode)
    {
        // Fetch market and game details
        if($game_type=='starline'){
            $market = StarlineName::where('slug', $marketId)->firstOrFail();
        } else {
            $market = GameList::where('slug', $marketId)->firstOrFail();
        }
        // $market = GameList::where('slug', $marketId)->firstOrFail();
        $gameType = GameType::where('slug', $gameCode)->firstOrFail();

        // Allowed number combinations for this game type
        $numbers = GameNumberService::getCombinations($gameCode);

        if($gameType->slug == 'single_digit' || $gameType->slug == 'jodi' || $gameType->slug == 'single_panna' || $gameType->slug == 'double_panna' || $gameType->slug == 'triple_panna'){
            $layout = 'single';
        } else if($gameType->slug == 'half_sangam'){
            $layout = 'halfsangam';
        }else if($gameType->slug == 'full_sangam'){
            $layout = 'fullsangam';
        }
        else {
            $layout = 'bulk';
        }

        if($gameType->slug == 'single_digit') {
            $digitsLimit = 1;
        }else if($gameType->slug == 'jodi') {
            $digitsLimit = 2;
        }else if($gameType->slug == 'single_panna' || $gameType->slug == 'double_panna' || $gameType->slug == 'triple_panna') {
            $digitsLimit = 3;
        }else {
            $digitsLimit = 100;
        }

        // return response()->json([
           
        //         'game' => $market,
        //         'gameType' => $gameType,
        //         'numbers' => $numbers,
        //         'digitsLimit' => $digitsLimit,
           
        // ]);


        return view("games.$layout", [
            'game' => $market,
            'gameType' => $gameType,
            'numbers' => $numbers,
            'digitsLimit' => $digitsLimit,
            'game_type' => $game_type,
        ]);
    }

    public function getGameData($marketId, $gameCode)
    {
        $market = GameList::where('slug', $marketId)->firstOrFail();
        $gameType = GameType::where('slug', $gameCode)->firstOrFail();

        // Allowed number combinations for this game type
        $numbers = GameNumberService::getCombinations($gameCode);

        if($market->slug == 'single_digit' || $market->slug == 'jodi' || $market->slug == 'single_panna' || $market->slug == 'double_panna' || $market->slug == 'triple_panna'){
            $layout = 'single';
        } else if($market->slug == 'half_sangam'){
            $layout = 'half-sangam';
        } else if($market->slug == 'full_sangam'){
            $layout = 'full-sangam';
        }else {
            $layout = 'bulk';
        }



        return response()->json([
            'market' => [
                'id' => $market->id,
                'name' => $market->name,
                'status' => $market->is_open ? 'open' : 'closed',
                'open_time' => $market->open_time,
                'close_time' => $market->close_time,
            ],
            'game_type' => [
                'code' => $gameType->code,
                'name' => $gameType->name,
                'description' => $gameType->description,
                'min_bid' => $gameType->min_bid ?? 10,
                'max_bid' => $gameType->max_bid ?? 10000,
            ],
            'numbers' => $numbers,
        ]);
    }
}
