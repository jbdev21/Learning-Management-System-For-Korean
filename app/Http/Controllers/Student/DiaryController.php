<?php

namespace App\Http\Controllers\Student;

use App\Models\Diary;
use App\Traits\HasComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiaryController extends Controller
{
    use HasComment;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('student.diary.index');
    }

    public function listApi(Request $request){
       return Diary::whereUserId($request->user()->id)->whereBetween('date', [$request->start, $request->end])->get();
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
            'date' => 'required|date',
            'title' => 'required'
        ]);

        $diary = new Diary;
        $diary->title = $request->title;
        $diary->message = $request->message;
        $diary->date = $request->date;
        $diary->user_id = $request->user()->id;
        $diary->save();

        if($request->ajax()){
           return response()->json([
               'id' => $diary->id,
               'title' => $diary->title,
               'message' => $diary->message,
               'date' => $diary->date,
           ], 200); 
        }else{
            return back();
        }
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

    public function diaryGet(Request $request){
        return Diary::find($request->diary);
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
        $this->validate($request, [
            'title' => 'required'
        ]);

        $diary = Diary::find($id);
        $diary->title = $request->title;
        $diary->message = $request->message;
        $diary->save();

        if($request->ajax()){
           return response()->json([
               'id' => $diary->id,
               'title' => $diary->title,
               'message' => $diary->message,
               'date' => $diary->date,
           ], 200); 
        }else{
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Diary::find($id)->delete();
        return response()->json(['message' => 'item Deleted'], 200);
    }
}
