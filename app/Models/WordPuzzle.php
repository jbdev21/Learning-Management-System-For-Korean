<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordPuzzle extends Model
{
    function puzzleWords(){
        return $this->hasMany(PuzzleWord::class);
    }
}
