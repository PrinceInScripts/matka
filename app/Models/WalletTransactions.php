<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WalletTransactions extends Model
{
     use HasFactory;

    protected $table = 'wallet_transactions';

    protected $fillable = [
        'wallet_id',
        'type',               // credit or debit
        'amount',
        'reason',
        'reference_id',
        'reference_type',     // 'bid', 'fund_request', etc.
        'balance_after',
        'transaction_code',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_after' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        // ✅ Auto-generate a unique transaction code
        static::creating(function ($model) {
            $model->transaction_code = $model->transaction_code ?? 'TXN-' . strtoupper(Str::random(10));
        });
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }
}
