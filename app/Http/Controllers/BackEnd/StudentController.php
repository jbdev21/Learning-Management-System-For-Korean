<?php

namespace App\Http\Controllers\BackEnd;

use DB;
use Auth;
use Excel;
use DateTime;
use DataTables;
use App\Models\Book;
use App\Models\User;
use App\Models\Branch;
use App\Models\Subject;
use App\Models\Writing;
use App\Models\ClassRoom;
use App\Models\Examination;
use App\Models\StudentInfo;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use App\Exports\StudentsExport;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;
use App\Models\ChartBookComponentData;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $branch = request()->branch ?? auth()->user()->branch_id;
        $classRooms = ClassRoom::all();

        if(Auth::user()->type == "administrator"){
            $studentList = User::where('branch_id', $branch)->where('type', 'student');
            $ongoing =  DB::table('users')->where('type', 'student')->where('status','on-going')->count();
            $waiting =  DB::table('users')->where('type', 'student')->where('status','waiting')->count();;
            $onleave =  DB::table('users')->where('type', 'student')->where('status','on-leave')->count();
        }else if(Auth::user()->type == "sub-administrator"){
            $studentList = User::where('branch_id', $branch )->where('type', 'student')->whereBranchId(Auth::user()->branch_id);
            $ongoing =  User::whereType('student')->whereStatus('on-going')->whereBranchId(Auth::user()->branch_id)->count();
            $waiting =  User::whereType('student')->whereStatus('waiting')->whereBranchId(Auth::user()->branch_id)->count();
            $onleave = User::whereType('student')->whereStatus('on-leave')->whereBranchId(Auth::user()->branch_id)->count();
        }else{
            $studentList = Auth::user()->teacherStudentList->whereBranchId(Auth::user()->branch_id);
            $ongoing =  Auth::user()->teacherStudentList->whereBranchId(Auth::user()->branch_id)->whereStatus('on-going')->count();
            $waiting =  Auth::user()->teacherStudentList->whereBranchId(Auth::user()->branch_id)->whereStatus('waiting')->count();
            $onleave = Auth::user()->teacherStudentList->whereBranchId(Auth::user()->branch_id)->whereStatus('on-leave')->count();
        }

        if(request()->name){
            $studentList->where('name', 'LIKE', '%' . request()->name . '%')
                ->orWhere('username', 'LIKE', '%' . request()->name . '%');
        }

        if(request()->mobile){
            $studentList->where('contact_number', 'LIKE', '%' . request()->mobile . '%');
        }

        if(request()->status){
            $studentList->where('status', request()->status);
        }

        if(request()->class){
            $studentList->join('class_room_user', 'users.id', '=', 'class_room_user.user_id')
                    ->where('class_room_user.class_room_id', request()->class);
        }

        $students = $studentList->orderBy('status')
                        ->branched()
                        ->with('studentData')
                        ->with('classrooms')
                        ->orderBy('name')
                        ->paginate(25);
        return view('back-end.student.index', compact('students', 'classRooms', 'onleave', 'waiting', 'ongoing'));
    }


    function downloadExcel(){
       return Excel::download(new StudentsExport, 'students.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classrooms = ClassRoom::all();
        $book_series = Book::groupBy('type_name')->pluck('type_name');
        $branches = Branch::all();
        return view('back-end.student.create.step1', compact('classrooms', 'book_series', 'branches'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('excelfile')){
            // User::whereType('student')->where('id', '>', 180)->delete();
            Excel::import(new StudentImport, $request->file('excelfile'));
            return redirect()->route('back-end.student.index');
        }

        $this->validate($request, [
            'username' => 'required|unique:users',
            'name'     => 'required',
            'grade'     => 'required',
            'email'     => 'email|unique:users|nullable'
        ]);

        $student = new User;
        $student->branch_id = $request->branch_id ?? $request->user()->branch_id;
        $student->username = $request->username;
        $student->email = $request->email;
        $student->gender = $request->gender;
        $student->type = "student";
        $student->name = $request->name;
        $student->contact_number = $request->contact_number;
        $student->status = $request->status;
        $student->password = $request->password ? bcrypt($request->password) : bcrypt('password');

        $student->save();

        $studentdata = new StudentInfo;
        $studentdata->ar_level = $request->ar_level;
        $studentdata->data = $request->only(['parent_contact_number', 'school_name', 'grade', 'remarks']);
        $student->studentData()->save($studentdata);

        return redirect()->route('back-end.student.edit.step2', $student->id);
    }

    function step2(Request $request){
        $student = User::find($request->student);
        $subjects = Subject::all();
        $book_series = Book::groupBy('type_name')->pluck('type_name', 'id');
        return view('back-end.student.create.step2', compact('student', 'subjects', 'book_series'));
    }

    // storing assessments
    function step2Store(Request $request, $id){
        $student = User::find($id);
        $currentData = $student->studentData;

        // putting all book access
        $currentData->assessments = $request->except(['_token', '_method','series']);
        $currentData->book_access = $request->series;

        $currentData->save();
        return redirect()->route('back-end.student.create.step3', ['student' => $student->id]);
    }


    function step3(Request $request){
        $student = User::find($request->student);
        $subjects = Subject::all();
        return view('back-end.student.create.step3', compact('student', 'subjects'));
    }

    function step3Store(Request $request, $id){
        $student = User::find($id);
        $currentData = $student->studentData;
        $currentData->english_background = $request->except(['_token', '_method']);
        $currentData->save();
        return redirect()->route('back-end.student.index');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $student = User::find($id);
        $studentId = $student->id;
        $books =  Book::query()
                ->whereIn('type_name', $student->book_access ?? [])
                ->addSelect(['status' => function($query) use ($studentId){
                    $query->selectRaw("case when (SELECT count(*) FROM book_scores where book_scores.book_id = books.id and book_scores.user_id = $studentId) > 0 then 'Done' when (SELECT count(*) FROM component_scores where component_scores.book_id = books.id and component_scores.user_id = $studentId) > 0 then 'Onjoing' else 'Pending' end");
                }])
                ->addSelect(['class_rooms' => function($query) use ($studentId){
                    $query->selectRaw("(select GROUP_CONCAT(name order by name SEPARATOR ' / ') from `class_rooms` join `class_room_user` on `class_room_user`.`class_room_id` = `class_rooms`.`id` where `class_room_user`.`user_id` = $studentId) ");
                }])
                //cells data
                    ->addSelect(['first_data_cell' => function($query) use ($studentId) {
                        $query->from('chart_book_component_data')
                                ->selectRAW('DATE_FORMAT(chart_book_component_data.data, "%y/%m/%d") as last_update')
                                ->where('cell', 'Word(본문)')
                                ->whereColumn('chart_book_component_data.book_id', 'books.id')
                                ->where('chart_book_component_data.user_id', $studentId)
                                ->limit(1);
                    }])
                    ->addSelect(['second_data_cell' => function($query) use ($studentId) {
                        $query->from('chart_book_component_data')
                                ->selectRAW('DATE_FORMAT(chart_book_component_data.data, "%y/%m/%d") as last_update')
                                ->where('cell', 'sound')
                                ->whereColumn('chart_book_component_data.book_id', 'books.id')
                                ->where('chart_book_component_data.user_id', $studentId)
                                ->limit(1);
                    }])
                    ->addSelect(['third_data_cell' => function($query) use ($studentId) {
                        $query->from('chart_book_component_data')
                                ->selectRAW('DATE_FORMAT(chart_book_component_data.data, "%y/%m/%d") as last_update')
                                ->where('cell', 'Text(본문) Dictation/Puzzle')
                                ->whereColumn('chart_book_component_data.book_id', 'books.id')
                                ->where('chart_book_component_data.user_id', $studentId)
                                ->limit(1);
                    }])
                    ->addSelect(['fourth_data_cell' => function($query) use ($studentId) {
                        $query->from('chart_book_component_data')
                                ->selectRAW('DATE_FORMAT(chart_book_component_data.data, "%y/%m/%d") as last_update')
                                ->where('cell', '(Word Test; Text)')
                                ->whereColumn('chart_book_component_data.book_id', 'books.id')
                                ->where('chart_book_component_data.user_id', $studentId)
                                ->limit(1);
                    }])
                    ->addSelect(['fifth_data_cell' => function($query) use ($studentId) {
                        $query->from('chart_book_component_data')
                                ->selectRAW('DATE_FORMAT(chart_book_component_data.data, "%y/%m/%d") as last_update')
                                ->where('cell', '(Word Test; Plus)')
                                ->whereColumn('chart_book_component_data.book_id', 'books.id')
                                ->where('chart_book_component_data.user_id', $studentId)
                                ->limit(1);
                    }])
                    ->addSelect(['sixth_data_cell' => function($query) use ($studentId) {
                        $query->from('chart_book_component_data')
                                ->selectRAW('DATE_FORMAT(chart_book_component_data.data, "%y/%m/%d") as last_update')
                                ->where('cell', 'teacher-arp-comment')
                                ->whereColumn('chart_book_component_data.book_id', 'books.id')
                                ->where('chart_book_component_data.user_id', $studentId)
                                ->limit(1);
                    }])
                // end cell data

                ->addSelect(['improving_prediction' => function($query)  use ($studentId) {
                    $query->from('writings')
                        ->selectRAW('DATE_FORMAT(writings.updated_at, "%d/%m/%Y") as last_update')
                        ->whereColumn('writings.book_id', 'books.id')
                        ->whereIn('component_id', [4])
                        ->where('student', $studentId)
                        ->orderBy('writings.updated_at', 'desc')
                        ->limit(1);
                }])
                ->addSelect(['after_reading_basic' => function($query)  use ($studentId) {
                    $query->from('writings')
                        ->selectRAW('DATE_FORMAT(writings.updated_at, "%d/%m/%Y") as last_update')
                        ->whereColumn('writings.book_id', 'books.id')
                        ->whereIn('component_id', [8])
                        ->where('student', $studentId)
                        ->orderBy('writings.updated_at', 'desc')
                        ->limit(1);
                }])
                ->addSelect(['after_reading_beginning' => function($query)  use ($studentId) {
                    $query->from('writings')
                        ->selectRAW('DATE_FORMAT(writings.updated_at, "%d/%m/%Y") as last_update')
                        ->whereColumn('writings.book_id', 'books.id')
                        ->whereIn('component_id', [5])
                        ->where('student', $studentId)
                        ->orderBy('writings.updated_at', 'desc')
                        ->limit(1);
                }])
                ->addSelect(['after_reading_middle' => function($query)  use ($studentId) {
                    $query->from('writings')
                        ->selectRAW('DATE_FORMAT(writings.updated_at, "%d/%m/%Y") as last_update')
                        ->whereColumn('writings.book_id', 'books.id')
                        ->whereIn('component_id', [7])
                        ->where('student', $studentId)
                        ->orderBy('writings.updated_at', 'desc')
                        ->limit(1);
                }])
                ->addSelect(['after_reading_end' => function($query)  use ($studentId) {
                    $query->from('writings')
                        ->selectRAW('DATE_FORMAT(writings.updated_at, "%d/%m/%Y") as last_update')
                        ->whereColumn('writings.book_id', 'books.id')
                        ->whereIn('component_id', [8])
                        ->where('student', $studentId)
                        ->orderBy('writings.updated_at', 'desc')
                        ->limit(1);
                }])
                ->addSelect(['after_reading_skimming' => function($query)  use ($studentId) {
                    $query->from('writings')
                        ->selectRAW('DATE_FORMAT(writings.updated_at, "%d/%m/%Y") as last_update')
                        ->whereColumn('writings.book_id', 'books.id')
                        ->whereIn('component_id', [11])
                        ->where('student', $studentId)
                        ->orderBy('writings.updated_at', 'desc')
                        ->limit(1);
                }])
                ->addSelect(['after_reading_organizer' => function($query)  use ($studentId) {
                    $query->from('writings')
                        ->selectRAW('DATE_FORMAT(writings.updated_at, "%d/%m/%Y") as last_update')
                        ->whereColumn('writings.book_id', 'books.id')
                        ->whereIn('component_id', [30, 31, 32, 33, 34])
                        ->where('student', $studentId)
                        ->orderBy('writings.updated_at', 'desc')
                        ->limit(1);
                }])
                ->get();
        return view('back-end.student.charts.' . $request->type, compact('books', 'student'));
    }


    public function updateBookComponentData(Request $request){
        $data = ChartBookComponentData::firstOrNew(['book_id' => $request->book_id, 'cell' => $request->cell, 'user_id' => $request->user_id]);

        if($request->date == "0000-00-00"){
            $data->delete();
        }else{
            $data->data = $request->data;
            $data->save();
        }


        if(!$request->ajax()){
            return back();
        }else{
            if($this->validateDate($data->data)){
                return date('y/m/d', strtotime($data->data));
            }else{
                return $data->data;
            }
        }
    }

    function examinations(Request $request, $student){
        $examinations = Examination::where('user_id', $student)
                        ->with(['lastExamination'])
                        ->withCount(['questions'])
                        ->latest()
                        ->get();
    }

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = User::find($id);
        $classrooms = ClassRoom::all();
        $book_series = Book::groupBy('type_name')->pluck('type_name');
        $branches = Branch::all();
        return view('back-end.student.edit.step1', compact('classrooms', 'book_series', 'branches', 'student'));
    }

    public function update(Request $request, $id){
         $this->validate($request, [
            'username' => 'required|unique:users,username,'. $id,
            'name'     => 'required',
            'grade'     => 'required',
            'email'     => 'nullable|email|unique:users,email,' . $id
        ]);

        $student = User::find($id);
        $student->branch_id = $request->branch_id ?? $request->user()->branch_id;
        $student->username = $request->username;
        $student->email = $request->email;
        $student->gender = $request->gender;
        $student->type = "student";
        $student->name = $request->name;
        $student->contact_number = $request->contact_number;
        $student->status = $request->status;

        if($request->password){
            $student->password = $request->password ? bcrypt($request->password) : bcrypt('password');
        }

        $student->save();

        $studentdata = $student->studentData;
        $studentdata->ar_level = $request->ar_level;
        $studentdata->data = $request->only(['parent_contact_number', 'school_name', 'grade', 'remarks']);
        $studentdata->save();
        // $student->studentData()->save($studentdata);

        return back()->with('success', 'Update Success');
    }


    function editStep2($id){
        $student = User::find($id);
        $student->studentData->book_access;
        $subjects = Subject::all();
        $book_series = Book::groupBy('type_name')->pluck('type_name','id');
        return view('back-end.student.edit.step2', compact('student', 'subjects', 'book_series'));
    }


    function updateStep2(Request $request, $id){

        $student = User::find($id);
        $currentData = $student->studentData;

        // putting all book access
        $currentData->assessments = $request->except(['_token', '_method','series']);
        $currentData->book_access = $request->series;

        $currentData->save();
        return back()->with('success','Update Success');
    }

    function editStep3($id){
        $student = User::find($id);
        $subjects = Subject::all();
        return view('back-end.student.edit.step3', compact('student', 'subjects'));
    }

    function updateStep3(Request $request, $id){
        $student = User::find($id);
        $currentData = $student->studentData;
        $currentData->english_background = $request->except(['_token', '_method']);
        $currentData->save();
        return back()->with('success','Update Success');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


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
                User::find($item)->delete();
            }
        }else{
            if($id){
                User::find($id)->delete();
            }
        }

        if(!$request->ajax()){
            return back()->with('success', 'Item deleted');
        }
    }
}
