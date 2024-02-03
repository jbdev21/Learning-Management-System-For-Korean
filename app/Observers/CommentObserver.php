<?php

namespace App\Observers;

use Str;
use Notification;
use App\Models\Comment;
use App\Notifications\NewCommentNotification;

class CommentObserver
{
    public function created(Comment $comment){
        $user = $comment->user;
        $model = Str::singular($comment->commentable->getTable());

        if($user->type == "student"){
            //send to all teachers
            $data = [
                'link' => route("back-end.$model.show", $comment->commentable_id),
                'message' => $user->username . "($user->name)",
                'avatar' => $user->avatar,
            ];
            $recepients = $user->studentTeachers();
        }else{
            // send to all student
            $data = [
                'link' => route("student.$model.show", $comment->commentable_id),
                'message'=> $user->username . "($user->name)",
                'avatar' => $user->avatar,
            ];
            $recepients = $user->teacher_students;
        }
        
        Notification::send($recepients, new NewCommentNotification($data));
    }
}
