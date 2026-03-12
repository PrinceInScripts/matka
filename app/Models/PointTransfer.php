<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PointTransfer extends Model
{
    protected $table = 'point_transfers';
    protected $fillable = ['sender_id','receiver_id','amount','note','status','sender_wallet_txn_id','receiver_wallet_txn_id'];
    protected $casts = ['amount'=>'decimal:2'];
    public function sender()   { return $this->belongsTo(User::class, 'sender_id'); }
    public function receiver() { return $this->belongsTo(User::class, 'receiver_id'); }
}
