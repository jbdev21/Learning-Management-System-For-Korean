<?php

namespace App\Observers;

use Notification;
use App\Models\User;
use App\Models\Diary;
use App\Notifications\BackEnd\NewDiaryNotification;

class DiaryObserver
{
    /**
     * Handle the diary "created" event.
     *
     * @param  \App\Models\Diary  $diary
     * @return void
     */
    public function created(Diary $diary)
    {
        $teachers = $diary->user->studentTeachers();
        $admins = User::whereIn('type', ['administrator', 'super-administrator'])->get();
        Notification::send($teachers, new NewDiaryNotification($diary));
        Notification::send($admins, new NewDiaryNotification($diary));
    }

    /**
     * Handle the diary "updated" event.
     *
     * @param  \App\Models\Diary  $diary
     * @return void
     */
    public function updated(Diary $diary)
    {
        //
    }

    /**
     * Handle the diary "deleted" event.
     *
     * @param  \App\Models\Diary  $diary
     * @return void
     */
    public function deleted(Diary $diary)
    {
        //
    }

    /**
     * Handle the diary "restored" event.
     *
     * @param  \App\Models\Diary  $diary
     * @return void
     */
    public function restored(Diary $diary)
    {
        //
    }

    /**
     * Handle the diary "force deleted" event.
     *
     * @param  \App\Models\Diary  $diary
     * @return void
     */
    public function forceDeleted(Diary $diary)
    {
        //
    }
}
