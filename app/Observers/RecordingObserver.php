<?php

namespace App\Observers;

use Notification;
use App\Models\User;
use App\Models\Recording;
use App\Notifications\BackEnd\NewRecordingNotification;

class RecordingObserver
{
    /**
     * Handle the recording "created" event.
     *
     * @param  \App\Models\Recording  $recording
     * @return void
     */
    public function created(Recording $recording)
    {
        $teachers = $diary->user->studentTeachers();
        $admins = User::whereIn('type', ['administrator', 'super-administrator'])->get();
        Notification::send($teachers, new NewRecordingNotification($recording));
        Notification::send($admins, new NewRecordingNotification($recording));
    }

    /**
     * Handle the recording "updated" event.
     *
     * @param  \App\Models\Recording  $recording
     * @return void
     */
    public function updated(Recording $recording)
    {
        //
    }

    /**
     * Handle the recording "deleted" event.
     *
     * @param  \App\Models\Recording  $recording
     * @return void
     */
    public function deleted(Recording $recording)
    {
        //
    }

    /**
     * Handle the recording "restored" event.
     *
     * @param  \App\Models\Recording  $recording
     * @return void
     */
    public function restored(Recording $recording)
    {
        //
    }

    /**
     * Handle the recording "force deleted" event.
     *
     * @param  \App\Models\Recording  $recording
     * @return void
     */
    public function forceDeleted(Recording $recording)
    {
        //
    }
}
