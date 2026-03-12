<?php

namespace App\Http\Controllers;

use App\Models\GaliDisawarGame;
use App\Models\GaliDisawarGameType;
use App\Models\GaliDisawarType;
use App\Models\GameList;
use Illuminate\Http\Request;
use App\Services\GameNumberService;
use App\Models\Market;
use App\Models\GameType;
use App\Models\StarlineGameType;
use App\Models\StarlineName;
use Illuminate\Support\Facades\DB;

class GameLayoutController extends Controller
 {
    private function resolveDigitsLimitBySlug( string $slug ): int
 {
        return match ( $slug ) {
            // Single digit games
            'single_digit',
            'left_digit',
            'right_digit'
            => 1,

            // Jodi
            'jodi',
            'jodi_digit'
            => 2,

            // Panna
            'single_panna',
            'double_panna',
            'triple_panna'
            => 3,

            // Sangam
            'half_sangam'
            => 4,

            'full_sangam'
            => 6,

            // Bulk / fallback
            default
            => 100,
        }
        ;
    }

    public function getGameLayout( $game_type, $marketSlug, $gameCode )
 {

        if ( $game_type === 'starline' ) {
            $market = StarlineName::where( 'slug', $marketSlug )->firstOrFail();
        } elseif ( $game_type === 'gali_disawar' ) {
            $market = GaliDisawarGame::where( 'slug', $marketSlug )->firstOrFail();
        } else {
            $market = GameList::where( 'slug', $marketSlug )->firstOrFail();
        }

        

        if ( $game_type === 'gali_disawar' ) {
            $gameType = GaliDisawarType::where('slug', $gameCode)
            ->where( 'status', 1 )
            ->get();
        } elseif ( $game_type === 'starline' ) {
            $gameType=StarlineGameType::where('slug', $gameCode)->get();
        } else {
            $gameType=GameType::where('slug', $gameCode)->get();
        }

        // return response()->json( [
        //     'market' => $market,
        //     'gameType' => $gameType,
        //     'game_type' => $game_type,
        // ] );
        $gameType = $gameType->first();


        // Allowed number combinations for this game type
        $numbers = GameNumberService::getCombinations( $gameType->slug, $game_type );

        $layout = match ( $gameType->handle_type ) {
            'single', 'double', 'triple' => 'single',
            'fifth'  => 'halfsangam',
            'six'    => 'fullsangam',
            default  => 'bulk',
        }
        ;

        // 5️⃣ Digit limit ( RULES via slug )
        // -------------------------
        $digitsLimit = $this->resolveDigitsLimitBySlug( $gameType->slug );

        // return response()->json( [

        //     'game' => $market,
        //     'gameType' => $gameType,
        //     'numbers' => $numbers,
        //     'digitsLimit' => $digitsLimit,
        //     'game_type' => $game_type,

        // ] );
        

        return view( "games.$layout", [
            'game' => $market,
            'gameType' => $gameType,
            'numbers' => $numbers,
            'digitsLimit' => $digitsLimit,
            'game_type' => $game_type,
        ] );
    }

    public function getGameData( $marketId, $gameCode )
 {
        $market = GameList::where( 'slug', $marketId )->firstOrFail();
        $gameType = GameType::where( 'slug', $gameCode )->firstOrFail();

        // Allowed number combinations for this game type
        $numbers = GameNumberService::getCombinations( $gameCode );

        if ( $market->slug == 'single_digit' || $market->slug == 'jodi' || $market->slug == 'single_panna' || $market->slug == 'double_panna' || $market->slug == 'triple_panna' ) {
            $layout = 'single';
        } else if ( $market->slug == 'half_sangam' ) {
            $layout = 'half-sangam';
        } else if ( $market->slug == 'full_sangam' ) {
            $layout = 'full-sangam';
        } else {
            $layout = 'bulk';
        }

        return response()->json( [
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
        ] );
    }
}
