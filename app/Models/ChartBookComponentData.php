<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartBookComponentData extends Model
{
    protected $fillable = ['book_id', 'user_id', 'cell'];
}
