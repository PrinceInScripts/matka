<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StarlineResultHistory extends Model
{
    protected $table = 'starline_result_history';

    protected $fillable = [
        'starline_id',
        'result_date',
        'result_value',
        'declared_at',
    ];

    protected $casts = [
        'result_date' => 'date',
        'declared_at' => 'datetime',
    ];

    // Relations
    public function starline()
    {
        return $this->belongsTo(StarlineName::class, 'starline_id');
    }
}
