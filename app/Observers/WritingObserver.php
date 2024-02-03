<?php

namespace App\Observers;

use App\Models\Writing;

class WritingObserver
{
    /**
     * Handle the writing "created" event.
     *
     * @param  \App\Models\Writing  $writing
     * @return void
     */
    public function created(Writing $writing)
    {
        // send notification
    }

    /**
     * Handle the writing "updated" event.
     *
     * @param  \App\Models\Writing  $writing
     * @return void
     */
    public function updated(Writing $writing)
    {
        // notification 
    }

    /**
     * Handle the writing "deleted" event.
     *
     * @param  \App\Models\Writing  $writing
     * @return void
     */
    public function deleted(Writing $writing)
    {
        // notification other that this item 
    }

    /**
     * Handle the writing "restored" event.
     *
     * @param  \App\Models\Writing  $writing
     * @return void
     */
    public function restored(Writing $writing)
    {
        //
    }

    /**
     * Handle the writing "force deleted" event.
     *
     * @param  \App\Models\Writing  $writing
     * @return void
     */
    public function forceDeleted(Writing $writing)
    {
        //
    }
}
