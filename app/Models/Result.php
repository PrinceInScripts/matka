<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $table = 'results';

    protected $fillable = [
        'market_id',
        'open_panna',
        'open_digit',
        'close_panna',
        'close_digit',
        'status',
        'session',
        'result_date'
    ];

    protected $dates = ['result_date'];

    public function market()
    {
        return $this->belongsTo(GameList::class);
    }
}
