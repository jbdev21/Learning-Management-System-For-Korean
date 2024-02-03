<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Excercise extends Model
{
    function user(){
        return $this->belongsTo(User::class);
    }

    function writings(){
        return $this->hasMany(Writing::class);
    }

    function book(){
        return $this->belongsTo(Book::class);
    }
}
