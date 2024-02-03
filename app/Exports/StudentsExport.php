<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Subject;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsExport implements FromArray
{

    public function array(): array
    {
        $array =    [ 
            ['', 'ID', 'Name', 'Gender', 'Email', 'St. Contact', 'Parent Contact', 'School', 'Status', 'Grade', 'Subject', 'Class']
        ];
        $students =  User::whereType('student')->get()->map(function($q){
            return [
                $q->count,
                $q->username,
                $q->name,
                $q->gender == "male" ? "M" : 'F',
                $q->email,
                $q->contact_number,
                $q->parent_contact_number,
                $q->studentData->data->school_name ?? "",
                $q->status,
                $q->studentData->data->grade ?  'Grade ' . $q->studentData->data->grade : "",
                Subject::whereIn('id',$q->subjectsEnglishBackground())->get()->pluck('name')->implode(' / '),
                $q->classes
            ];
        })->toArray();
        array_push($array, $students);
        return $array;
    }
}
