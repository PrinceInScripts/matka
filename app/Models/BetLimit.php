<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BetLimit extends Model
{
    protected $fillable = [
        'game_type_id','market_id','min_bet','max_bet','max_daily_bet'
    ];

    public function market()
    {
        return $this->belongsTo(Gamelist::class, 'market_id');
    }

    public function gameType()
    {
        return $this->belongsTo(Gametype::class, 'game_type_id');
    }
}
