<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Writing extends Model
{

    protected $casts = [
        'data' => 'array',
    ];

    public function scopeLastPerGroup(Builder $query, ?array $fields = null)
    {
         return $query->whereIn('id', function (QueryBuilder $query) use ($fields) {
            return $query->from(static::getTable())
                ->selectRaw('max(`id`)')
                ->groupBy($fields ?? static::$groupedLastScopeFields);
        });
    }

    function user(){
        return $this->belongsTo(User::class);
    }

    function writingStudent(){
        return $this->belongsTo(User::class, 'student');
    }

    function lastStudentWriting(){
        return $this->belongsTo(User::class, 'student')->orderBy('updated_at', 'DESC');
    }
    

    function ownerUser(){
        return $this->belongsTo(User::class, "data->owner']");
    }

    function excercise(){
        return $this->belongsTo(Excercise::class);
    }

    function book(){
        return $this->belongsTo(Book::class);
    }

    function component(){
        return $this->belongsTo(Component::class);
    }


    function student(){
        return $this->belongsTo(User::class, 'student');
    }
}
