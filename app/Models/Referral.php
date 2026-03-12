<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Referral extends Model
{
    protected $table = 'referrals';
    protected $fillable = ['referrer_id','referred_id','referral_code','referrer_bonus','referred_bonus','status','paid_at'];
    protected $casts = ['referrer_bonus'=>'decimal:2','referred_bonus'=>'decimal:2','paid_at'=>'datetime'];
    public function referrer() { return $this->belongsTo(User::class, 'referrer_id'); }
    public function referred() { return $this->belongsTo(User::class, 'referred_id'); }
}
