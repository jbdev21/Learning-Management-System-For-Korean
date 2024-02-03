<?php

namespace App\Observers;

use Notification;
use App\Models\User;
use App\Models\ComponentScore;
use App\Models\Writing;
use App\Notifications\Student\ComponentScoreNotification;

class ComponentScoreObserver
{
    /**
     * Handle the component score "created" event.
     *
     * @param  \App\Models\ComponentScore  $componentScore
     * @return void
     */
    public function created(ComponentScore $componentScore)
    {
        // $users = $componentScore->student->id;
        $writing = Writing::where('component_id', $componentScore->component_id)
                        ->where('book_id', $componentScore->book_id)
                        ->where('student', $componentScore->user_id)->first();
        if($writing){
            Notification::send($componentScore->student, new ComponentScoreNotification($componentScore, $writing));
        }
    }

    /**
     * Handle the component score "updated" event.
     *
     * @param  \App\Models\ComponentScore  $componentScore
     * @return void
     */
    public function updated(ComponentScore $componentScore)
    {
        $users = User::all();
        // Notification::send($users, new ComponentScoreNotification());
    }

    /**
     * Handle the component score "deleted" event.
     *
     * @param  \App\Models\ComponentScore  $componentScore
     * @return void
     */
    public function deleted(ComponentScore $componentScore)
    {
        //
    }

    /**
     * Handle the component score "restored" event.
     *
     * @param  \App\Models\ComponentScore  $componentScore
     * @return void
     */
    public function restored(ComponentScore $componentScore)
    {
        //
    }

    /**
     * Handle the component score "force deleted" event.
     *
     * @param  \App\Models\ComponentScore  $componentScore
     * @return void
     */
    public function forceDeleted(ComponentScore $componentScore)
    {
        //
    }
}