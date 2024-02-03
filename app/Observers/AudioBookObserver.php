<?php

namespace App\Observers;

use App\Jobs\AudioBookThumbnailChecker;
use Cache;
use App\Models\AudioBook;

class AudioBookObserver
{
    /**
     * Handle the audio book "created" event.
     *
     * @param  \App\App\Models\AudioBook  $audioBook
     * @return void
     */
    public function created(AudioBook $audioBook)
    {
        
    }

    /**
     * Handle the audio book "updated" event.
     *
     * @param  \App\App\Models\AudioBook  $audioBook
     * @return void
     */
    public function updated(AudioBook $audioBook)
    {
        $thumbnail = 'audiobook.' . $audioBook->id . '.thumbnail';
        $audiofiles = 'audiobook.' .$audioBook->id . '.audiofiles';
        Cache::forget($thumbnail);
        Cache::forget($audiofiles);
    }

    /**
     * Handle the audio book "deleted" event.
     *
     * @param  \App\App\Models\AudioBook  $audioBook
     * @return void
     */
    public function deleted(AudioBook $audioBook)
    {
        //
    }

    /**
     * Handle the audio book "restored" event.
     *
     * @param  \App\App\Models\AudioBook  $audioBook
     * @return void
     */
    public function restored(AudioBook $audioBook)
    {
        //
    }

    /**
     * Handle the audio book "force deleted" event.
     *
     * @param  \App\App\Models\AudioBook  $audioBook
     * @return void
     */
    public function forceDeleted(AudioBook $audioBook)
    {
        //
    }
}
