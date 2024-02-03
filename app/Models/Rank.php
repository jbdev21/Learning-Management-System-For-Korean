<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    function rankable(){
        return $this->morphTo();
    }
}
