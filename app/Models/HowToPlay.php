<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HowToPlay extends Model
{
    protected $table = 'how_to_play';
    protected $fillable = ['title','content','video_url','display_order','is_active'];
    protected $casts = ['is_active'=>'boolean'];
}
