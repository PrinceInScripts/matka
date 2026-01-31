<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaliDisawarResultHistory extends Model
{
    protected $table = 'gali_disawar_result_history';

    protected $fillable = [
        'gali_id',
        'result_date',
        'result_value',
        'declared_at',
    ];

    protected $casts = [
        'result_date' => 'date',
        'declared_at' => 'datetime',
    ];
}
