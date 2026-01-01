<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class StarlineGameType extends Model
{
    use HasFactory;

    protected $table = 'starline_gametypes';

    protected $fillable = [
        'market_id',
        'game_type_id',
        'is_active'
    ];

    public function market()
    {
        return $this->belongsTo(StarlineName::class, 'market_id');
    }

    public function gameType()
    {
        return $this->belongsTo(GameType::class);
    }
}
