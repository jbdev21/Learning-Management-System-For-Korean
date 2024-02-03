<?php

namespace App\Http\Controllers\BackEnd;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\StudentRank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\StudentRankingService;

class StudentRankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $selectedMonth = $request->month ?? date('Y-m');

        $ranks = (new StudentRankingService)->rank(date('m', strtotime($selectedMonth)), date('Y', strtotime($selectedMonth)))->take(2)->get();
        $firstStudent =  "";
        $secondStudent =  "";
        if($ranks->count()){
            $firstStudent =  $ranks[0];
            $secondStudent =  $ranks[1];
        }

        $ranks = StudentRank::whereHas('student', function($q){
                                $q->branched();
                            })->groupBy('month')
                                ->orderBy('month', 'DESC')
                                ->get()
                                ->values()
                                ->map(function($q){
                                    return [
                                        'id' => $q->id,
                                        'month' => $q->month,
                                        'ranks' => StudentRank::has('student')->where('month', $q->month)->orderBy('rank')->get()->map(function($q){
                                            return [
                                                'student' => $q->student->username . ' ('. $q->student->name . ')',
                                                'rank'    => $q->rank
                                            ];
                                        })
                                    ];
                                })->paginate(12);

        $students = User::branched()->where('type','student')->get();
        return view('back-end.ranking.student.index', compact('ranks', 'students', 'firstStudent','secondStudent'));
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
            'month' => 'required',
            'first_id' => 'required|integer',
            'second_id' => 'required|integer',
        ]);

        $month = Carbon::parse($request->month)->format('Y-m-d');

        // Remove duplicate
        StudentRank::where('month', $month)->delete();

        $studentRank = new StudentRank;
        $studentRank->user_id = $request->first_id;
        $studentRank->month = $month;
        $studentRank->rank = 1;
        $studentRank->save();
        
        $studentRank2 = new StudentRank;
        $studentRank2->user_id = $request->second_id;
        $studentRank2->month = $month;
        $studentRank2->rank = 2;
        $studentRank2->save();

        return back();
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
    public function edit(Request $request, $id)
    {
        $month = $id;
        $monthFormat = date('Y-m', strtotime($month));
        
        $firstId =  $this->getFirst($month)['id'] ?? null;
        
        $firstStudentData = StudentRank::where('month', $id)->whereRank(1)->first();
        $secondStudent = StudentRank::where('month', $id)->whereRank(2)->first();

        if($firstStudentData){
            $firstStudent = $firstStudentData;
        }else{
            $firstStudent = User::find($firstId);
        }

        $students = User::where('branch_id', Auth::user()->branch_id)->where('type','student')->get();
        return view('back-end.ranking.student.edit', compact('month', 'firstStudent','monthFormat', 'secondStudent', 'students'));
        
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
            'month' => 'required',
            'first_id' => 'required|integer',
            'second_id' => 'required|integer',
        ]);

        $studentRank = StudentRank::where('month', $id)->where('rank', 1)->first();
        $studentRank->user_id = $request->first_id;
        $studentRank->month = $id;
        $studentRank->rank = 1;
        $studentRank->save();
        
        $studentRank2 = StudentRank::where('month', $id)->where('rank', 2)->first();
        $studentRank2->user_id = $request->second_id;
        $studentRank2->month = $id;
        $studentRank2->rank = 2;
        $studentRank2->save();

        return redirect()->route('back-end.student-rank.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ranks = StudentRank::where('month', $id)->delete();
        return back();
    }


    function getFirst($month){
        
        return User::whereHas('componentScores')->take(2)->get()
            ->filter(function($q, $e) use($month){
                return $q->componentScores()->where('created_at','LIKE', '%' .$month . '%')->avg('rating') > 0;
            })
            ->sortByDESC(function($q, $e) use($month){
                return $q->componentScores()->where('created_at','LIKE', '%' .$month . '%')->avg('rating');
            }) ?? null;
      
    }
}
