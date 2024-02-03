<?php
namespace App\Traits;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\Comment\CommentResource;

trait HasComment{

    function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }

    function commentList(){
        $comments =  $this->comments()->paginate(15);
        return CommentResource::collection($comments);
    }


    function sendComment(Request $request){
        $comment = new Comment;
        $comment->user_id = $request->user_id;
        $comment->message = $request->message;
        $comment->origin = "web";
        $this->comments()->save($comment);

        return new CommentResource($comment);
    }


    function deleteComment(Request $request){
        $comment = Comment::find($request->id);
        $comment->delete();
    }

}