<?php
namespace App\Traits;

use App\Models\Attachment;
use Illuminate\Http\Request;

trait HasAttachment{

    public function attachments(){
        return $this->morphMany(Attachment::class, 'attachable');
    }

}
