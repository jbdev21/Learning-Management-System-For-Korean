<?php

namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Banner;
use App\Models\Notice;
use App\Models\Writing;
use App\Models\StudentRank;
use Illuminate\Http\Request;
use App\Models\ComponentScore;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $require_login = false;

        if(Session::get('require_login')){
            Session::forget('require_login');
            $require_login = true;
        }

        $notices = Notice::whereIsPublished(1)->whereType('notice')->branched()->take(8)->orderBy('created_at', 'DESC')->get();
        $grammars = Notice::whereIsPublished(1)->whereType('grammar')->branched()->take(8)->orderBy('created_at', 'DESC')->get();

        $now = date('Y-m-d');
        $banners = Banner::whereBranchId(1)->branched()->whereDate('show_start','<=', $now)->whereDate('show_end', '>=', $now)->whereIsShow(1)->get();

        $month = $this->getMonth();

        $students = User::where('type','student')->branched()->get()->sortByDesc(function($q) use ($month){
                        return $q->componentScores()->avg('rating');
                    });

        $rankLastMonth = StudentRank::orderBy('month','DESC')->first();
        $firstStudentRank = StudentRank::where('month', 'LIKE', '%' . optional($rankLastMonth)->month . '%')->whereRank(1)->has('student')->first();
        $secondStudentRank = StudentRank::where('month', 'LIKE', '%' . optional($rankLastMonth)->month . '%')->whereRank(2)->has('student')->first();

        $studentRanks = StudentRank::groupBy('month')->orderBy('month', 'DESC')
                            ->whereHas('student', function($q){
                                $q->where('branch_id', domainBranch()->id);
                            })->limit(3)->get()->values()->map(function($q){
                                return [
                                    'id' => $q->id,
                                    'month' => $q->month,
                                    'ranks' => StudentRank::where('month', $q->month)->has('student')->orderBy('rank')->get()->map(function($q){
                                        return [
                                            'student' => $q->student->username . ' ('. makeStarInString($q->student->name) . ')',
                                            'rank'      => $q->rank
                                        ];
                                    })
                                ];
                            });

        return view('home', compact('studentRanks', 'notices','grammars', 'require_login', 'banners', 'firstStudentRank', 'secondStudentRank'));
    }

    function getMonth(){
        $month = Carbon::now()->month;
        if($month == 1){
            return Carbon::now()->subYears(1)->subMonths(1)->format('Y-m-d');
        }else{
            return Carbon::now()->subMonths(1)->format('Y-m-d');
        }
    }


    function rank(Request $request){
        $items  =  ComponentScore::groupBy('book_id', 'user_id')->orderBy('rating','DESC')->limit(2)->get()
            ->sortBy(function($q){
                return $q->student->componentScores()->avg('rating');
            })
            ->sortBy(function($q){
                return $q->book->writings()->count();
            });
        $item = $items[0];

            $book = $item->book;
            $activecomponent = $item->component;

            if($activecomponent){
                $writings =  Writing::where('student', $item->student->id)->where('component_id', $activecomponent->id)->where('book_id', $book->id)->orderBy('input')->orderBy('created_at', 'ASC')->get();

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
                return view('site.essay-rank.show', compact('book', 'activecomponent', 'data'));

            }

            // return view('student.essay.show', compact('book', 'components'));

        return view('site.essay-rank.show', compact('data'));
    }

    function noticeIndex(Request $request){
        $type = $request->type ?? 'notice';
        $notices = Notice::whereIsPublished(1)->whereType($type)->orderBy('created_at', 'DESC')->paginate(15);
        return view('site.notice.index', compact('notices'));
    }

    public function noticeShow($id){
        $notice = Notice::find($id);


        // get previous user id
        $previous = Notice::where('id', '<', $notice->id)->whereType($notice->type)->orderBy('id','DESC')->first();

        // get next user id
        $next = Notice::where('id', '>', $notice->id)->whereType($notice->type)->orderBy('created_at', 'ASC')->first();

        return view('site.notice.show', compact('notice', 'previous','next'));
    }

// June 30, 2020 - update task by Niel - ABOUT PAGE INDEX
    function aboutIndex(Request $request){

        return view('site.about.index');
    }

    function aboutTemplate2(Request $request){

        return view('site.about.template2');
    }

    function aboutTemplate3(Request $request){

        return view('site.about.template3');
    }


}
