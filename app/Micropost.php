<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Micropost extends Model
{
    protected $fillable = ['content', 'user_id'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    
    //記事をお気に入りしているユーザを取得できるが、使用しなさそう
    public function favorited() {
        
        return $this->belongsToMany(User::class, 'favorites', 'micropost_id', 'user_id')->withTimestamps();
    }

    
}
