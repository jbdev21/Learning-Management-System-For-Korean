<?php

namespace App\Models;

use Auth;
use App\Traits\HasBranchScope;
use App\Traits\HasPhoto;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{

    use HasPhoto, HasBranchScope;
    
    function questions(){
         return $this->hasMany(Question::class);
    }

    function getThumbnail(){
        return $this->photos()->whereType('thumbnail')->first() 
            ? '/uploads/' . $this->photos()->whereType('thumbnail')->first()->path  
                : '/placeholders/quiz.jpg';
    }

    function lastExamination(){
        return $this->hasOne(Examination::class)
            ->when(Auth::user(), function($query){
                $query->where('user_id', Auth::user()->id);
            })
            ->latest();
    }

    function examinations(){
        return $this->hasMany(Examination::class);
    }

    function scopeMultiple(){
        return $this->questions()->whereType('multiple');
    }

    function scopeSubjective(){
        return $this->questions()->whereType('subjective');
    }

    function users(){
        return $this->belongsToMany(User::class);
    }
}
