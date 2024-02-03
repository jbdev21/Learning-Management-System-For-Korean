<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookScore extends Model
{
    function teacher(){
        return $this->belongsTo(User::class, 'scored_by');
    }

    function book(){
        return $this->belongsTo(Book::class);
    }

    function student(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
