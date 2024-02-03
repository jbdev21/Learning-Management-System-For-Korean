<?php

namespace App\Http\Controllers\Student;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LibraryController extends Controller
{
    function index(Request $request){
        if($request->q){
            $books = Book::where('title', 'LIKE',  '%' . $request->q . '%')
                        ->orWhere('type', 'LIKE',  '%' . $request->q . '%')
                        ->orWhere('type_name', 'LIKE',  '%' . $request->q . '%')
                        ->orWhere('ar_level', 'LIKE',  '%' . $request->q . '%')->paginate(30);
        }else{
            $books = Book::orderBy('book_number')->paginate(30);
        }
        if($request->q == "site"){
            return view('site.library.index', compact('books'));
        }else{
            return view('student.library.index', compact('books'));
        }
    }
}
