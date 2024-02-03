<?php

namespace App\Http\Controllers\Student;

use PDF;
use App\Models\Book;
use App\Models\Writing;
use App\Models\Component;
use Illuminate\Http\Request;
use App\Models\ComponentScore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EssayController extends Controller
{
    function index(Request $request){
        $student_id = auth()->user()->id;
        // return Book::query()->whereIn('type_name', auth()->user()->book_access ?? [])->count();
        $query = Book::select('books.*',
                    'writings.created_at as last_modified',
                    DB::raw("(select COUNT(rating) from book_scores where book_id = books.id and user_id = users.id) as sum_rating"),
                    DB::raw("(case when (SELECT count(*) FROM book_scores where book_scores.book_id = books.id and book_scores.user_id = $student_id) > 0 then 'DONE' when (SELECT count(*) FROM writings where writings.book_id = books.id and writings.student = $student_id) > 0 then 'Ongoing' else 'Pending' end) as status"),
                    DB::raw("(select COUNT(*) from writings where book_id = books.id and student = users.id) as writing_count")
                    )
            ->leftJoin('writings', function ($join) use($student_id) {
                $join->on('books.id', '=', 'writings.book_id')->where('user_id', $student_id);
            })
            ->leftJoin('users', 'users.id', '=','writings.user_id')
            ->whereIn('type_name', auth()->user()->book_access ?? [])
            ->groupBy('books.id')
            ->orderBy('last_modified', 'DESC');

        if($request->title){
            $query->where('books.title', 'LIKE', '%'.$request->title .'%');
        }

        if($request->type){
            $query->where('books.type', 'LIKE', '%'.$request->type .'%');
        }

        if($request->type_name){
            $query->where('books.type_name', 'LIKE', '%'.$request->type_name .'%');
        }

        if($request->ar_level){
            $query->where('books.ar_level', 'LIKE', '%'.$request->ar_level .'%');
        }

        if($request->status){
            $query->having('status', $request->status);
        }
        // return $query->get();
        $books = $query->paginate(15);

        $type_names = Auth::user()->book_access ?? []; //Book::groupBy('type_name')->pluck('type_name');
        return view('student.essay.index', compact('books', 'type_names'));
    }


    function chart(Request $request){
        $student = Auth::user();
        $id = $student->id;
        // $books = Book::whereIn('type_name', $student->book_access ?? [])->get()->sortBy(function($q) use($id){
        //             return $q->bookStudentStatus($id);
        //         });
        $books = Book::query()
                    ->select("books.*")
                    ->addSelect(['status' => function($query) use ($id){
                        $query->selectRaw("case when (SELECT count(*) FROM book_scores where book_scores.book_id = books.id and book_scores.user_id = $id) > 0 then 'DONE' when (SELECT count(*) FROM writings where writings.book_id = books.id and writings.student = $id) > 0 then 'Ongoing' else 'Pending' end");
                    }])
                    ->whereIn('type_name', $student->book_access ?? [])
                    ->orderBy("status")
                    ->paginate(500);

        return view('student.essay.charts.' . $request->type , compact('books', 'student'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function show(Request $request, $id){
        $book = Book::find($id);
        $components  = Component::where('parent_id', null)->get();

        if($request->component){
            $activecomponent = Component::find($request->component);
            $score = ComponentScore::whereUserId(auth()->user()->id)->whereComponentId($request->component)->whereBookId($book->id)->first();
            $data = [];
            $writings =  Writing::where('student', auth()->user()->id)->where('component_id', $activecomponent->id)->where('book_id', $book->id)->orderBy('input')->orderBy('created_at', 'ASC')->get();

            foreach($writings as $writing){
                $writingData = $writing->data;

                if(isset($data[$writing->input])){

                    // foreach($writing->whereInput($writing->input)->first()->data as $index => $value){
                    //     $writingData[$index] = $value;
                    // }

                    $writingData['id'] = $writing->id;
                    array_push($data[$writing->input], $writingData);

                }
                else{
                    // foreach($writing->whereInput($writing->input)->first()->data as $index => $value){
                    //     $writingData[$index] = $value;
                    // }

                    $writingData['id'] = $writing->id;
                    $data[$writing->input] = [$writingData];
                }

            }

            if($activecomponent->type == "summary"){
                $defaults = Writing::where('student', auth()->user()->id)->where('component_id', $activecomponent->id)->where('book_id', $book->id)->whereIn('input', $activecomponent->inputs)->orderBy('input')->orderBy('created_at', 'ASC')->get();
                $defaultText = '';

                //get siblings component
                $parent = $activecomponent->parent;
                $siblings =  $parent->children()->where('id', '!=', $activecomponent->id)->get()->filter(function($q) use ($activecomponent){
                    foreach($activecomponent->inputs as $input){
                        return in_array('Form', $q->inputs);
                        // return in_array($input, $q->inputs);
                    }
                });

                foreach($siblings as $sibling){
                    $siblingWriting = Writing::where('student', auth()->user()->id)->where('user_id', auth()->user()->id)->where('component_id', $sibling->id)->where('book_id', $book->id)->whereIn('input', ['Form'])->orderBy('input')->orderBy('updated_at', 'DESC')->first();
                    if($siblingWriting){
                            $siblingWritingData = $siblingWriting->data;
                            $defaultText .= $siblingWritingData['summary'] . PHP_EOL . PHP_EOL ;
                    }
                }

                $data['default_value'] = $defaultText;
                array_push($data, $data['default_value']);
            }

            // return $data;
            return view('student.essay.show', compact('book', 'components', 'activecomponent', 'data', 'score'));
        }




        return view('student.essay.show', compact('book', 'components'));
    }

    function print(Request $request, $id){

        $book = Book::find($id);
        $components  = Component::all();
        $data = array();
        foreach($components as $component){

            $score = ComponentScore::whereUserId(auth()->user()->id)->whereComponentId($component->id)->whereBookId($book->id)->first();
            $writings =  Writing::where('student', auth()->user()->id)->where('component_id', $component->id)->where('book_id', $book->id)->orderBy('input')->orderBy('created_at', 'ASC')->get();
            // if($writings){
            foreach($writings as $writing){
                // array_push($data, $writing->data);
                if(isset($data[$component->id][$writing->input])){
                    array_push($data[$component->id][$writing->input], $writing->data);
                }else{
                    $data[$component->id][$writing->input] = [$writing->data];
                }
            // }
            }
        }


        return view('student.essay.print', compact('data', 'book', 'components'));

    }
}
