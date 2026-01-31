<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaliDisawarType extends Model
{
    protected $table = 'gali_disawar_types';

    protected $fillable = [
        'name',
        'slug',
        'payout_rate',
        'description',
        'total_combinations',
        'handle_type',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'payout_rate' => 'decimal:2',
        'status'      => 'boolean',
    ];

    public function markets()
    {
        return $this->belongsToMany(
            GaliDisawarGame::class,
            'gali_disawar_gametypes',
            'game_type_id',
            'gali_id'
        );
    }
}
