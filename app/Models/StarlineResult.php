<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StarlineResult extends Model
{
    protected $fillable = [
        'starline_id','result_digit','result_pana','draw_date','status'
    ];

     protected $casts = [
        'draw_date'      => 'date',
    ];

    public function starline()
    {
        return $this->belongsTo(StarlineName::class, 'starline_id');
    }
}
