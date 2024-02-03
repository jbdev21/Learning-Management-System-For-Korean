<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    protected $guarded = [];

    function quiz(){
        return $this->belongsTo(Quiz::class);
    }

    function user(){
        return $this->belongsTo(User::class);
    }

    function answers(){
        return $this->hasMany(Answer::class);
    }


    function quizCompleted($quiz){
        $quizQuestions = Quiz::find($quiz)->questions()->count();

        if(!$quizQuestions){
            return false;
        }

        $answers = $this->answers()->whereHas('question', function($q) use ($quiz){
            $q->whereQuizId($quiz);
        })->count();

        return $quizQuestions == $answers;
    }


    function quizScore($itemized = null){

        $quizQuestions = $this->quiz->questions()->count();
        $quiz = $this->quiz;

        if(!$quizQuestions){
            return false;
        }

        $correct = $this->answers()->whereHas('question', function($q) use ($quiz){
                $q->whereQuizId($quiz->id)->where('correct', 1);
        })->count();

        if($itemized){
            if($itemized == "correct"){
                return $correct;
            }
            return $quizQuestions;
        }
        return $correct.'/'. $quizQuestions;
    }
}
