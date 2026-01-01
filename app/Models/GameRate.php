<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameRate extends Model
{
    protected $table = 'game_rates';

    protected $fillable = [
        'single_digit_1',
        'single_digit_2',
        'jodi_digit_1',
        'jodi_digit_2',
        'single_pana_1',
        'single_pana_2',
        'double_pana_1',
        'double_pana_2',
        'triple_pana_1',
        'triple_pana_2',
        'half_sangam_1',
        'half_sangam_2',
        'full_sangam_1',
        'full_sangam_2',
    ];
}
