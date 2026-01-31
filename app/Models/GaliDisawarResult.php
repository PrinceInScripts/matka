<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaliDisawarResult extends Model
{
    protected $table = 'gali_disawar_results';

    protected $fillable = [
        'gali_id',
        'result_digit',
        'result_jodi',
        'result_panna',
        'draw_date',
        'declared_at',
    ];

    protected $casts = [
        'draw_date'   => 'date',
        'declared_at' => 'datetime',
    ];

    public function gali()
    {
        return $this->belongsTo(GaliDisawarGame::class, 'gali_id');
    }

    public function bids()
    {
        return $this->hasMany(GaliDisawarBid::class, 'result_id');
    }
}
    