<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StarlineBidHistory extends Model
{
    protected $table = 'starline_bid_history';

    protected $fillable = [
        'user_id',
        'starline_id',
        'game_type_id',
        'txn_id',
         'bet_data',
         'wallet_transaction_id',
        'bet_value',
        'amount',
        'session',
        'status',
        'draw_date',
        'bid_date',
        'winning_amount',
        'result_id',

    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'winning_amount' => 'decimal:2',
        'draw_date' => 'date',
        'bid_date' => 'date',
    ];

    // Relations
    public function starline()
    {
        return $this->belongsTo(StarlineName::class, 'starline_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gameType()
    {
        return $this->belongsTo(StarlineGameType::class, 'game_type_id');
    }

    public function walletTransaction()
    {
        return $this->belongsTo(WalletTransactions::class, 'wallet_transaction_id');
    }

    
}
