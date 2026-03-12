<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaliDisawarBid extends Model
{
    protected $table = 'gali_disawar_bids';

    protected $fillable = [
        'user_id',
        'gali_id',
        'game_type_id',
        'txn_id',
        'bet_data',
        'wallet_transaction_id',
        'bet_value',
        'amount',
        'status',
        'draw_date',
        'bid_date',
        'winning_amount',
        'result_id',
        'session'
    ];

    protected $casts = [
        'bet_data'       => 'array',
        'draw_date'      => 'date',
        'bid_date'       => 'date',
        'amount'         => 'decimal:2',
        'winning_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function gameType()
    {
        return $this->belongsTo(GaliDisawarType::class, 'game_type_id');
    }

    public function gali()
    {
        return $this->belongsTo(GaliDisawarGame::class, 'gali_id');
    }

    public function result()
    {
        return $this->belongsTo(GaliDisawarResult::class, 'result_id');
    }

   

    /* ---------- Scopes (USE THESE) ---------- */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('draw_date', $date);
    }
}
