<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\StudentInfo;
use DB;
use App\Models\User;
use App\Models\Grading;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gradings = Grading::latest()->paginate(25);
        return view('back-end.grading.index', compact('gradings'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        DB::transaction(function() use ($request){
            Grading::create([
                'note'      => $request->note,
                'type'      => $request->type ?? 'accelerate',
                'user_id'   => $request->user()->id
            ]);

            User::whereNotIn('id', $request->excluded ?? [])
                ->whereType('student')
                ->branched()
                ->each(function($q) use ($request) {
                    if(optional($q->data)->grade){
                        if(is_numeric($q->data->grade)){
                            if($request->type == "accelerate"){
                                if($q->data->grade < 9) {
                                    $newData = [
                                        'parent_contact_number' => $q->data->parent_contact_number,
                                        'school_name' => $q->data->school_name,
                                        'remarks' => $q->data->remarks,
                                        'grade' => $q->data->grade + 1
                                    ];

                                    $studentData = StudentInfo::where('user_id', $q->id)->first();
                                    $studentData->data = $newData;
                                    $studentData->save();

                                    $q->increment('grade');
                                }
                            }else{
                                $q->decrement('grade');
                            }
                        }else{
                            if($q->grade == "kinder"){
                                $newData = [
                                    'parent_contact_number' => $q->data->parent_contact_number,
                                    'school_name' => $q->data->school_name,
                                    'remarks' => $q->data->remarks,
                                    'grade'   => 1
                                ];

                                $studentData = StudentInfo::where('user_id', $q->id)->first();
                                $studentData->data = $newData;
                                $studentData->save();
                            }
                        }
                    }
                });
        });

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
        //
    }
}
