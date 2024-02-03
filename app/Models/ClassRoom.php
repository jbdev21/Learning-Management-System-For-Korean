<?php

namespace App\Models;

use App\Traits\HasBranchScope;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasBranchScope;
    
    function students(){
        return $this->belongsToMany(User::class,'class_room_user')->where('type', 'student');
    }

    function users(){
        return $this->belongsToMany(User::class);
    }

    function teachers(){
        return $this->belongsToMany(User::class, 'class_room_user')->where('type', 'teacher');
    }

    function subjects(){
        return $this->belongsToMany(Subject::class);
    }
}
