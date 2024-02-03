<?php

namespace App\Models;

use App\Traits\HasComment;
use App\Traits\HasBranchScope;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasComment, HasBranchScope; // bundle of methods

    public function user(){
        return $this->belongsTo(User::class);
    }
}


