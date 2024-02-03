<?php

namespace App\Models;

use Cache;
use Storage;
use App\Traits\HasImage;
use Laravel\Scout\Searchable;
use App\Traits\HasBranchScope;
use Illuminate\Database\Eloquent\Model;

class AudioBook extends Model
{
    use HasImage, Searchable, HasBranchScope;
    protected $guarded = [];    

    // public function toSearchableArray()
    // {
    //     $array = $this->with('branch')->get()->toArray();
    //     return $array;
    // }

    function branch(){
        return $this->belongsTo(Branch::class);
    }



    function getThumbnailAttribute(){
    
        $key = 'audiobook.' . $this->id . '.thumbnail';
        $audiobook = $this;
        return Cache::rememberForever($key, function() use ($audiobook){
            $thumbnail = $audiobook->thumbnail_source;
            if($audiobook->thumbnail_source_type == "uploaded"){
                return $thumbnail ? Storage::disk($audiobook->storage_thumbnail_disk)->url($thumbnail) : $this->defaultThumbnail();
            }else{
                return $thumbnail ?? $this->defaultThumbnail();
            }
        });

    }

    function getStorageDiskAttribute(){
        if($this->source_type == 'hosted'){
            return 'audio-books';
        }

        return 'gw-audiobook-sftp';
    }

    function getStorageThumbnailDiskAttribute(){
        if($this->source_type == 'hosted'){
            return 'audio-books-thumbnails';
        }

        return 'audio-books-thumbnails-ftp';
    }

    function getServerFolderAttribute(){
        if($this->source_type == 'hosted'){
            return $this->source_folder;
        }else{
            if($this->type == "series"){
                $folder = 'GWAudio_Series';
            }else if($this->type == "library"){
                $folder = 'GWAudio_Rental';
            }else{
                $folder = 'GWAudio_Stage';
            }
            return $folder . '/' . $this->source_folder;
        }
    }


    function getAudioFiles(){
        $key = 'audiobook.' . $this->id . '.audiofiles';
        $audiobook = $this;
        
        return Cache::rememberForever($key, function() use ($audiobook){
            if($audiobook->source_type == "hosted"){
                $files = Storage::disk('audio-books')->allFiles($audiobook->server_folder);
            }else{
                $files = Storage::disk('gw-audiobook-sftp')->allFiles($audiobook->server_folder);
            }
    
            return collect($files)->filter(function($q){
                return !strpos($q, 'thumbnail');
            })->map(function($q) use ($audiobook){
                return str_replace($audiobook->server_folder . '/','', $q);
            });
        });
    }

    function audioJSONFiles(){
        $audiobook = $this;
        return $this->getAudioFiles()->map(function($q) use ($audiobook){
            if($audiobook->source_type == "hosted"){
                $url = Storage::disk($audiobook->storage_disk)->url($q);
            }else{
                $url = config('audiobook.audio_baseurl') . $audiobook->server_folder . '/' . $q;
            }
            return [
                'name' => str_replace($audiobook->source_folder . '/', '', $q),
                'url'  => $url,
                'cover_art_url' => $audiobook->thumbnail,
            ];
        });
    }


    function sourceUrl(){
        if($this->source_type == "hosted"){
            $rootUrl = url(config('audiobook.hosted_folder') . $this->source_folder);
        }else{
            $rootUrl = config('audiobook.source_server') .'/'. $this->source_folder;
        }

        return $rootUrl;
        
    }




    function defaultThumbnail(){
        return "https://blog.springshare.com/wp-content/uploads/2010/02/nc-md.gif";
    }


}
