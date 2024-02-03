<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComponentScore extends Model
{
    function teacher(){
        return $this->belongsTo(User::class, 'scored_by');
    }

    function ranks(){
        return $this->morphMany(Rank::class, 'rankable');
    }

    function component(){
        return $this->belongsTo(Component::class);
    }

    function book(){
        return $this->belongsTo(Book::class);
    }

    function student(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
