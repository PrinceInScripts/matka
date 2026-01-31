<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaliDisawarGameType extends Model
{
    protected $table = 'gali_disawar_gametypes';

    protected $fillable = [
        'gali_id',
        'game_type_id',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
