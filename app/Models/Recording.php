<?php

namespace App\Models;

use App\Traits\HasComment;
use Illuminate\Database\Eloquent\Model;

class Recording extends Model
{
   use HasComment;

   function user(){
      return $this->belongsTo(User::class);
   }

   

}
