<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    function commentable(){
        return $this->morphTo();
    }

    function commentList(){
        return $this;
    }

    function bookComments(){
        return $this->hasMany(ComponentComment::class);
    }

    function user(){
        return $this->belongsTo(User::class);
    }
}



