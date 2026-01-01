<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StarlineBidHistory extends Model
{
    protected $table = 'starline_bid_history';

    protected $fillable = [
        'user_id',
        'starline_id',
        'game_type',
        'bet_value',
        'amount',
        'bid_date',
    ];

    protected $casts = [
        'amount'   => 'decimal:2',
        'bid_date' => 'date',
    ];

    // Relations
    public function starline()
    {
        return $this->belongsTo(StarlineName::class, 'starline_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
