<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketGameType extends Model
{
    use HasFactory;

    protected $table = 'market_gametypes';

    protected $fillable = [
        'market_id',
        'game_type_id',
        'is_active'
    ];

    public function market()
    {
        return $this->belongsTo(GameList::class);
    }

    public function gameType()
    {
        return $this->belongsTo(GameType::class);
    }
}
