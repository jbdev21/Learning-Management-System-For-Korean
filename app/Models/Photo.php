<?php

namespace App\Models;

use Image;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{

    protected $folder;

    public function photoable()
    {
        return $this->morphTo();
    }

    public function getFolder(){
        return $this->folder ??  public_path('uploads');
    } 

    public function folder($folder){
        $this->folder = $folder;
        return $this;
    }

    function imageResize($width, $height, $aspect_ratio = false, $save_to = '')
    {
        $path = $this->getFolder() .'/'. $this->path;
        $image = Image::make($path);
        if($aspect_ratio)
        {
            //with aspect ratio
            if($save_to){
                $image->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($save_to);
            }else{
                $image->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path);
            }
        }else{
            if($save_to){
                $image->resize($width, $height)->save($save_to);
            }else{
                $image->resize($width, $height)->save($path);
            }
        }

        return $image;
    }
}
