<?php

namespace App\Http\Controllers\Api;

use Auth;
use Notification;
use App\Models\Book;
use App\Models\User;
use App\Models\Component;
use Illuminate\Http\Request;
use App\Models\ComponentComment;
use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentResource;
use App\Notifications\Student\ComponentCommentNotification as StudentComponentCommentNotification;
use App\Notifications\Teacher\ComponentCommentNotification as TeacherComponentCommentNotification;

class ComponentCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $comments = ComponentComment::where('book_id', $request->book)
                    ->where('component_id', $request->component)
                    ->where('student', $request->student)
                    ->get();

        return CommentResource::collection($comments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
            'book'  => 'required',
            'component' => 'required',
            'student' => 'required'
        ]);

        $comment = new ComponentComment;
        $comment->book_id = $request->book;
        $comment->component_id = $request->component;
        $comment->message = $request->message;
        $comment->student = $request->student;
        $comment->user_id = $request->user()->id;
        $comment->save();

        $book = Book::find($request->book);
        $component = Component::find($request->component);

        if($request->user()->id == $request->student){
            // student
            $student    = User::find($request->student);
            $teachers   = $student->studentTeachers();
            $url        = '/back-end/writing/show?component=' . $request->component . '&book=' . $request->book . '&student=' . $request->student;
            $message    =  $book->title . '<br>' . $component->parent->name . '<br>' . $component->name;

            foreach($teachers as $teacher){
                $teacher->notify(new TeacherComponentCommentNotification($student, $url, $message));
            }
            
            Notification::send(User::whereIn('type', ['administrator', 'sub-administrator'])->whereBranchId($student->branch_id)->get(), new TeacherComponentCommentNotification($student, $url, $message));
        }else{
            // admin or teacher
            $student    = User::find($request->student);
            $teacher    = Auth::user();
            $url        = '/my-dashboard/essay/' . $request->book . '?component='. $request->component;
            $message    =  $book->title . '<br>' . $component->parent->name . '<br>' . $component->name;
            $student->notify(new StudentComponentCommentNotification($teacher, $url, $message));
        }

        return new CommentResource($comment);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $comment = ComponentComment::find($id);
        $comment->message = $request->message;
        $comment->save();
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ComponentComment::find($id)->delete();
    }

}
