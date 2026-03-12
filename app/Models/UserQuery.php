<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class UserQuery extends Model
{
    protected $table = 'user_queries';
    protected $fillable = ['user_id','subject','message','status','priority','admin_reply','admin_id','replied_at'];
    protected $casts = ['replied_at'=>'datetime'];
    public function user()  { return $this->belongsTo(User::class); }
    public function admin() { return $this->belongsTo(Admin::class, 'admin_id'); }
}
