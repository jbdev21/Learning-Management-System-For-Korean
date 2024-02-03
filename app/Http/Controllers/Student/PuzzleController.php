<?php

namespace App\Http\Controllers\Student;

use Arr;
use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PuzzleController extends Controller
{
    function index(Request $request){
        $files = scandir(config_path('puzzles')); 
        $categories = Arr::except($files, [0,1]);
        if($request->category){
            $list = scandir(config_path('puzzles/'.$request->category));
            $defaultCategory = $request->category;
        }else{
            $list = scandir(config_path('puzzles/'.$categories[3]));
            $defaultCategory = $categories[3];
        }
        
        $items = Arr::except($list, [0,1]);
        return view('student.puzzle.'. $defaultCategory . '.index', compact('categories','items', 'defaultCategory'));
    }

    function show($category, $item){
        if(request()->ajax()){
            return json_encode(config('puzzles.'.$category .'.' . $item));
        }
        $category = $category;
        return view('student.puzzle.' . $category .'.show', compact('category'));
    }
}
