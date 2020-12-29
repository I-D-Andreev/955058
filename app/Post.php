<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function author(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function comments(){
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag');
    }

    // public function commentsRecursive(){
    //     return $this->comments()->with('commentsRecursive');
    // }
}
