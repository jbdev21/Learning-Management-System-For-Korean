<?php

namespace App\Models;

use App\Traits\HasImage;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Book extends Model
{

    use HasImage, Searchable;

    protected $guarded = [];

    public function toSearchableArray()
    {
        return $this->toArray();
    }

    function branch(){
        return $this->belongsTo(Branch::class);
    }

    function scores(){
        return $this->hasMany(BookScore::class);
    }

    function getThumbnailAttribute(){
        $thumbnail = $this->images()->whereType('thumbnail')->first();
        if($thumbnail){
            if($thumbnail->source_type == "local"){
                return "/images/thumbnail/" . $thumbnail->source;
            }else{
                return $thumbnail->source;
            }
        }else{
            return "https://blog.springshare.com/wp-content/uploads/2010/02/nc-md.gif";
        }
    }

    function isStudentCompleted($student_id){
        if($this->scores){
            return $this->scores->where('user_id', $student_id)->count();
        }
        return false;
    }

    function studentLastWriting($student){
        return Writing::where('student', $student)->where('book_id', $this->id)->orderBy('updated_at', 'DESC')->first();
    }

    function studentLastUpdateDatePerComponent($student, $componentId){
        if(is_array($componentId)){
            $lastUpdate = DB::table('writings')
                    ->whereIn('component_id', $componentId)
                    ->where('student', $student)
                    ->where('book_id', $this->id)
                    ->orderBy('updated_at', 'desc')
                    ->limit(1)
                    ->first();
            if($lastUpdate){
                return date('y/m/d', strtotime($lastUpdate->updated_at));
            }
            return '';
        }else{
            $lastUpdate = DB::table('writings')
                    ->where('component_id', $componentId)
                    ->where('student', $student)
                    ->where('book_id', $this->id)
                    ->orderBy('updated_at', 'desc')
                    ->limit(1)
                    ->first();
            if($lastUpdate) {
                return date('y/m/d', strtotime($lastUpdate->updated_at));
            }
        }

         return '';
    }

    function writings(){
        return $this->hasMany(Writing::class);
    }



    function bookStudentStatus($student_id, $html = true){
        $result = DB::table('books')
                ->addSelect(['status' => function($query) use ($student_id){
                    $query->selectRaw("case when (SELECT count(*) FROM book_scores where book_scores.book_id = books.id and book_scores.user_id = $student_id) > 0 then 'DONE' when (SELECT count(*) FROM writings where writings.book_id = books.id and writings.student = $student_id) > 0 then 'Ongoing' else 'Pending' end");
                }])
                ->where('id', $this->id)
                ->first();
        if($html){

            if($result->status == "Done"){
                return "<span class='text-info'>DONE</span>";
            }

            if($result->status == "Ongoing"){
                return "<span class='text-warning'>Ongoing</span>";
            }

            return "<span>Pending</span>";

        }else{
            $result->status;
        }
    }
}
