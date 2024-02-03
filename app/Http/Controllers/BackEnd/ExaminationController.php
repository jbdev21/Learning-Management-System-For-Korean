<?php

namespace App\Http\Controllers\BackEnd;

use Auth;
use App\Models\Quiz;
use App\Models\Examination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExaminationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $studentList = Auth::user()->teacherStudentList->whereBranchId(Auth::user()->branch_id)->pluck('id')->toArray();
        $examinations = Examination::orderBy('id', 'DESC')
                                ->when($request->user()->type == "teacher", function($query) use ($studentList) {
                                    return $query->whereHas('user', function($query) use ($studentList){
                                        $query->whereIn('id', $studentList);
                                    });
                                })
                                ->when($request->quiz, function($query) use ($request) {
                                    return $query->where('quiz_id', $request->quiz);
                                })
                                ->when($request->q, function($query) use ($request) {
                                    return $query->whereHas('user', function($query) use ($request){
                                        $query->where('username', $request->q);
                                    });
                                })
                                ->latest()
                                ->with(['quiz', 'user'])
                                ->paginate(10);
        $quizzes = Quiz::all();
        return view('back-end.examination.index', compact('examinations', 'quizzes'));
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
     * @param  \App\Models\Examination  $examination
     * @return \Illuminate\Http\Response
     */
    public function show(Examination $examination)
    {
        $quiz = $examination->quiz;
        $questions = $examination->quiz->questions;
        return view('back-end.examination.result', compact('quiz', 'questions', 'examination'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Examination  $examination
     * @return \Illuminate\Http\Response
     */
    public function edit(Examination $examination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Examination  $examination
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Examination $examination)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Examination  $examination
     * @return \Illuminate\Http\Response
     */
    public function destroy(Examination $examination)
    {
        //
    }
}
