<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GaliDisawarGame extends Model
{
    use SoftDeletes;

    protected $table = 'gali_disawar_games';

    protected $fillable = [
        'name',
        'slug',
        'market_status',
        'game_status',
    ];

    protected $casts = [
        'market_status' => 'boolean',
        'game_status'   => 'boolean',
    ];

    public function bids()
    {
        return $this->hasMany(GaliDisawarBid::class, 'gali_id');
    }

    public function results()
    {
        return $this->hasMany(GaliDisawarResult::class, 'gali_id');
    }

    public function schedule()
    {
        return $this->hasMany(GaliDisawarSchedule::class, 'gali_id');
    }
}
