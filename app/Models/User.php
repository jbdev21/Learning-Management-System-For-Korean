<?php

namespace App\Models;

use Auth;
use Cache;
use DateTime;
use App\Traits\HasPhoto;
use Laravel\Scout\Searchable;
use App\Traits\HasBranchScope;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasPhoto, HasBranchScope;

    public $asYouType = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();
        return $array;
    }


    function studentData(){
        return $this->hasOne(StudentInfo::class);   
    }

    function getDataAttribute(){
        return optional($this->studentData)->data;
    }

    function getClassesAttribute(){
        return $this->classrooms->implode('name',' / ');

        foreach($this->classrooms as $rooms){
            $room .= $rooms->name;
            $counter++;

            // for last '/'
            if($count > $counter){
                $room .=  ' / ';
            }
        }

        return $room;
    }

    function getGradeAttribute(){
        return $this->studentData->data->grade ?? '';
    }

    function chartData(){
        return $this->hasMany(ChartBookComponentData::class);
    }

    function recordings(){
        return $this->hasMany(Recording::class);
    }



    function userRecordingCommentCheck(Recording $recording){
        return $recording->comments->count() ? true : false;
    }


    function cellData($book, $cell){
        $data = $this->chartData()->whereBookId($book)->whereCell($cell)->first();
        if($data){
            if($this->validateDate($data->data)){
                return date('y/m/d', strtotime($data->data));
            }else{
                return $data->data;
            }
        }

        return  false;
    }

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }


    function tasks(){
        return $this->hasMany(Task::class);
    }

    function diaries(){
        return $this->hasMany(Diary::class);
    }

    function getAvatarAttribute(){
        return Cache::rememberForever('user-avatar-' . $this->id, function(){
            $avatar = $this->photos()->whereType('avatar')->first();
            if($avatar){
                $path = public_path('uploads/avatar/', $avatar->path);
                if(file_exists($path)){
                    return "/uploads/avatar/" . $avatar->path;
                }else{
                    return '/placeholders/avatar.png';
                }
            }else{
                return '/placeholders/avatar.png';
            }
        });
    }

    function assessment($key){
        $assessments = $this->studentData->assessments ?? '';
        if($assessments){
            foreach($this->studentData->assessments as $index => $value){
                if($index == $key){
                    return $value;
                }
            }
        }else{
            return '';
        }
    }

    function subjectsEnglishBackground(){
        $array = array();
        return ($this->studentData->english_background->subjects) ?? [];
    }

    function  getBookAccessAttribute(){
        return optional($this->studentData)->book_access;
    }

    function getEnglishBackgroundAttribute(){
        return optional($this->studentData)->english_background;
    }


    function branch(){
        return $this->belongsTo(Branch::class);
    }


    function classrooms(){
        return $this->belongsToMany(ClassRoom::class);
    }

    function quizes(){
        return $this->belongsToMany(Quiz::class);
    }

    function quizCompleted($quiz){
        $quizQuestions = Quiz::find($quiz)->questions()->count();

        if(!$quizQuestions){
            return false;
        }

        $answers = $this->answers()->whereHas('question', function($q) use ($quiz){
                $q->whereQuizId($quiz);
        })->count();

        return $quizQuestions == $answers;
    }



    function componentWritings($book, $component){
        return Writing::where('student', $this->id)->where('component_id', $component)->where('book_id', $book);
    }

    function componentScores(){
        return $this->hasMany(ComponentScore::class);
    }

    function studentTeachers(){
        $ids = array();
        foreach($this->classrooms as $room){
            $teachers = ClassRoom::find($room->id)->teachers;
            foreach($teachers as $teacher){
                if(!in_array($teacher->id, $ids)){
                    array_push($ids, $teacher->id);
                }
            }
        }

        return User::find($ids);
    }

    function getTeacherStudentsAttribute(){
        $ids = array();
        foreach($this->classrooms as $room){
            $students = ClassRoom::find($room->id)->students;
            foreach($students as $student){
                if(!in_array($student->id, $ids)){
                    array_push($ids, $student->id);
                }
            }
        }

        return User::find($ids);
    }

    function getTeacherStudentListAttribute(){
        $ids = array();
        foreach($this->classrooms as $room){
            $students = ClassRoom::find($room->id)->students;
            foreach($students as $student){
                if(!in_array($student->id, $ids)){
                    array_push($ids, $student->id);
                }
            }
        }

        return User::whereIn('id', $ids);
    }


    function lastWriting($book = null){
        if($book){
            return Writing::whereBookId($book)->whereStudent($this->id)->orderBy('updated_at', 'DESC')->first();
        }else{
            return Writing::whereStudent($this->id)->orderBy('updated_at', 'DESC')->first();
        }
    }



    function quizScore($quiz, $itemized = null){
        $quizQuestions = Quiz::find($quiz)->questions()->count();

        if(!$quizQuestions){
            return false;
        }

        $correct = $this->answers()->whereHas('question', function($q) use ($quiz){
                $q->whereQuizId($quiz)->where('correct', 1);
        })->count();

        if($itemized){
            if($itemized == "correct"){
                return $correct;
            }
            return $quizQuestions;
        }
        return $correct.'/'. $quizQuestions;
    }



    function answers(){
        return $this->hasMany(Answer::class);
    }



    function exercises(){
        return $this->hasMany(Excercise::class);
    }


    function writings(){
        return $this->hasMany(Writing::class);
    }


    function examinations(){
        return $this->hasMany(Examination::class);
    }
}
