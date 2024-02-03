<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRank extends Model
{
    function student(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
