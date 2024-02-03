<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;

class BookExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $array =    [ 
                ['No.', 'Stage/Series', 'Stage/Series Name', 'Title', 'AR']
            ];
        $books =  Book::where('branch_id', request()->user()->branch_id)->get()->map(function($q){
            return [
                $q->book_number,
                $q->type,
                $q->type_name,
                $q->title,
                $q->ar_level,
            ];
        })->toArray();

        // return $array;
        array_push($array, $books);
        return $array;
    }
}
