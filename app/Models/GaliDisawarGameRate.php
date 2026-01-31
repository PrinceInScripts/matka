<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaliDisawarGameRate extends Model
{
    protected $table = 'gali_disawar_game_rates';

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
    