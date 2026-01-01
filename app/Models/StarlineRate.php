<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StarlineRate extends Model
{
    protected $table = 'starline_rates';

    protected $fillable = [
        'game_type',
        'payout_rate',
        'status',
    ];

    protected $casts = [
        'payout_rate' => 'decimal:2',
        'status'      => 'boolean',
    ];
}
