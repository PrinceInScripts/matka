<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameList extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gamelists';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'open_pana',
        'close_pana',
        'open_digit',
        'close_digit',
        'single_panna',
    'single_digit',
    'market_type',
        'market_status',
        'game_status',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'open_time' => 'datetime:H:i:s',
        'close_time' => 'datetime:H:i:s',
        'market_status' => 'boolean',
        'game_status' => 'boolean',
    ];

    /**
     * Scope to get only active games.
     */
    public function scopeActive($query)
    {
        return $query->where('game_status', 1);
    }

    /**
     * Scope to get only open markets.
     */
    public function scopeOpen($query)
    {
        return $query->where('market_status', 1);
    }

    /**
     * Accessor to format open and close time for UI.
     */
    public function getFormattedOpenTimeAttribute()
{
    if (!$this->open_time || !preg_match('/^\d{2}:\d{2}:\d{2}$/', $this->open_time)) {
        return null; // or return some default string like 'N/A'
    }
    return \Carbon\Carbon::createFromFormat('H:i:s', $this->open_time)->format('h:i A');
}

public function getFormattedCloseTimeAttribute()
{
    if (!$this->close_time || !preg_match('/^\d{2}:\d{2}:\d{2}$/', $this->close_time)) {
        return null;
    }
    return \Carbon\Carbon::createFromFormat('H:i:s', $this->close_time)->format('h:i A');
}

public function gameTypes()
    {
        return $this->belongsToMany(GameType::class, 'market_gametypes', 'market_id', 'game_type_id')
                    ->withPivot('is_active')
                    ->withTimestamps();
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function todaySchedule()
{
    return $this->hasOne(MarketSchedule::class, 'market_id')
        ->where('weekday', now()->format('D'));
}

}
