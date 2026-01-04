<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketSchedule extends Model
{
     protected $table = 'market_schedules';

    protected $fillable = [
        'market_id',
        'weekday',
        'is_open',
        'open_time',
        'close_time',
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'open_time'  => 'datetime:H:i:s',
        'close_time' => 'datetime:H:i:s',
    ];

    // Relations
    public function market()
    {
        return $this->belongsTo(GameList::class, 'market_id');
    }
}
