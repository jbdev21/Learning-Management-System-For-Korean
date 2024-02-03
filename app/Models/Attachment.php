<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $casts = [
        'data' => 'object',
    ];

    public function attachable()
    {
        return $this->morphTo();
    } 
}
