<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{

    protected $casts = [
        'inputs' => 'array',
    ];

    function parent(){
        return $this->hasOne(Component::class, 'id', 'parent_id');
    }

    function children(){
        return $this->hasMany(Component::class, 'parent_id', 'id');
    }

    function totalChildrenCount(){
        $counts = 0;
        // $counts += $this->children()->count();

        foreach($this->children as $children){
            $counts += $children->children()->count();

        }

        return $counts;
    }

    function writings(){
        return $this->hasMany(Writing::class);
    }

    function scores(){
        return $this->hasMany(ComponentScore::class);
    }

    function studentComponentRate($studentId, $bookId){
        $score = $this->scores()->whereUserId($studentId)->whereBookId($bookId)->first();
        $scoring = $score->rating ?? 0;
        $html = '';
        $html .= "<div class='rating-stars' style='margin-top:5px;'>
                    <ul id='stars'> ";
                        for($i = 1; $i < 11; $i++){
                                $html .= "<li class='star'";
                                $html .= " title='Poor' data-value='" . $i . "'><i class='fa ";
                                 $scoring >= $i ? $html .= " fa-star'" :  $html .=  "fa-star-o'";
                                $html .= " fa-fw'></i></li>";
                            }
                    $html .= "</ul>";
                    $html .=  $scoring  . " stars";
                    $html .=  "</div>";
                // }

        return $html;
    }
}
