<?php
namespace App\Http\Controllers\BackEnd;

use Auth;
use App\Models\Book;
use App\Models\User;
use App\Models\Writing;
use App\Models\BookScore;
use App\Models\ClassRoom;
use App\Models\Component;
use App\Models\Excercise;
use Illuminate\Http\Request;
use App\Models\ComponentScore;
use App\Http\Controllers\Controller;
use App\Notifications\Student\NewWritingNotification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class WritingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $classRooms = DB::table('class_rooms')->get();
        $query =  Book::select('books.*', 
                            'users.username as username',
                            'users.name as student_name',
                            'users.status as student_status',
                            'writings.created_at as last_modified',
                            'writings.id as writing_id',
                            'writings.id as last_writing_id',
                            'writings.component_id as component_id',
                            'writings.book_id as book_id',
                            'writings.student as student',
                            DB::raw("(select GROUP_CONCAT(name order by name SEPARATOR ', ') from `class_rooms` join `class_room_user` on `class_room_user`.`class_room_id` = `class_rooms`.`id` where `class_room_user`.`user_id` = `users`.`id`) as class_room_names" ),
                            DB::raw("(select COUNT(rating) from book_scores where book_id = books.id and user_id = users.id) as sum_rating")
                            )    
                ->leftJoin('writings', 'writings.book_id', '=', 'books.id')
                ->leftJoin('users', 'users.id', '=','writings.student')
                ->where('users.status', 'on-going')
                ->leftJoin('class_room_user', 'class_room_user.user_id', '=', 'users.id')
                ->join('class_rooms', 'class_rooms.id', '=', 'class_room_user.class_room_id')
                ->where('users.branch_id', domainBranch()->id);
                

             
        if($request->status){
            if($request->status == 'DONE'){
                $query->having('sum_rating', '>', 0);
            }else{
                $query->having('sum_rating', 0);
            }
        }

        if($request->class){
            $query->where('class_rooms.id', $request->class);
        }

        if($request->name){
            $query->where('users.name','LIKE', '%'. $request->name . '%')
                ->orWhere('users.username','LIKE', '%'. $request->name . '%');
        }

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
       
        // $query->orderBy('updated_at', 'DESC')->get();
        if($request->student){
            $query->where('users.id', $request->student);
        }

        $writings = $query
                        ->where('users.status', 'on-going')
                        ->groupBy('book_id', 'student')
                        ->orderBy('last_modified', 'DESC')
                        ->paginate(20);
        
        return view('back-end.writing.index', compact('writings', 'classRooms'));
        
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'book_id'       => 'required|integer',
            'component_id'  => 'required|integer',
        ]);

        
        foreach($request->except('_token','component_id', 'book_id', 'student') as $inputData){
            $mode = $inputData['mode'];
            $input = $inputData['input'];
            $inputData['data']['date_time'] = date('Y-m-d H:i:s');   
            $inputData['data']['writer'] = auth()->user()->id;   
            $inputData['data']['writer_type'] = 'teacher';   
            $data =  $inputData['data'];

            $data =  $inputData['data'];
            $first_key = array_keys($data)[0];
            
            $current = Writing::where('book_id', $request->book_id)
                                ->where('component_id', $request->component_id)
                                ->where('student', $request->student);
                                
            if($mode == "stacked"){
                if($data[$first_key] && $first_key != 'date_time'){
                    $writing = new Writing;
                    $writing->user_id = $request->user()->id;
                    $writing->student = $request->student;
                    $writing->component_id = $request->component_id;
                    $writing->book_id = $request->book_id;
                    $writing->data = $data;
                    $writing->input = $input;
                    $writing->save();

                    $student = User::find($request->student);
                    $student->notify(new NewWritingNotification(Auth::user(), $writing, 'stacked'));
                }
            }else{
                if($current->where('input', $input)->exists()){
                    $writing  = $current->first();
                    $writing->data = $data;
                    $writing->save();
                }else{
                    if($data[$first_key] && $first_key != 'date_time'){
                        $writing = new Writing;
                        $writing->user_id = $request->user()->id;
                        $writing->student = $request->student;
                        $writing->component_id = $request->component_id;
                        $writing->book_id = $request->book_id;
                        $writing->data = $data;
                        $writing->input = $input;
                        $writing->save();

                        $student = User::find($request->student);
                        $student->notify(new NewWritingNotification(Auth::user(), $writing, 'edit-only'));
                    }
                }
            }
    
        }

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $book = Book::findOrFail($request->book);
        $components  = Component::where('parent_id', null)->get();
        $student = User::findOrFail($request->student);
        if(!$student || !$book){
            abort(404);
        }
        if($request->component){
            $activecomponent = Component::find($request->component);

            if(!$activecomponent){
                abort(404);
            }

            // if($activecomponent->type == "ordinary"){
            $score = ComponentScore::whereUserId($request->student)->whereComponentId($request->component)->whereBookId($request->book)->first();
            $bookScore = BookScore::whereUserId($request->student)->whereBookId($request->book)->first();
            $data = [];
            $writings =  Writing::where('student', $student->id)->where('component_id', $request->component)->where('book_id', $book->id)->orderBy('input')->orderBy('created_at', 'ASC')->get();

            foreach($writings as $writing){
                $writingData = $writing->data;
                if(isset($data[$writing->input])){
                    // foreach($writing->whereInput($writing->input)->first()->data as $index => $value){
                    //     $writingData[$index] = $value;
                    // }
                    $writingData['id'] = $writing->id;
                    array_push($data[$writing->input], $writingData);

                }else{
                    // foreach($writing->whereInput($writing->input)->first()->data as $index => $value){
                    //     $writingData[$index] = $value;
                    // } this code only getting the first one on a list

                    $writingData['id'] = $writing->id;

                    $data[$writing->input] = [$writingData];
                }
            }
            

            return view('back-end.writing.show', compact('book', 'components', 'activecomponent', 'data', 'student','score', 'bookScore'));
        }
        return view('back-end.writing.show', compact('book', 'components', 'student'));
    }

    function essayChart($id){
        $student = User::find($id);
        $books = Book::whereIn('type_name', $student->book_access ?? [])->orderBy('title')->get()->filter(function($q) use ($student){
            return $q->writings()->whereStudent($student->id)->first() ? true : false;
        });

        $components = Component::whereDoesntHave('parent')->get();

        return view('back-end.student.essay-chart', compact('books', 'student', 'components'));
    }



    public function componentSendScore(Request $request){
        $existing = ComponentScore::whereUserId($request->student)->whereComponentId($request->component)->whereBookId($request->book);
        if($existing->count()){
            $existing = $existing->first();
            $existing->rating = $request->rating;
            $existing->save();
        }else{
            $score = new ComponentScore;
            $score->component_id = $request->component;
            $score->scored_by = $request->user()->id;
            $score->book_id = $request->book;
            $score->user_id = $request->student;
            $score->rating = $request->rating;
            $score->save();
        }

        if(!$request->ajax()){
            return back();
        }else{
            return response()->json([
                'status' => 200,
                'message' => 'Score Sent!'
            ], 200);
        }
    }

    public function bookSendScore(Request $request){
        $existing = BookScore::whereUserId($request->student)->whereBookId($request->book);
        if($existing->count()){
            $existing = $existing->first();
            $existing->rating = $request->rating;
            $existing->save();
        }else{
            $score = new BookScore;
            $score->scored_by = $request->user()->id;
            $score->book_id = $request->book;
            $score->user_id = $request->student;
            $score->rating = $request->rating;
            $score->save();
        }

        if(!$request->ajax()){
            return back();
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->checkitems){
            foreach($request->checkitems as $item){
                $writing = Writing::find($item);
                Writing::whereBookId($writing->book_id)->whereStudent($writing->student)->delete();
            }
        }else{
            if($id){
                $writing = Writing::find($id);
                Writing::whereBookId($writing->book_id)->whereStudent($writing->student)->delete();
            }
        }

        if(!$request->ajax()){
            return back()->with('success', 'Item deleted');
        }
    }

    function print(Request $request, $id, $studentId){

        $book = Book::find($id);
        $components  = Component::all();
        $data = array();
        $student = User::find($studentId);
        
        foreach($components as $component){
            
            $score = ComponentScore::whereUserId($student->id)->whereComponentId($component->id)->whereBookId($book->id)->first();
            $writings =  Writing::where('student', $student->id)->where('component_id', $component->id)->where('book_id', $book->id)->orderBy('input')->orderBy('created_at', 'ASC')->get();
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

        // return $data;

        return view('back-end.writing.print', compact('data', 'book', 'components','student'));
        
    }
}
