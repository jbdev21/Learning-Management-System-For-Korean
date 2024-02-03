<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuzzleWord extends Model
{
    function wordPuzzle(){
        return $this->belongsTo(WordPuzzle::class);
    }
}
