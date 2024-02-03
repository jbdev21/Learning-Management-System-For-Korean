<?php
namespace App\Traits;

use Image;
use App\Models\Photo;

trait HasPhoto{

    protected $folder; 

    public function photos(){
        return $this->morphMany(Photo::class, 'photoable');
    }

    public function setFolder($folder = null){
        $this->folder = $folder ?? public_path('uploads');
        return $this;
    }

    public function getFolder(){ 
        return $this->folder ??  public_path('uploads');
    }

    /*
     * File is request->file
    */
    public function upload($file, $type, $is_base64 = false){
        if($is_base64){
            $image = $file;  // your base64 encoded
            list($type, $image) = explode(';', $image);
            list(, $image)      = explode(',', $image);
            $imageName = uniqid() . time().'.'.'jpg';
            file_put_contents($this->getFolder(). '/' . $imageName, base64_decode($image));
        }else{
            $imageName = uniqid() . time() .'.'.$file->getClientOriginalExtension();
            $img = Image::make($file->getRealPath());
            $img->save($this->getFolder().'/'.$imageName);
        }

        $photo = new Photo;
        $photo->path = $imageName;
        $photo->type = $type;
        $this->photos()->save($photo);
        return $photo;
    }


    function imageResize($path, $width, $height, $aspect_ratio = false, $save_to = '')
    {
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



    public function clearImage($type, $path = null){
        if(is_array($type)){
            for($i = 0; $i < count($type); $i++){
                $images = $this->photos()->where('type', $type[$i])->get();
                foreach($images as $image){
                    $this->unlinkImage($image->path);
                    $image->delete();
                }
            }
        }else{
            $images = $this->photos()->where('type', $type)->get();
            foreach($images as $image){
                $this->unlinkImage($image->path);
                $image->delete();
            }
        }
        
    }


    function unlinkImage($image){
        $file = $this->folder . '/' . $image;
        if(file_exists($file)){
            unlink($file);
        }
    }


}