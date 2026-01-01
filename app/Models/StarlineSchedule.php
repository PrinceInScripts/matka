<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StarlineSchedule extends Model
{
    protected $table = 'starline_schedule';

    protected $fillable = [
        'starline_id',
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
    public function starline()
    {
        return $this->belongsTo(StarlineName::class, 'starline_id');
    }
}
