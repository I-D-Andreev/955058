<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function author(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function comments(){
        return $this->hasMany('App\Comment', 'post_id');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag');
    }
}
