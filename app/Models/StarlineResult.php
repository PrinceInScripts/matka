<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StarlineResult extends Model
{
    protected $fillable = [
        'market_id','result_digit','result_pana','draw_date'
    ];

    public function market()
    {
        return $this->belongsTo(Gamelist::class, 'market_id');
    }
}
