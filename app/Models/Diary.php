<?php

namespace App\Models;

use App\Traits\HasBranchScope;
use App\Traits\HasComment;
use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    use HasComment, HasBranchScope;

    function user(){
        return $this->belongsTo(User::class);
    }
}
