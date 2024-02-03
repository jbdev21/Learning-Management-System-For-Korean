<?php

namespace App\Http\Controllers\Student;

use App\Models\AudioBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AudioBookController extends Controller
{
    function index(Request $request){
        if($request->q){
            $audiobooks = AudioBook::where('title', 'LIKE',  '%' . $request->q . '%')
                        ->orWhere('type', 'LIKE',  '%' . $request->q . '%')
                        ->orWhere('type_name', 'LIKE',  '%' . $request->q . '%')
                        ->orWhere('ar_level', 'LIKE',  '%' . $request->q . '%')->paginate(30);
        }else{
            $audiobooks = AudioBook::orderBy('title')->paginate(30);
        }
        if($request->q == "student"){
            return view('student.audiobook.index', compact('audiobooks'));
        }else{
            return view('site.audiobook.index', compact('audiobooks'));
        }
    }

    function show(Request $request, $id){
        $audiobook = AudioBook::find($id);
        if($request->q == "student"){
            return view('student.audiobook.show', compact('audiobook'));
        }else{
            return view('site.audiobook.show', compact('audiobook'));
        }
    }
}
