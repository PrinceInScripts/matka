<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\GameList;
use App\Constants\GameTypes;
use Illuminate\Http\Request;

class GameNumberController extends Controller
{
    private function gameNumberPage(string $view, int $gameTypeId)
    {
        $games = GameList::where('game_status', 1)->where('market_type', 'main')->get();
        $bids  = Bid::with('user', 'market', 'gameType')
            ->where('game_type_id', $gameTypeId)
            ->orderBy('created_at', 'desc')
            ->limit(200)
            ->get();
        return view($view, compact('games', 'bids'));
    }

    public function single_digit()  { return $this->gameNumberPage('admin.game_numbers.single_digit',  GameTypes::SINGLE_DIGIT); }
    public function jodi_digit()    { return $this->gameNumberPage('admin.game_numbers.jodi_digit',    GameTypes::JODI_DIGIT); }
    public function single_panna()  { return $this->gameNumberPage('admin.game_numbers.single_panna',  GameTypes::SINGLE_PANNA); }
    public function double_panna()  { return $this->gameNumberPage('admin.game_numbers.double_panna',  GameTypes::DOUBLE_PANNA); }
    public function triple_panna()  { return $this->gameNumberPage('admin.game_numbers.triple_panna',  GameTypes::TRIPLE_PANNA); }
    public function half_sangam()   { return $this->gameNumberPage('admin.game_numbers.half_sangam',   GameTypes::HALF_SANGAM); }
    public function full_sangam()   { return $this->gameNumberPage('admin.game_numbers.full_sangam',   GameTypes::FULL_SANGAM); }

    // Old route name aliases (single_pana etc)
    public function single_pana()   { return $this->single_panna(); }
    public function double_pana()   { return $this->double_panna(); }
    public function triple_pana()   { return $this->triple_panna(); }
}
