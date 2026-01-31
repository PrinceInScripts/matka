<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaliDisawarSchedule extends Model
{
    protected $table = 'gali_disawar_schedule';

    protected $fillable = [
        'gali_id',
        'weekday',
        'is_open',
        'open_time',
        'close_time',
    ];

    protected $casts = [
        'is_open' => 'boolean',
    ];

    public function gali()
    {
        return $this->belongsTo(GaliDisawarGame::class, 'gali_id');
    }
}
