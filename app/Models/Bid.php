<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $table = 'bids';

    protected $fillable = [
        'user_id',
        'market_id',
        'game_type_id',
        'wallet_transaction_id',
        'market_type',
        'number',
        'ank',
        'amount',
        'session',
        'status',
        'draw_date',
        'winning_amount',
        'result_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'winning_amount' => 'decimal:2',
        'draw_date' => 'date',
    ];

    // 🔗 Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function market()
    {
        return $this->belongsTo(GameList::class, 'market_id');
    }

    public function gameType()
    {
        return $this->belongsTo(GameType::class, 'game_type_id');
    }

    public function walletTransaction()
    {
        return $this->belongsTo(WalletTransactions::class, 'wallet_transaction_id');
    }
}
