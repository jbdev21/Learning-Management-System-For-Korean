<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComponentComment extends Model
{
    function user(){
        return $this->belongsTo(User::class);
    }

    function component(){
        return $this->belongsTo(Component::class);
    }

    function book(){
        return $this->belongsTo(Book::class);
    }
}
