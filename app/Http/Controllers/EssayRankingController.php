<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Writing;
use App\Models\EssayRank;
use Illuminate\Http\Request;
use App\Models\ComponentScore;
use Illuminate\Support\Facades\DB;

class EssayRankingController extends Controller
{

    function index(Request $request){
        $month = $request->month ? Carbon::parse($request->month)->format('Y-m') : Carbon::now()->subMonths(1)->format('Y-m');
        $singleMonth = Carbon::parse($month)->month;
        $singleYear = Carbon::parse($month)->year;

        $rank = $request->rank == 2 ? 1 : 0;

        $prevMonth = Carbon::now()->subMonth(1)->format('Y-m');
        $list = array();

        for($i = 0; $i < 7; $i++){
            $monthHere = Carbon::parse($prevMonth)->subMonth($i)->format('Y-m');
            $array = [
                'month' => $monthHere,
                'ranks' => [
                            [
                                'month' => $monthHere,
                                'rank' => 1,
                                'student' => $this->getStudentRankPerMonth($monthHere, 0)
                            ],
                            [
                                'month' => $monthHere,
                                'rank' => 2,
                                'student' => $this->getStudentRankPerMonth($monthHere, 1)
                            ],
                        ]
            ];

            array_push($list, $array);
        }


        $selected = EssayRank::where('month', $month)->whereRank($rank)->first();

        // return $month;
        if($selected){
          $item = $selected;
        }else{
            $items  =  ComponentScore::whereMonth('created_at', $singleMonth)->whereYear('created_at', $singleYear)->groupBy('book_id', 'user_id')->orderBy('rating','DESC')->limit(2)->get()
                ->sortBy(function($q) use ($month){
                    return $q->student->componentScores()->whereMonth('created_at', $month)->avg('rating');
                })
                ->sortBy(function($q) use ($month){
                    return $q->book->writings()->whereMonth('created_at', $month)->count();
                });

            if(count($items)){
                $item = $items[$rank];
            }else{
                return view('site.essay-rank.show', compact('rank', 'list'));
            }
        }

        if($item){
            $book = $item->book;
            $activecomponent = $item->component;
            $student = $item->student;

            if($activecomponent && $book){
                $data = [];
                $writings =  Writing::select(DB::raw('t.*'))
                            ->from(\DB::raw('(SELECT * FROM writings ORDER BY created_at DESC) t'))
                            ->where('user_id', $item->student->id)
                            ->where('component_id', $activecomponent->id)
                            ->where('book_id', $book->id)
                            ->groupBy('t.input')
                            ->get();

                foreach($writings as $writing){
                    $writingData = $writing->data;

                    if(isset($data[$writing->input])){
                        $writingData['id'] = $writing->id;
                        array_push($data[$writing->input], $writingData);
                    }
                    else{
                        $writingData['id'] = $writing->id;
                        $data[$writing->input] = [$writingData];
                    }
                }

                if($activecomponent->type == "summary"){
                    $defaults = Writing::where('student', $item->student->id)->where('component_id', $activecomponent->id)->where('book_id', $book->id)->whereIn('input', $activecomponent->inputs)->orderBy('input')->orderBy('created_at', 'ASC')->get();
                    $defaultText = '';

                    //get siblings component
                    $parent = $activecomponent->parent;
                    $siblings =  $parent->children()->where('id', '!=', $activecomponent->id)->get()->filter(function($q) use ($activecomponent){
                        foreach($activecomponent->inputs as $input){
                            return in_array('Form', $q->inputs);
                        }
                    });

                    foreach($siblings as $sibling){
                        $siblingWriting = Writing::where('student', $item->student->id)->where('user_id', $item->student->id)->where('component_id', $sibling->id)->where('book_id', $book->id)->whereIn('input', ['Form'])->orderBy('input')->orderBy('updated_at', 'DESC')->first();
                        if($siblingWriting){
                                $siblingWritingData = $siblingWriting->data;
                                $defaultText .= $siblingWritingData['summary'] . PHP_EOL . PHP_EOL ;
                        }
                    }

                    $data['default_value'] = $defaultText;
                    array_push($data, $data['default_value']);
                }
                $rank = $rank == 0 ? 1 : 2;
                return view('site.essay-rank.show', compact('book', 'activecomponent', 'data', 'student','month', 'rank', 'list'));

            }
        }else{
            $rank = $rank == 0 ? 1 : 2;
            return view('site.essay-rank.show', compact('month', 'rank', 'list'));
        }


        // return view('site.essay-rank.show', compact('book', 'activecomponent', 'data'));
    }


    function getStudentRankPerMonth($date, $rank){
        $month = Carbon::parse($date)->format('m');
        $year = Carbon::parse($date)->format('Y');
        $items = User::selectRaw("*, (select sum(rating) from component_scores where `users`.`id` = `component_scores`.`user_id` and month(`created_at`) = ? and year(`created_at`) = ?) as score", [$month, $year])
                    ->whereHas("componentScores", function($q) use ($month, $year){
                            $q->whereMonth('created_at', $month)
                                ->whereYear('created_at', $year);
                    })
                    ->where("type", "student")
                    ->orderBy("score", 'DESC')
                    ->limit(5)
                    ->get();
        if(count($items)){
            return $items[$rank]  ?? null;
        }

        return null;
    }

}
