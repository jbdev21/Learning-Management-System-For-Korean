<?php

namespace App\Http\Controllers\BackEnd;

use DB;
use Auth;
use App\Models\Diary;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $branch = $request->branch ?? domainBranch()->id;
        $query = Diary::select('diaries.*','diaries.id as diary_id', 'users.*', 'users.username as username', 'users.name as student_name', 'branches.center_name as branch_name');
        
        $query->join('users', 'users.id', '=', 'diaries.user_id')
                ->join('branches', 'branches.id', 'users.branch_id')
                ->where('branches.id', $branch);
        

        if($request->studentName){
            $q->where('users.name', 'LIKE', '%' . $request->studentName .'%')
                    ->orWhere('users.username', 'LIKE', '%' . $request->studentName . '%');
            
        }

        if($request->title){
            $query->where('diaries.title', 'LIKE', '%' . $request->title . '%');
        }
        
        if($request->date_from && !$request->date_to){
            $query->whereDate('diaries.date', $request->date_from);
        }
        

        if($request->student){
            $query->where('diaries.user_id', $request->student);
        }

        if($request->date_from && $request->date_to){
            $query->WhereBetween('date', [$request->date_from, $request->date_to]);
        }
        
        if(auth()->user()->type == 'administrator' || auth()->user()->type == 'sub-administrator'){
            $diaries = $query->orderBy('diaries.date', 'DESC')->paginate(25);
        }else{
            $students = auth()->user()->teacher_students->pluck('id');
            
            $diaries = $query->whereHas('user', function($q) use ($students){
                $q->whereIn('id', $students);
            })->orderBy('date', 'DESC')->paginate(25);
        }


        // return $diaries;
        
        if(Auth::user()->type == "administrator"){
            $branches = DB::table('branches')->get();
            return view('back-end.diary.index', compact('diaries', 'branches'));
        }


        return view('back-end.diary.index', compact('diaries'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $diary = Diary::find($id);
        $pagetitle = $diary->user->name . ' diary @'. $diary->date;
        $student = $diary->user;
        $diaries = Diary::whereUserId($diary->user_id)->whereDate('date', $diary->date)->get();
        
        // get previous user id
        $previous = Diary::whereUserId($diary->user_id)->whereDate('date', '<', $diary->date)->orderBy('date', 'DESC')->first();

        // get next user id
        $next = Diary::whereUserId($diary->user_id)->whereDate('date', '>', $diary->date)->orderBy('date', 'ASC')->first();

        return view('back-end.diary.show', compact('diaries', 'pagetitle', 'student', 'previous', 'next'));
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
    public function destroy($id)
    {
        $diary = Diary::find($id);
        $diary->delete();
        if(!request()->ajax()){
            return back();
        }
    }
}
