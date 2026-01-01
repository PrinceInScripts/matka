<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameType extends Model
{
    use HasFactory;

    protected $table = 'gametypes';

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

    // Relationships
    public function markets()
    {
        return $this->belongsToMany(GameList::class, 'market_gameTypes', 'game_type_id', 'market_id')
                    ->withPivot('is_active')
                    ->withTimestamps();
    }

    public function starline()
    {
        return $this->belongsToMany(StarlineName::class, 'starline_gametypes', 'game_type_id', 'market_id')
                    ->withPivot('is_active')
                    ->withTimestamps();
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

}
