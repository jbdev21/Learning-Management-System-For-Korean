<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EssayRank extends Model
{
    function student(){
        return $this->belongsTo(User::class, 'student_id');
    }

    function component(){
        return $this->belongsTo(Component::class);
    }

    function book(){
        return $this->belongsTo(Book::class);
    }
}
