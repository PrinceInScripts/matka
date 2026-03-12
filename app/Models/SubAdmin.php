<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class SubAdmin extends Authenticatable
{
    protected $table = 'sub_admins';
    protected $fillable = ['name','username','email','phone','password','status','permissions','created_by'];
    protected $hidden = ['password'];
    protected $casts = ['permissions'=>'array','status'=>'boolean'];
}
