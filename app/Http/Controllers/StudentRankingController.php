<?php

namespace App\Http\Controllers;

use App\Models\StudentRank;
use Illuminate\Http\Request;

class StudentRankingController extends Controller
{
  function index(){
    $ranks = StudentRank::groupBy('month')->orderBy('month', 'DESC')->get()->values()->map(function($q){
            return [
                'id' => $q->id,
                'month' => $q->month,
                'ranks' => StudentRank::where('month', $q->month)->orderBy('rank')->has('student')->get()->map(function($q){
                    return [
                        'student' => $q->student->username . ' ('. makeStarInString($q->student->name) . ')',
                        'rank'      => $q->rank
                    ];
                })
            ];
        })->paginate(12);
    return view('site.student-rank.index', compact('ranks'));
  }
}
