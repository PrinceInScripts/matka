<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StarlineGamesType extends Model
{
    use HasFactory;

    protected $table = 'starline_gamestype';

    protected $fillable = [
        'name',
        'slug',
        'payout_rate',
        'status',
        'handle_type',
        'sort_order'
    ];

    protected $casts = [
        'payout_rate' => 'decimal:2',
    ];

    public function starline()
    {
        return $this->belongsToMany(StarlineName::class, 'starline_gametypes', 'game_type_id', 'market_id')
                    ->withPivot('is_active')
                    ->withTimestamps();
    }

    public function bids()
    {
        return $this->hasMany(StarlineBidHistory::class);
    }
}
