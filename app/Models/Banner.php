<?php

namespace App\Models;

use App\Traits\HasBranchScope;
use App\Traits\HasPhoto;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
     use HasPhoto, HasBranchScope;

    function getBannerImageAttribute(){
        return $this->photos()->whereType('banner')->first() 
            ? '/uploads/banners/' . $this->photos()->whereType('banner')->first()->path  
                : '/placeholders/quiz.jpg';
    }
}
