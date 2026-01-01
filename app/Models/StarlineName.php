<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StarlineName extends Model
{
    use SoftDeletes;

    protected $table = 'starline_names';

    protected $fillable = [
        'name',
        'slug',
        'market_status',
        'game_status',
    ];

    protected $casts = [
        'market_status' => 'boolean',
        'game_status'   => 'boolean',
    ];

    public function getIsOpenNowAttribute(): bool
{
    if ($this->market_status != 1 || $this->game_status != 1) {
        return false;
    }

    $now = Carbon::now()->format('H:i:s');

    return $now >= $this->open_time && $now <= $this->close_time;
}

    // Relations
    public function schedules()
    {
        return $this->hasMany(StarlineSchedule::class, 'starline_id');
    }

    public function bids()
    {
        return $this->hasMany(StarlineBidHistory::class, 'starline_id');
    }

    public function results()
    {
        return $this->hasMany(StarlineResultHistory::class, 'starline_id');
    }

    public function getOpenTimeFormatAttribute()
{
    if (!$this->today_open_time) {
        return "hvhvhv";
    }

    return \Carbon\Carbon::parse($this->today_open_time)->format('h:i A');
}


public function getCloseTimeFormatAttribute()
{
    if (empty($this->today_close_time)) {
        return null; // or '--:--'
    }

    try {
        return \Carbon\Carbon::createFromFormat('H:i:s', $this->today_close_time)
            ->format('h:i A');
    } catch (\Exception $e) {
        return null;
    }
}

public function gameTypes()
    {
        return $this->belongsToMany(GameType::class, 'starline_gametypes', 'market_id', 'game_type_id')
                    ->withPivot('is_active')
                    ->withTimestamps();
    }

    
}
