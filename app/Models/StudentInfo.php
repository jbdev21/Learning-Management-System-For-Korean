<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
      protected $casts = [
        'data' => 'object',
        'book_access' => 'array',
        'english_background' => 'object',
        'assessments' => 'object',
    ];
}
