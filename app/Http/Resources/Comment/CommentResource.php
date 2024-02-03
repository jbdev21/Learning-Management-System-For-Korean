<?php

namespace App\Http\Resources\Comment;

use Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(Auth::user()){
            if(Auth::user()->id == $this->user_id){
                $canEdit = true;
            }else{
                if(Auth::user()->type != 'student'){
                    $canEdit = true;
                }else{
                    $canEdit = false;
                }
            }
        }else{
            $canEdit = false;
        }

        return [
            'id' => $this->id,
            'avatar' => $this->user->avatar,
            'name' => $this->user->name,
            'message' => $this->message,
            'origin'    => $this->origin,
            'editable' => $canEdit,
            'time' => $this->created_at->format('Y-m-d h:iA')
        ];
    }
}
