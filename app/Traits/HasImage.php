<?php
namespace App\Traits;

use Image as ImageIntervention;
use App\Models\Image;
use Illuminate\Http\Request;

trait HasImage{

    public function images(){
        return $this->morphMany(Image::class, 'imagable');
    }

    public function image($type){
        return $this->images()->whereType($type);
    }


    public function addLinkedImage($link, $type){
        $image = new Image;
        $image->type = $type;
        $image->source = $link;
        $image->source_type = "link";
        $this->images()->save($image);
        return $image;
    }


    public function addImage($imagetype, $file, $folder, $exist = false, $is_base64 = false){
        if($is_base64){
            $image = $file;  // your base64 encoded
            list($type, $image) = explode(';', $image);
            list(, $image)      = explode(',', $image);
            $image_image = time().'.'.'webp';
            file_put_contents($folder. '/' . $image_image, base64_decode($image));
        }else{
            $image_image = $exist ? $file : $this->upload($file, $folder);
        }

        $image = new Image;
        $image->type = $imagetype;
        $image->source = 'uploads/' . $image_image;
        $image->source_type = 'local';
        $this->images()->save($image);
        return $image;
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


    function upload($image, $path)
    {
        // $name = uniqid() . time() .'.'.$image->getClientOriginalExtension();
        $name = uniqid() . time() .'.webp';
        $img = ImageIntervention::make($image->getRealPath());
        if($img->save($path.'/'.$name)){
            return $name;
        }else{
            return "";
        }

    }


    function removeImage($type){
        $this->images()->whereType($type)->delete();
        return true;
    }

    function removeImageById($id){
        $this->images()->whereId($id)->delete();
        return true;
    }
}
