<?php

namespace App\Models;

use App\Traits\HasPhoto;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasPhoto;

    function getLogoPathAttribute(){
        $logo = $this->photos()->whereType('logo')->first();
        if($logo){
            $path = public_path('uploads/logo/', $logo->path);
            if(file_exists($path)){
                return "/uploads/logo/" . $logo->path;
            }else{
                return '/images/logo.png';
            }
        }else{
            return '/images/logo.png';
        }
    }
}
