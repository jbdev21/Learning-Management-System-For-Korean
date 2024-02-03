<?php

namespace App\Models;

use App\Traits\HasAttachment;
use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    use HasAttachment, HasImage;

    protected $guarded = [];

    protected $casts = [
        'options' => 'array',
    ];

    function getBodyAttribute($value){
        return str_replace('../../uploads', '/uploads', $value);
    }

    function userAnswer($id, $examinationId){
        return $this->answers()->whereUserId($id)->whereExaminationId($examinationId)->first();
    }

    function answerText(){
        if($this->type == "multiple"){
            // return 'question' . $this->id;
            $index = $this->answer ? $this->answer-- : 0;
            return $this->options[$index] ?? "";
        }else{
            $text = "";
            foreach($this->options as $option){
                $text .= $option;
            }
            return $text;
        }
    }

    function answers(){
        return $this->hasMany(Answer::class);
    }

    function quiz(){
        return $this->belongsTo(Quiz::class);
    }

    function checkForCorrect($answer){
        if($this->type == "multiple"){
            return $this->answer === $answer;
        }else{
            foreach($this->options as $index => $value){
                if($this->case_sensitive){
                    if (strcmp($value, $answer) == 0) {
                        return true;
                    }
                }else{
                    if (strtolower($value) == strtolower($answer)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
